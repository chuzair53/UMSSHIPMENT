<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shipment;
use App\Models\Shipper;
use App\Models\Packages;
use App\Models\History;
use App\Models\Driver;
use App\Models\ShipmentToDriver;
use Illuminate\Support\Str;
use PDF;
use Carbon\Carbon;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use Illuminate\Filesystem\Filesystem;

class AdminController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['auth', 'admin']);
    }

    public function index()
    {

    }
    public function dashboard()
    {

        $response = Shipment::with('shipper', 'user', 'driver.user')->latest()->paginate(999999);
        // $response = Shipment::with('shipper', 'user', 'driver.user')->where('slug', 'sclfjRG7')->first();
        $driver = User::where('user_type', 'driver')->get();

// dd($response->driver());
        return view('Backend.index', ['response' => $response, 'drivers' => $driver]);
    }
    public function getQty(Request $request){
     $response = Shipment::with('shipper')->latest()->paginate($request->qty_limit);

        return view('Backend.index', ['response' => $response]);
    }

    public function findShipment(Request $request)
    {
        if ($request->find_by == 'status') {
            $data = str_replace(' ', '-', $request->find_value);
            $response = Shipment::search($request->find_by, $data)->paginate(15);
            // return view('Backend.index', ['response' => $response]);
        } elseif ($request->find_by == 'tracking_number' || $request->find_by == 'order_number' || $request->find_by == 'post_code' || $request->find_by == 'customer_name') {
            $response = Shipment::search($request->find_by, $request->find_value)->paginate(15);

        } elseif($request->find_by == 'shipper_name'){

            $response = Shipment::whereHas('shipper', function ($query) use ($request) {
                        // dd($request->searchByText);
                        $query->where('shipper_name', $request->find_value);
                    })->paginate(15);


        } else {

            return  $this->dashboard();
        }
        return view('Backend.index', ['response' => $response]);
    }
    // Shipments Start
    public function createShipment()
    {
        $shipper = Shipper::latest()->get();
        $driver = User::where('user_type', 'driver')->latest()->get();
        return view('Backend.shipment', ['data' => $shipper, 'drivers' => $driver]);
    }

    public function storeShipment(Request $request)
    {

        $tracking_number = 'UMS-' . mt_rand(1, 99999999);
        // Set to yesterday

        $upload_date = Carbon::create($request->upload_date, 'Europe/London')->format('d/m/Y');

        $shipper = Shipper::where('slug', $request->shipper)->first();

        $data = new Shipment();
        $data->slug = Str::random(8);
        $data->user_id = Auth::user()->id;
        $data->tracking_number =  $tracking_number;
        $data->order_number = $request->order_number;
        $data->shipper_id = $shipper->id;
        $data->customer_name = $request->customer_name;
        $data->first_receiver_address = $request->first_receiver_address;
        $data->second_receiver_address = $request->second_receiver_address;
        $data->third_receiver_address = $request->third_receiver_address;
        $data->town_city = $request->town_city;
        $data->phone = $request->receiver_phone;
        $data->post_code = $request->receiver_post_code;
        $data->email = $request->receiver_email;
        $data->assign_date = $request->assign_date;
        $data->assign_time = $request->assign_time;
        $data->location = $request->assign_location;
        $data->status = $request->assign_status;
        $data->service = $request->service;
        $data->sku = $request->sku;
        $data->upload_date = $upload_date;
        $data->payment = $request->payment;
        $data->notes = $request->notes;


        $data->save();
        // Assign Shipment To Driver
        $driver = new ShipmentToDriver();
        $driver->shipment_id = $data->id;
        $driver->driver_id =  $request->assign_driver;
        $driver->save();

      //history
        $history = new History();
        $history->history_slug = Str::random(8);
        $history->history_date = $request->assign_date;
        $history->history_time = $request->assign_time;
        $history->history_location = $request->assign_location;
        $history->history_status = $request->assign_status;
        $data->history()->save($history);

        // Packages save
        $qty = $request->qty;
        $piece_type = $request->piece_type;
        $description = $request->description;
        $weight = $request->weight;
        $package_type = $request->package_type;


        for($i = 0; $i < count($qty); $i++) {
            $pkg = new Packages();
            $pkg->package_slug = Str::random(8);
            $pkg->description =  $description[$i];
            $pkg->qty = $qty[$i];
            $pkg->piece_type = $package_type[$i];
            $pkg->weight = $weight[$i];
            $pkg->package_type = $piece_type[$i];
            $data->package()->save($pkg);
        }

        // Mail::send('emails.orderShipped', $data, function($message) use ($data) {
        //     $message->to($data['email'])
        //     ->subject($data['subject']);
        //   });

        //   Mail::send('emails.orderShipped');

        return redirect('manage-shipment')->with('success',  $tracking_number);

    }

    public function editShipment($slug)
    {
        if ($slug != '') {
            $response = Shipment::where('slug', $slug)->with('package', 'history', 'shipper', 'driver')->first();

            $shippers = Shipper::latest()->get();
            $driver = User::where('user_type', 'driver')->get();

            return view('Backend.editForm.editShipment', ['response' => $response, 'shippers' => $shippers, 'drivers' => $driver]);
        }

        return redirect()->back();
    }
    public function updateShipment(Request $request)
    {

        $data = Shipment::where('slug', $request->slug)->with('history')->first();

        if($request->shipper != ''){

          $shipper =  Shipper::where('slug', $request->shipper)->first();

          Shipment::where('slug', $request->slug)->update(['shipper_id' => $shipper->id]);

        }
        if ($data->status != $request->status) {
          $his = History::where('shipment_id', $data->id)->where('history_status', $request->status)->first();

            if($his == ''){
            $history = new History();
            $history->history_slug = Str::random(8);
            $history->shipment_id = $data->id;
            $history->history_date = $request->assign_date;
            $history->history_time = $request->assign_time;
            $history->history_location = $request->location;
            $history->history_status = $request->status;
            $history->save();
            }
        }
        $data->fill($request->all());

        $changes = $data->getDirty();
        $data->save();

        $package = $request->only('edit_description', 'edit_qty', 'edit_piece_type', 'edit_weight', 'edit_package_type');
        if($request->package_slug != ''){

            foreach($request->package_slug as $key => $value) {
              Packages::where('package_slug', $request->package_slug[$key])
                  ->update([
                      'description' => $request->edit_description[$key],
                      'qty' => $request->edit_qty[$key],
                      'piece_type' => $request->edit_piece_type[$key],
                      'weight' => $request->edit_weight[$key],
                      'package_type' => $request->edit_package_type[$key],
                      ]);
            }
        }

        $history = $request->only('history_date', 'history_time', 'history_location', 'history_status', 'history_slug');

        if ($request->history_slug != '') {

            foreach ($request->history_slug as $key => $value) {

                $quarters = History::where('history_slug', $request->history_slug[$key])
                    ->update([
                        'history_date' => $request->history_date[$key],
                        'history_time' => $request->history_time[$key],
                        'history_location' => $request->history_location[$key],
                        'history_status' => $request->history_status[$key]
                    ]);
            }
        }

        if($request->history_delete != ''){
            foreach($request->history_delete as $key => $value){
                History::where('history_slug', $request->history_slug[$key])->delete();
            }
        }

        if($request->package_delete != ''){
            foreach($request->package_delete as $key => $value){
                Packages::where('package_slug', $request->package_delete[$key])->delete();
            }

        }
        if($request->assign_driver){

            $stod = ShipmentToDriver::where('shipment_id', $data->id)->first();
            if($stod != ''){
                $stod->update(['driver_id' => $request->assign_driver]);
            }else{
             $stod =  new ShipmentToDriver();
             $stod->shipment_id = $data->id;
             $stod->driver_id = $request->assign_driver;
             $stod->save();
            }


        }
      return redirect('manage-shipment')->with('success',  'Shipment Successfully Updated');

    }
    public function deleteShipment($slug)
    {
        if ($slug != '') {
            $data = Shipment::where('slug', $slug)->with('package', 'history', 'driver')->first();

            if ($data != '') {

                $data->package()->delete();
                $data->history()->delete();
                $data->driver()->delete();
                $data->delete();
            }
        }

        return redirect()->back();
    }

    //   Update Status From Dashboard
    public function updateStatus(Request $request)
    {
        $data = Shipment::where('tracking_number', $request->tracking_number)->first();

        $current_date = Carbon::now('Europe/London')->format('d/m/Y');
        $current_time = Carbon::now('Europe/London')->format('H:i');

         if($request->update_status == 'Entered-Into-System' || $request->update_status == 'Scanned-At-Depot'){
            //  dd($data);
          $data = Shipment::where('tracking_number', $request->tracking_number)->first();
            $shipper = Shipper::where('id', $data->shipper_id)->first();
            $data->update(['post_code' => $shipper->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();

         }elseif($request->update_status == 'Out-For-Delivery' || $request->update_status == 'Delivered'){

        $data = Shipment::where('tracking_number', $request->tracking_number)->first();

            Shipment::where('id', $data->id)->update(['post_code' => $data->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();

         }elseif($request->update_status == 'Failed' || $request->update_status == 'Returned'){
            Shipment::where('id', $data->id)->update(['post_code' => $data->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();
         }


            if($his == null){

        $history = new History();
        $history->history_slug = Str::random(8);
        $history->shipment_id = $data->id;
        $history->history_date =  $current_date;
        $history->history_time = $current_time;
        $history->history_location = $data->location;
        $history->history_status = $request->update_status;
        $history->save();

            }
      if($his){
       $his->update([
         'history_date' => $current_date,
         'history_time' => $current_time
       ]);
      }

        $data->update(['status' => $request->update_status,
                       'assign_date' => $current_date,
                       'assign_time' => $current_time
                      ]);
        return redirect()->back();
    }

    //Shipper Methods Start
    public function viewShipper()
    {
        $data = Shipper::latest()->paginate(999999);

        return view('Backend.viewShipper', ['data' => $data]);
    }
    public function findShipper(Request $request)
    {
        if ($request->find_by != '') {
            $response = Shipper::search($request->find_by, $request->find_value)->get();
            return view('Backend.viewShipper', ['data' => $response]);
        } else {

            return $this->viewShipper();
        }
    }
    public function createShipper()
    {
        return view('Backend.shipperForm');
    }
    public function storeShipper(Request $request)
    {
        $data = new Shipper();
        $data->slug = Str::random(8);
        $data->shipper_name = $request->shipper_name;
        $data->first_shipper_address = $request->first_shipper_address;
        $data->second_shipper_address = $request->second_shipper_address;
        $data->third_shipper_address = $request->third_shipper_address;
        $data->town_city = $request->town_city;
        $data->post_code = $request->shipper_post_code;
        $data->phone = $request->shipper_phone;
        $data->email = $request->shipper_email;
        $data->shipper_status = 'active';
        $data->save();


        return redirect('manage-shipper')->with('info', 'Shipper Saved Successfully');

    }
    public function editShipper($slug)
    {
        $data = Shipper::where('slug', $slug)->first();
        return view('Backend.editForm.editshipper', ['data' => $data]);
    }
    public function updateShipper(Request $request)
    {
        if ($request->slug != '') {
            Shipper::where('slug', $request->slug)->update([
                'shipper_name' => $request->shipper_name,
                'first_shipper_address' => $request->first_shipper_address,
                'second_shipper_address' => $request->second_shipper_address,
                'third_shipper_address' => $request->third_shipper_address,
                'town_city' => $request->town_city,
                'phone' => $request->shipper_phone,
                'post_code' => $request->shipper_post_code,
                'email' => $request->shipper_email

            ]);
        } else {
            return redirect()->back();
        }
        return redirect('manage-shipper')->with('info', 'Shipper Successfully Update');

    }
    public function deleteShipper($slug)
    {
        $data = shipper::where('slug', $slug)->first();
        if ($data != '') {
            $data->delete();
        }
        return redirect()->back();
    }
    // Shipper method end


    // Manage Admin
    public function viewAdmin()
    {
        $data = User::where('user_type', 'admin')->paginate(9999);
        return view('Backend.viewAdmin', ['data' => $data]);
    }
    public function editAdmin($slug)
    {
        $data = User::where('id', $slug)->first();
        if ($data != '') {
            return view('Backend.editForm.editUser', ['data' => $data]);
        }
    }
    public function updateAdmin(Request $request)
    {
      if($request->new_password != ''){
            $pass = Hash::make($request->new_password);
            User::where('id', $request->id)->update(['password' => $pass]);
        }
        User::where('id', $request->id)->update(['name' => $request->name, 'email' => $request->email, 'acc_status' => $request->acc_status]);
        return redirect('manage-admin')->with('info', 'Admin Successfully Update');

    }
    public function deleteAdmin($slug)
    {
      $user = Auth::user();
    
      if($user->id){
        $data = User::where('id', $slug)->first();
      
        if ($data != '') {
            $data->delete();
        }

        }
        return redirect()->back();
    }



    // For Admin & Front User
    public function fullShipment(Request $request, $slug = null){
        if ($request->post_code != '') {
            $data = Shipment::where('order_number', $request->tracking_number)->where('post_code', $request->post_code)->with('history', 'package')->first();
        }
        if ($slug != '') {
            $data = Shipment::where('slug', $slug)->with('history', 'package', 'driver.driverInfo.attachment')->first();
            // dd($data);
        }

        if ($data != ''){

          return view('Frontend.shipmentview', ['data' => $data]);

        }else{
          return redirect()->back()->with('info',  'Please enter a valid tracking number & postcode');
        }

    }

    public function deliveryNote($slug){

    if($slug != ''){
        $data = Shipment::where('slug', $slug)->with('package')->first();

        $pdf = PDF::loadView('Backend.deliveryNote', ['data' => $data]);


    $filename = "Delivery-Note-".$data->tracking_number;
         return $pdf->download($filename.'.pdf');
    }
      return redirect()->back();
    }


  public function bulkData(Request $request){

      if($request->slug_selector == ''){
        return redirect()->back()->with('info');
      }



    if($request->bulk_print == 'bulk_select'){
        $url = $request->slug_selector;
      if($url != ''){

    $pdfMerger = PDFMerger::init();
       foreach ($request->slug_selector as $key => $value) {


        $data = Shipment::where('slug', $value)->with('package')->first();
        $pdf = PDF::loadView('Backend.deliveryNote', ['data' => $data]);

         $filename = "Delivery-Note-".$data->tracking_number;
         $pdf->save('storage/app/public/temp/'.$filename.'.pdf');
         $pdfMerger->addPDF(('storage/app/public/temp/'.$filename.'.pdf'), 'all');
      }
      $pdfMerger->merge();
      $newFile = Str::random(6);
      $pdfMerger->save(base_path('storage/app/public/final/BedDrop-'.$newFile.'-final.pdf'), "file");

    //   Delete temp pdf files
    $file = new Filesystem;
    $file->cleanDirectory('storage/app/public/temp');
// return response
      return response()->download(base_path('storage/app/public/final/BedDrop-'.$newFile.'-final.pdf'));

      }
    return redirect()->back();
          }


    if($request->bulk_delete == 'bulk_delete'){
          $url = $request->slug_selector;
      if($url != ''){
       foreach ($request->slug_selector as $key => $value) {
         $shipment = Shipment::where('slug', $request->slug_selector[$key])->with('package','history')->first();
         $shipment->package()->delete();
         $shipment->history()->delete();
         $shipment->delete();
       }
      }

    }

  if($request->bulk_status_update == 'bulk_status_update'){

    // $request->update_status;
    foreach($request->slug_selector as $slug){
        $data = Shipment::where('slug', $slug)->first();
        // dd($data);
        $current_date = Carbon::now('Europe/London')->format('d/m/Y');
        $current_time = Carbon::now('Europe/London')->format('H:i');

         if($request->update_status == 'Entered-Into-System' || $request->update_status == 'Scanned-At-Depot'){

            $shipper = Shipper::where('id', $data->shipper_id)->first();
            $data->update(['post_code' => $shipper->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();

         }elseif($request->update_status == 'Out-For-Delivery' || $request->update_status == 'Delivered'){



            Shipment::where('id', $data->id)->update(['post_code' => $data->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();

         }elseif($request->update_status == 'Failed' || $request->update_status == 'Returned'){
            Shipment::where('id', $data->id)->update(['post_code' => $data->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();
         }


            if($his == null){

        $history = new History();
        $history->history_slug = Str::random(8);
        $history->shipment_id = $data->id;
        $history->history_date =  $current_date;
        $history->history_time = $current_time;
        $history->history_location = $data->location;
        $history->history_status = $request->update_status;
        $history->save();

            }
      if($his){
       $his->update([
         'history_date' => $current_date,
         'history_time' => $current_time
       ]);
      }

        $data->update(['status' => $request->update_status,
                       'assign_date' => $current_date,
                       'assign_time' => $current_time
                      ]);
    }


  }
//   Bulk driver Assign
  if($request->bulk_driver_update == "bulk_driver_update"){

    foreach($request->slug_selector as $slug){
        $data = Shipment::where('slug', $slug)->first();
       $stod = ShipmentToDriver::where('shipment_id', $data->id)->first();
       if($stod != ''){
           $stod->update(['driver_id' => $request->assign_driver]);
       }else{
        $stod =  new ShipmentToDriver();
        $stod->shipment_id = $data->id;
        $stod->driver_id = $request->assign_driver;
        $stod->save();
       }

    }
  }
//   driver assign end

    return redirect()->back();

  }

// Driver
public function viewDriver()
{
    $data = User::where('user_type', 'driver')->paginate(9999);
    return view('Backend.viewDriver', ['data' => $data]);
}

public function createDriver()
{
    return view('Backend.driver');
}

public function storeDriver(Request $request)
{

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->phone = $request->phone;
    $user->user_type = $request->user_type;
    $user->acc_status = $request->acc_status;
    $user->save();
    // dd($request->all());
   return redirect()->back();

}

public function editDriver($uid)
{
    $data = User::where('id', $uid)->first();
    return view('Backend.editForm.editDriver', ['data' => $data]);
}

public function updateDriver(Request $request)
{
    User::where('id', $request->user_id)->update(['name' => $request->name, 'email' => $request->email, 'phone' => $request->phone, 'acc_status' => $request->acc_status]);

    if($request->password != ''){
      $pass =  Hash::make($request->password);
      User::where('id', $request->user_id)->update(['password' => $pass]);
    }
    return redirect('manage-driver');
}
public function updateAssignDriver(Request $request)
{

    if($request->shipment_id != ''){

   $sid = Shipment::where('tracking_number', $request->shipment_id)->with('driver')->first();

    ShipmentToDriver::where('shipment_id', $sid->id)->update(['driver_id' => $request->driver_id]);

}
    return redirect('manage-shipment');
}


}

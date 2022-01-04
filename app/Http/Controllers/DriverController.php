<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Shipper;
use App\Models\Packages;
use App\Models\History;
use App\Models\ShipmentToDriver;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
    
        $response = ShipmentToDriver::where('driver_id', $user->id)->with('shipment', 'shipment.shipper')->latest()->paginate(999999);
  
        return view('Backend.driverShipment', ['response' => $response]);
    }

    public function editShipment($slug)
    {
        $response = Shipment::where('slug', $slug)->with('package', 'history', 'shipper')->first();
        // dd($response);
        return view('Backend.editForm.editDriverStatus', ['data' => $response]);
    }
    public function updateShipment(Request $request)
    {  


        $data = Shipment::where('tracking_number', $request->tracking_number)->first();
      
        $current_date = Carbon::now('Europe/London')->format('d/m/Y');
        $current_time = Carbon::now('Europe/London')->format('H:i');

         if($request->update_status == 'Entered-Into-System' || $request->update_status == 'Scanned-At-Depot'){
            //  dd($data);
            // $data = Shipment::where('tracking_number', $request->tracking_number)->first();
            $shipper = Shipper::where('id', $data->shipper_id)->first();
            $data->update(['post_code' => $shipper->post_code]);
            $his = History::where('shipment_id', $data->id)->where('history_status', $request->update_status)->first();

         }elseif($request->update_status == 'Delivered'){

          
          
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

                      $uid = Str::random(12);
                      $driver = new Driver();
                      $driver->driver_id = Auth::user()->id;
                      $driver->shipment_id = $request->shipment_id;
                      $driver->attachment_id = $uid;
                      $driver->notes = $request->driver_note;
                    //   $driver->save();

                    if ($request->file('files')) {
                 
                        $files = $request->file('files');
                        foreach ($files as $file) {
                           
            
                            $filename = $file->getClientOriginalName();
                            // $filesize = $file->getClientSize();
                            $fn = new Attachment();
                            $fn->slug = Str::random(8);
                            $fn->attachment_id = $uid;
                            $fn->file_name = $filename;
                            $fn->save();
                            $file->storeAs('', $filename);
            
                        }                       
                        $driver->save();
            
                    }


        return redirect()->back();
    }
    public function downloadAttachment($slug)
    {
        $file = Attachment::where('slug', $slug)->first();
      
        if($file != ''){
            $path = storage_path("/app/public/attachments/" . $file->file_name);
       

            return response()->download($path);
        }
  
    }

    

    
}

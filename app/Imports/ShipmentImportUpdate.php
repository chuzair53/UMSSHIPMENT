<?php

namespace App\Imports;

use App\Models\History;
use App\Models\Shipment;
use App\Models\Packages;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Shipper;
use Facade\Ignition\Support\Packagist\Package;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;


class ShipmentImportUpdate implements ToCollection, WithHeadingRow
{
    use Importable;


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row['upload_date'] != ''){
                $upload_date = $row['upload_date'];
              $stringfinal = Date::excelToDateTimeObject($upload_date)->format('d-m-Y');
              $uploadDate = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
            }else{
              $uploadDate = Carbon::now('Europe/London')->subDays(1)->format('d/m/Y');
            }
          
            $shipper = Shipper::where('shipper_name', $row['shipper'])->first();
            $ship = Shipment::where('order_number', $row['order_number'])->first();
            $history = History::where('shipment_id', $ship->id)->first();
            $package = Packages::where('shipment_id', $ship->id)->first();

            if($package == ''){
                $package_slug = '';
                // $description = '';
                // $qty = '';
                // $piece_type = '';
                // $weight = '';
                // $package_type = '';
            }else{
                $package_slug = $package->package_slug;  
            }

            Shipment::where('order_number', $row['order_number'])->update([
            'slug' =>   $ship->slug,
            'tracking_number' =>  $ship->tracking_number,
            'shipper_id' => $shipper->id,
            'customer_name' => $row['customer_name'],
            'first_receiver_address' => $row['first_line_add'],
            'second_receiver_address' => $row['second_line_add'],
            'third_receiver_address' => $row['third_line_add'],
            'town_city' => $row['town_city'],
            'post_code' => $row['postcode'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            // 'status' => $row['status'],
            'service' => $row['service'],
            'order_number' => $row['order_number'],
            'sku' => $row['sku'],
            'upload_date' =>  $uploadDate,
            'payment' => $row['payment'],
            'notes' => $row['notes'],
            ]);
            
            Packages::where('shipment_id', $ship->id)->update([
                'package_slug' => $package_slug,
                'description' => $row['product_name'],
                'qty' => $row['qty'],
                'piece_type' => $row['pieces'],
                'weight' => $row['weight'],
                'package_type' => $row['type'],
            ]);
          
           

            if($row['scanned_at_depot'] != ''){
                
                $ud = $row['scanned_at_depot'];
                $stringfinal = Date::excelToDateTimeObject($ud)->format('d-m-Y');
                $his_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
                
                History::where('shipment_id', $ship->id)->where('history_status', 'Scanned-At-Depot')->update([
                    'history_slug' => $history->history_slug,
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Scanned-At-Depot',
                ]);
          
               
              
            }
            if($row['out_for_delivery'] != ''){
                $ud = $row['out_for_delivery'];

                $stringfinal = Date::excelToDateTimeObject($ud)->format('d-m-Y');
                $his_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
                
                History::where('shipment_id', $ship->id)->where('history_status', 'Out-For-Delivery')->update([
                    'history_slug' => $history->history_slug,
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Out-For-Delivery',
                ]);
            }
            if($row['delivered'] != ''){
               
                $ud = $row['delivered'];
     
                $stringfinal = Date::excelToDateTimeObject($ud)->format('d-m-Y');
                $his_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
                
                History::where('shipment_id', $ship->id)->where('history_status', 'Delivered')->update([
                    'history_slug' => $history->history_slug,
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Delivered',
                    ]);


            }
            if($row['failed'] != ''){

                $ud = $row['failed'];
               
                $stringfinal = Date::excelToDateTimeObject($ud)->format('d-m-Y');
                $his_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
                
                History::where('shipment_id', $ship->id)->where('history_status', 'Failed')->update([
                    'history_slug' => $history->history_slug,
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Failed',
                    ]);

            }
            if($row['returned'] != ''){
                $ud = $row['returned'];
               
                $stringfinal = Date::excelToDateTimeObject($ud)->format('d-m-Y');
                $his_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
                
                History::where('shipment_id', $ship->id)->where('history_status', 'Returned')->update([
                    'history_slug' => $history->history_slug,
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Returned',
                    ]);

            }
        }
    }

    
}

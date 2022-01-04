<?php

namespace App\Imports;

use App\Models\Shipment;

use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Shipper;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;


class ShipmentImport implements ToCollection, WithHeadingRow
{
    use Importable;


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row['upload_date'] != ''){
              $udate = $row['upload_date'];
              $stringfinal = Date::excelToDateTimeObject($udate)->format('d-m-Y');
              $upload_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
            }else{
              $upload_date = Carbon::now('Europe/London')->format('d/m/Y');
            }
            
            if($row['created_by'] != ''){
              $user = User::where('name', $row['created_by'])->first;
            }
          
            $shipper = Shipper::where('shipper_name', $row['shipper'])->first();

        $data = Shipment::create([
            'slug' =>  Str::random(8),
            'user_id' => $user->id,
            'tracking_number' => 'BD-'.mt_rand(1, 99999999),
            'shipper_id' => $shipper->id,
            'customer_name' => $row['customer_name'],
            'first_receiver_address' => $row['first_line_add'],
            'second_receiver_address' => $row['second_line_add'],
            'third_receiver_address' => $row['third_line_add'],
            'town_city' => $row['town_city'],
            'post_code' => $row['postcode'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'status' => 'Entered-Into-System',
            'service' => $row['service'],
            'order_number' => $row['order_number'],
            'sku' => $row['sku'],
            'upload_date' =>  $upload_date,
            'payment' => $row['payment'],
            'notes' => $row['notes'],
            ]);
          
            $data->package()->create([
                'package_slug' => Str::random(8),
                'description' => $row['product_name'],
                'qty' => $row['qty'],
                'piece_type' => $row['pieces'],
                'weight' => $row['weight'],
                'package_type' => $row['type'],
            ]);
          
           $data->history()->create([
                'history_slug' => Str::random(8),
                'history_date' => $upload_date,
                'history_time' => '',
                'history_location' => '',
                'history_status' => 'Entered-Into-System',
            ]);

            if($row['scanned_at_depot'] != ''){
                
                $ud = $row['scanned_at_depot'];
              
                $stringfinal = Date::excelToDateTimeObject($ud)->format('d-m-Y');
                $his_date = Carbon::create($stringfinal, 'Europe/London')->format('d/m/Y');
                
                $data->history()->create([
                    'history_slug' => Str::random(8),
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Scanned-At-Depot',
                ]);
          
               
              
            }
            if($row['out_for_delivery'] != ''){
                $ud = $row['out_for_delivery'];
             
                $his_date = Carbon::create($ud, 'Europe/London')->format('d/m/Y');
                
                $data->history()->create([
                    'history_slug' => Str::random(8),
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Out-For-Delivery',
                ]);
            }
            if($row['delivered'] != ''){
               
                $ud = $row['delivered'];
     
                $his_date = Carbon::create($ud, 'Europe/London')->format('d/m/Y');
                
                $data->history()->create([
                    'history_slug' => Str::random(8),
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Delivered',
                    ]);


            }
            if($row['failed'] != ''){

                $ud = $row['failed'];
               
                $his_date = Carbon::create($ud, 'Europe/London')->format('d/m/Y');
                
                $data->history()->create([
                    'history_slug' => Str::random(8),
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Failed',
                    ]);

            }
            if($row['returned'] != ''){
                $ud = $row['returned'];
               
                $his_date = Carbon::create($ud, 'Europe/London')->format('d/m/Y');
                
                $data->history()->create([
                    'history_slug' => Str::random(8),
                    'history_date' => $his_date,
                    'history_time' => '',
                    'history_location' => '',
                    'history_status' => 'Returned',
                    ]);
            }
           
        }
    }

    
}

<?php

namespace App\Exports;
use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ShipmentExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Shipment::with('shipper', 'package')->get();
    }

    public function map($data): array
    {
        return [
          $data->shipper->shipper_name,
          $data->order_number,
          $data->customer_name,
          $data->first_receiver_address,
          $data->second_receiver_address,
          $data->third_receiver_address,
          $data->town_city,
          $data->post_code,
          $data->phone,
          $data->email,
          $data->status,
          $data->package->description,
          $data->notes,
          $data->package->qty,
          $data->package->piece_type,
          $data->package->weight,
          $data->package->package_type,
          $data->service,
          $data->sku,
          $data->upload_date,
          $data->payment

        ];
    }
    public function headings(): array
    {
       return [
      'shipper',
      'order_number',
      'customer_name',
      'first_line_add',
      'second_line_add',
      'third_line_add',
      'town_city',
      'postcode',
      'phone',
      'email',
      'status',
      'product_name',
      'notes',
      'qty',
      'pieces',
      'weight',
      'type',
      'service',
      'sku',
      'upload_date',
      'payment'
       ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
          $event->sheet->getStyle('A1:U1')->applyFromArray([
              'font' => [
                'bold' => true
              ]
          ]);
        }
        ];
   

    }
}

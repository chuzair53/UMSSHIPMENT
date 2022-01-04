<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shipper;
use App\Imports\ShipmentImport;
use App\Exports\ShipmentExport;
use App\Imports\ShipmentImportUpdate;
use Carbon\Carbon;
class ShipmentController extends Controller
{
 
    public function index()
    {
        return view('Backend.viewImportExport');
    }
    
    // For Import
    public function store(Request $request)
    {
        $file = $request->file('file')->store('import', 'local');

        Excel::import(new ShipmentImport, $file);

        return back()->with('status', 'Excel file imported!');
     
    }
    // For Import Update
    public function importUpdatePage()
    {
        return view('Backend.viewImportUpdate');
    }
    public function importUpdate(Request $request)
    {
        $file = $request->file('file')->store('import', 'local');

        Excel::import(new ShipmentImportUpdate, $file);

        return back()->with('status', 'Excel file records update!');
    }
    // export
    public function export()
    {
        return Excel::download(new ShipmentExport, 'shipment.xlsx');
    }

    public function shipper($slug)
    {
       $data =  Shipper::where('slug', $slug)->latest()->get();
        
       return response()->json($data, 200);
    }

    public function downloadSample()
    {
        $path = storage_path('app/public/' . 'shipment-sample.xlsx');
        return response()->download($path, 'shipment-sample.xlsx');
    }

   

}

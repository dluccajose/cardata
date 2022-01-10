<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\CityCarImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\WithEvents;

class BulkUploadController extends Controller
{


    function index()
    {
        return view('admin.bulk-upload.index');
    }

    function upload(Request $request)
    {
        $files = $request->allFiles()['files'];

        $carsCount = 0;

        $newCarsCount = 0;

        foreach ($files as $i => $file) {
            $citiyCarImport = new CityCarImport();
            
            Excel::import($citiyCarImport, $file);

            $carsCount += $citiyCarImport->getCarsCount();

            $newCarsCount += $citiyCarImport->getNewCarsCount();
        }

        Session::flash('bulkupload.success', [
            'carsCount' => $carsCount,
            'newCarsCount' => $newCarsCount,
        ]);

        return redirect()->route('bulk-upload.index');
    }
}

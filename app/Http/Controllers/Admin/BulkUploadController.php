<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Imports\CityCarImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadController extends Controller
{
    function index()
    {
        return view('admin.bulk-upload.index');
    }

    function upload(Request $request)
    {
        $files = $request->allFiles();

        foreach ($files as $file) {
            $results[]  = Excel::import(new CityCarImport, $file[0]);
        }

        dd($results);
    }
}

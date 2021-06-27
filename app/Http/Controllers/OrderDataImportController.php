<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;

class OrderDataImportController extends Controller
{

    public function __construct()
    {
        ini_set('upload_max_filesize', '20M');
    }

    public function import(Request $request)
    {
        // Validate csv file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

//            chunk file if large data set
        $chunkedFileData = array_chunk(file($request->csv_file), 800);
        $this->executeDataImport($chunkedFileData);

        return true;
    }

    //separate service method
    public function executeDataImport(array $chunks)
    {
        // head of each chunk
        $head = [];
        foreach ($chunks as $key => $chunk) {
            // array of csv data
            $data = array_map('str_getcsv', $chunk);

            // set head
            if ($key === 0) {
                $head = $data[0];
                unset($data[0]);
            }

            //testing data
            logger()->info('chunk_id => ' . $key, $data);
        }

    }
}

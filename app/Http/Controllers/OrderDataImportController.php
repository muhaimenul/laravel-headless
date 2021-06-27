<?php

namespace App\Http\Controllers;

use App\Jobs\StoreChunkedOrderData;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;

class OrderDataImportController extends Controller
{

    public function __construct()
    {
        ini_set('upload_max_filesize', '20M');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function import(Request $request)
    {
        // Validate csv file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        try {
            //            chunk file if large data set
            $chunkedFileData = array_chunk(file($request->csv_file), 800);
            $batchData = $this->executeDataImport($chunkedFileData);
            return response()->json($batchData);
        } catch (\Exception $e) {
            throw $e;
        }

    }


    /**
     * separate service method
     * @param array $chunks
     * @return \Illuminate\Bus\Batch
     * @throws \Throwable
     */
    public function executeDataImport(array $chunks)
    {
        // header column of file
        $file_header = [];

        //initiating batch jobs array
        $batch = Bus::batch([])->dispatch();

        foreach ($chunks as $key => $chunk) {
            // array of csv data
            $data = array_map('str_getcsv', $chunk);

            // set head
            if ($key === 0) {
                $file_header = $data[0];
                unset($data[0]);
            }

            $batch->add(new StoreChunkedOrderData([
                'orders' => $data,
                'columns' => $this->transformKeys($file_header)
            ]));

        }

        return $batch;

    }

    public function batchDetails($id)
    {
        return response()->json(Bus::findBatch($id));
    }

    public function transformKeys(&$array)
    {
        foreach (array_keys($array) as $key):
            # Working with references here to avoid copying the value,
            # since you said your data is quite large.
            $value = &$array[$key];
            unset($array[$key]);
            # This is what you actually want to do with your keys:
            #  - remove exclamation marks at the front
            #  - camelCase to snake_case
            $transformedKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', ltrim($key, '!')));
            # Work recursively
            if (is_array($value)) $this->transformKeys($value);
            # Store with new key
            $array[$transformedKey] = $value;
            # Do not forget to unset references!
            unset($value);
        endforeach;
    }
}

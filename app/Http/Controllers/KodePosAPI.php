<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KodePosAPI extends Controller
{
    public function search(Request $request){
        $postalCode = $request->query('postalCode');
        $results = $this->findPostalCode($postalCode);
    
        if (count($results) > 0) {
            return response()->json([
                'status' => '200',
                'message' => 'Data retrieved successfully',
                'data' => $results
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'No data found for the provided postal code',
                'data' => []
            ], 404); 
        }
    }
    

    private function findPostalCode($postalCode){
        $fileKodePos = resource_path('data/kodepos.json');
        $json = file_get_contents($fileKodePos);
        $data = json_decode($json, true);
    
        $results = array_filter($data, function($item) use ($postalCode){
            return $item['code'] == $postalCode;
        });
    
        return array_values($results);
    }   
}

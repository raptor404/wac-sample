<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helpers
{
    public static function jsonApiResponse($name, &$data, $metaDataArg, $responseCode )
    {
        $headers = [

        ];

        $metaData = [
            'name'=> $name,
            'recordCount'=> count($data),
            'requestTime'=> Carbon::now()->toAtomString(),
        ];

        $outputData = [
            'metaData'=> array_merge($metaData, $metaDataArg),
            'data'=> $data
        ];

        return response()->json($outputData, $responseCode, $headers);
    }
}

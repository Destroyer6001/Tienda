<?php

namespace App\Responses;

class apiResponse{

    public static function success($message = "Success", $statusCode = 200, $data = [])
    {
        return response()->json([
            'message' => $message,
            'statusCode' => $statusCode,
            'error' => false,
            'data' => $data
        ],$statusCode);
    }

    public static function error($message = "Error", $statusCode = 500, $data = [])
    {
        return response()->json([
            'message' => $message,
            'statusCode' => $statusCode,
            'error' => true,
            'data' => $data 
        ],$statusCode);
    }
}
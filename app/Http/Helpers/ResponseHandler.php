<?php

namespace App\Http\Helpers;

class ResponseHandler
{
    public static function getJsonStatusResponse($status, $message)
    {
        return response()->json(['status' => $status, 'message' => $message]);
    }

    public static function getJsonResultResponse($status, $message, $result = [])
    {
        return response()->json(array_merge(['status' => $status, 'message' => $message], $result));
    }
}

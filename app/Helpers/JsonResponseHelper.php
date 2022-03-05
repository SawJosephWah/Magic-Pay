<?php

function api_success($message,$data){
    return response()->json([
        'result' => 1 ,
        'message' => $message,
        'data' => $data
    ]);
}

function api_fail($message,$data){
    return response()->json([
        'result' => 0 ,
        'message' => $message,
        'data' => $data
    ]);
}

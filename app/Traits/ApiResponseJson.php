<?php

namespace App\Core\Traits;

trait ApiResponseJson
{


    protected function successResponse($data = null, $code = 200)
    {
        if (is_null($data)) {
            return response()->json([
                'message'   => 'common.successfully'
            ], $code);
        }
        return response()->json([
            'message'   => 'common.successfully',
            'data'      => $data,
        ], $code);
    }
   
    protected function errorResponse($id, $params, $errors = [], $code = 400)
    {
        $response = [
            'id'        => $id,
            'params'    => $params,
            'errors'    => $errors,
        ];

        return response()->json($response, $code);
    }
   
    protected function validateErrorResponse($errors, $code = 422)
    {
        $response = [
            'id'        => "common.validation",
            'params'    => [],
            'errors'    => $errors,
        ];

        return response()->json($response, $code);
    }



}
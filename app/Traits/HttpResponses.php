<?php

namespace App\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;

trait HttpResponses
{
    protected function success($data, $message = null, $code = 200)
    {
        if (is_scalar($data)) {
            $data = ['data' => $data];
        } elseif ($data instanceof Arrayable) {
            $data = ['data' => $data->toArray()];
        } elseif ($data instanceof ResourceCollection) {
            $data = $data->response()->getData(true);

            $temp = Arr::pull($data, 'data');

            $data = array_merge(['data' => $temp], $data);
        } elseif ($data instanceof JsonResource) {
            $data = $data->response()->getData(true);
        }

        $default = [
            'status' => 'Request was successful.',
            'message' => $message,
        ];

        $data = array_merge($default, $data);

        return Response::json($data, $code, []);
    }

    protected function error($data, $message, $code)
    {
        return response()->json([
            'status' => 'Error has occured...',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HTTPStatus;

trait APIResponse
{
    /**
     * @param mixed $messages
     */
    public function responseSuccess($messages = ['Success !'], int $status = HTTPStatus::HTTP_OK): JsonResponse
    {
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        return Response::json([
            'messages' => $messages,
            'status' => $status,
        ], $status);
    }

    /**
     * @param mixed $messages
     * @param mixed $data
     *///HTTPStatus::HTTP_OK
    public function responseSuccessWithData($data, $messages = ['Success !'], int $status = 200): JsonResponse
    {
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        return Response::json([
            'data' => $data,
            'messages' => $messages,
            'status' => $status,
        ], $status);
    }

    /**
     * @param mixed $messages
     */
    public function responseError($messages = ['Failed !'], int $status = HTTPStatus::HTTP_BAD_REQUEST): JsonResponse
    {
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        return Response::json([
            'messages' => $messages,
            'status' => $status,
        ], $status);
    }

    /**
     * @param string $messages
     * @param mixed $errors
     */
    public function responseErrorWithData($errors, $messages = ['Failed !'], int $status = HTTPStatus::HTTP_BAD_REQUEST): JsonResponse
    {
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        return Response::json([
            'errors' => $errors,
            'messages' => $messages,
            'status' => $status,
        ], $status);
    }

    public function responseErrorValidate($errors, $validator, int $status = HTTPStatus::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'messages' => $errors,
            'status' => $status,
        ], 422));
    }
}


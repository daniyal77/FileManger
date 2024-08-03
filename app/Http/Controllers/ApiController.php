<?php

namespace App\Http\Controllers;

use App\Exceptions\DaniyalException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function successMessage(string $message): JsonResponse
    {
        return response()->json(['message' => $message]);
    }

    public function errorMessage(string $message): JsonResponse
    {
        return response()->json(['message' => $message], 422);
    }

    public function respond(array $dataMessage): JsonResponse
    {
        return response()->json($dataMessage);
    }

    public function notFoundMessage(): JsonResponse
    {
        return response()->json(['message' => "صفحه مورد نظر یافت نشد"], 404);
    }

    public function forbiddenMessage(): JsonResponse
    {
        return response()->json(['message' => "شما مجوز دسترسی ندارید"], 403);
    }

    public function unauthorizedMessage(): JsonResponse
    {
        $data = ['message' => "لطفا مجددا وارد سیستم شوید"];
        return response()->json($data, 401);
    }

    public function manyRequestMessage(): JsonResponse
    {
        return response()->json(['message' => "درخواست شما بیش از حد مجاز است"], 429);
    }

    public function errorServerMessage(): JsonResponse
    {
        return response()->json(['message' => "لطفا با پشتیبانی تماس بگیرید"], 500);
    }

    public function respondExceptionError(\Exception $e, $LogChanelName = null): JsonResponse
    {
        if ($e instanceof DaniyalException)
            return $this->errorMessage($e->getMessage());

        elseif ($e instanceof ModelNotFoundException)
            return $this->notFoundMessage();

        if ($LogChanelName)
            Log::channel($LogChanelName)->error($e->getMessage() . '::' . $e->getTraceAsString());
        else
            Log::error($e->getMessage() . '::' . $e->getTraceAsString());
        return $this->errorServerMessage();
    }

}

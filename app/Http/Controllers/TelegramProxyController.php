<?php

namespace App\Http\Controllers;

use Exception;
use Telegram\Bot\Api;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramProxyController extends Controller
{
    /**
     * Hiển thị tài liệu HTML tại trang chủ.
     */
    public function index()
    {
        return view('doc');
    }

    /**
     * Proxy tất cả yêu cầu đến Telegram Bot API.
     * @throws TelegramSDKException
     */
    public function proxy(Request $request, string $token, ?string $method = null): Response
    {
        try {
            $telegram = new Api($token);

            if (!$method) {
                return response()->json(['error' => 'Method is required'], 400);
            }

            $response = $telegram->$method($request->all());
            $data['result'] = $response;
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error proxying request',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}


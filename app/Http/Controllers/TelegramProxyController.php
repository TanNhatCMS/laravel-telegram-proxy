<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TelegramProxyController extends Controller
{
    /**
     * Hiển thị tài liệu HTML tại trang chủ.
     */
    public function index()
    {
        return view('doc')
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Proxy tất cả yêu cầu đến Telegram Bot API.
     */
    public function proxy(Request $request, string $token, ?string $method = null): Response
    {
        $telegramUrl = "https://api.telegram.org/bot{$token}";
        if ($method) {
            $telegramUrl .= '/' . $method;
        }

        try {
            $forwarded = Http::withHeaders($request->headers->all())
                ->withBody($request->getContent(), $request->header('Content-Type', 'application/json'))
                ->send($request->method(), $telegramUrl, [
                    'query' => $request->query(),
                ]);

            return response($forwarded->body(), $forwarded->status())
                ->withHeaders([
                    'Content-Type' => $forwarded->header('Content-Type', 'application/json'),
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type',
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error proxying request',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}


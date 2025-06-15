<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlyEnvProxyController extends Controller
{
    private string $baseUrl = 'https://api.macphpstudy.com';

    private function proxy(Request $request, string $endpoint): ?JsonResponse
    {
        Log::info("📥 POST → $endpoint", $request->all());

        try {
            $response = Http::post($this->baseUrl . $endpoint, $request->all());

            Log::info("📤 Response ← $endpoint", [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Throwable $e) {
            Log::error("❌ Proxy error at $endpoint: " . $e->getMessage());

            return response()->json([
                'error' => 'Proxy failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function start(Request $request): ?JsonResponse
    {
        return $this->proxy($request, '/api/app/start');
    }

    public function feedback(Request $request): ?JsonResponse
    {
        return $this->proxy($request, '/api/app/feedback_app');
    }

    public function fetchVersion(Request $request): ?JsonResponse
    {
        return $this->proxy($request, '/api/version/fetch');
    }

    public function phpExtension(Request $request): ?JsonResponse
    {
        return $this->proxy($request, '/api/version/php_extension');
    }
}


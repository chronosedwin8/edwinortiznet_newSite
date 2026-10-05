<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

final class ErrorController extends Controller
{
    public function error(Request $request, int $status): Response
    {
        $key = in_array($status, [404, 419, 422, 429], true) ? (string) $status : '500';
        if ($request->wantsJson() || str_starts_with($request->path, '/api/') || str_starts_with($request->path, '/webhooks/')) {
            return Response::json(['error' => t("error.$key.title")], $status);
        }
        $response = $this->page('pages/error', ['status' => $status, 'key' => $key], [
            'title' => t("error.$key.title"),
            'noindex' => true,
        ]);
        $response->status = $status;
        return $response;
    }
}

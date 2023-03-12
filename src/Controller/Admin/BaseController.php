<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    public function error(?string $message = 'System Error.', ?int $code = 0): JsonResponse
    {
        return $this->json([
            'message' => $message,
            'code' => $code,
            'data' => [],
        ]);
    }

    /**
     * @param array<string, mixed>|null $data
     * @param string|null $message
     * @param int|null $code
     * @return JsonResponse
     */
    public function success(?array $data = [], ?string $message = 'Success.', ?int $code = 20000): JsonResponse
    {
        return $this->json([
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ]);
    }
}
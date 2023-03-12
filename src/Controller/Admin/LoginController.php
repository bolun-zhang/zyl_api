<?php

namespace App\Controller\Admin;

use App\Service\AuthManager;
use RedisException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/login', name: 'admin_login')]
class LoginController extends BaseController
{
    public function __construct(
       protected AuthManager $manager,
    ) {
    }

    /**
     * @throws RedisException
     */
    #[Route(name: "", methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        list($bool, $res) = $this->manager->authLogin(json_decode($request->getContent(), true));
        if ($bool) {
            return $this->success($res);
        }

        return $this->error($res);
    }
}

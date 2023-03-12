<?php

namespace App\Controller\Admin;

use App\Service\CacheManager;
use RedisException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserBaseController extends BaseController
{
    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->_initUser();
    }

    /**
     * @return JsonResponse|void
     * @throws RedisException
     */
    public function _initUser()
    {
        $request = new Request();
        $token = $request->headers->get('TOKEN');
        if (!$token) {
            return $this->error('No login.');
        }
        $cacheManager = new CacheManager();
        $res = $cacheManager->authToken($token);

        if (!$res) {
            return $this->error('Login has been expired.');
        }
    }
}
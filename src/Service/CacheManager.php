<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Redis;
use RedisException;
use function Symfony\Component\String\b;

class CacheManager
{
    protected Redis $redis;

    /**
     * @throws RedisException
     */
    public function __construct(
    ) {
        $redis = new Redis();
        $redis->connect('127.0.0.1', '6379');

        $this->redis = $redis;
    }

    /**
     * @throws RedisException
     */
    public function loginToken(User $user): ?string
    {
        $token = md5($user->getUsername());
        $this->redis->set($token, $user, 7*24*60*60);

        return $token;
    }

    /**
     * @throws RedisException
     */
    public function authToken(?string $token): bool
    {
        if (!$this->redis->get($token)) {
            return false;
        }

        return true;
    }

}
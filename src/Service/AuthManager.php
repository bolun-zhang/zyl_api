<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RedisException;

class AuthManager
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected CacheManager $cacheManager,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function authLogin(array $params): array
    {
        try {
            $username = $params['username'] ?? '';
            $password = $params['password'] ?? '';

            $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
            if (!$user) {
                throw new Exception('Username not exits.');
            }
            if ($user->getPassword() !== md5($password)) {
                throw new Exception('Password wrong.');
            }
            $token = $this->cacheManager->loginToken($user);
        } catch (Exception $e) {
            return [
                false,
                $e->getMessage(),
            ];
        }

        return [
            true,
            ['token' => $token],
        ];
    }
}

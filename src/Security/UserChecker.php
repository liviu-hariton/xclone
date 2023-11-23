<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if(null === $user->getBannedUntil()) {
            return;
        }

        $now = new \DateTime();

        if($user->getBannedUntil() > $now) {
            throw new AccessDeniedHttpException('You are banned until ' . $user->getBannedUntil()->format('Y-m-d H:i:s') . '.');
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function checkPostAuth(UserInterface $user): void
    {

    }
}
<?php

namespace App\Security\Voter;

use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MicroPostVoter extends Voter
{
    public function __construct(private Security $security)
    {

    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [MicroPost::EDIT, MicroPost::VIEW])
            && $subject instanceof MicroPost;
    }

    /**
     * @param string $attribute
     * @param MicroPost $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(
        string $attribute,
               $subject,
        TokenInterface $token
    ): bool {
        /**
         * @var User $user
         */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        /*if (!$user instanceof UserInterface) {
            return false;
        }*/

        $is_auth = $user instanceof UserInterface;

        // If the user is an admin, grant access
        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            // Either the user is the author of the post or the user is an editor
            case MicroPost::EDIT:
                return $is_auth && ($subject->getAuthor()->getId() === $user->getId() || $this->security->isGranted('ROLE_EDITOR'));
            // If the post is not extra private, grant access
            case MicroPost::VIEW:
                if (!$subject->isExtraPrivacy()) {
                    return true;
                }

                return $is_auth && ($subject->getAuthor()->getId() === $user->getId() || $subject->getAuthor()->getFollows()->contains($user));
        }

        return false;
    }
}

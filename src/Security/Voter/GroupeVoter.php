<?php

namespace App\Security\Voter;

use App\Entity\Groupe;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupeVoter extends Voter
{
    public const EDIT = 'GROUPE_EDIT';
    public const DELETE = 'GROUPE_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Groupe;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        if (!$subject instanceof Groupe) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canManage($subject, $user);
                break;
        }

        return false;
    }

    private function canManage(Groupe $groupe, User $user)
    {
        return $groupe->getChef() === $user;
    }
}

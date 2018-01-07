<?php

namespace AppBundle\Security;

use AppBundle\Entity\Bass;
use AppBundle\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BassVoter extends Voter {

    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Bass) {
            return false;
        }

        return true;
    }


    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        // Check if user is logged in

        if (!$user instanceof Users) {
            return false;
        }

        //Check if user owns bass

        if ($subject->getUserEntity() !== $user) {
            return false;
        }

        return true;
    }
}
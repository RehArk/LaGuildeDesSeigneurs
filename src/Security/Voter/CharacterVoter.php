<?php

namespace App\Security\Voter;

use App\Entity\Character;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CharacterVoter extends Voter
{

    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_DISPLAY_ALL = 'characterDisplayAll';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY_ALL,
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE
    );

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        switch ($attribute) {

            case self::CHARACTER_DISPLAY_ALL:
                return $this->canDisplay();
                break;
                
            case self::CHARACTER_DISPLAY:
                return $this->canDisplay();
                break;

            case self::CHARACTER_CREATE:
                return $this->canCreate();
                break;
            
            default:
                # code...
                break;
        }
    }

    protected function supports($attribute, $subject) 
    {
        if($subject !== null) {
            return $subject instanceof Character && in_array($attribute, self::ATTRIBUTES);
        }

        return in_array($attribute, self::ATTRIBUTES);
    }

    protected function canDisplay() {
        return true;
    }

    protected function canCreate() {
        return true;
    }
}

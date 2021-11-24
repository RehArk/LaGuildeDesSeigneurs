<?php

namespace App\Security\Voter;

use App\Entity\Character;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CharacterVoter extends Voter
{

    public const CHARACTER_DISPLAY = 'characterDisplay';
    public const CHARACTER_CREATE = 'characterCreate';
    public const CHARACTER_DISPLAY_ALL = 'characterDisplayAll';
    public const CHARACTER_MODIFY ='characterModify';
    public const CHARACTER_DELETE = 'characterDelete';
    public const CHARACTER_IMAGE = 'characterImage';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY_ALL,
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE,
        self::CHARACTER_IMAGE
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
            
            case self::CHARACTER_MODIFY:
                return $this->canModify();
                break;

            case self::CHARACTER_DELETE:
                return $this->canDelete();
                break;

            case self::CHARACTER_IMAGE:
                return $this->imageAccess();
                break;
            
            default:
                return false;
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

    protected function canModify() {
        return true;
    }

    protected function canDelete() {
        return true;
    }

    protected function imageAccess() {
        return true;
    }
}

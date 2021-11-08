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
    public const CHARACTER_MODIFY ='characterModify';
    public const CHARACTER_DELETE = 'characterDelete';

    private const ATTRIBUTES = array(
        self::CHARACTER_DISPLAY_ALL,
        self::CHARACTER_DISPLAY,
        self::CHARACTER_CREATE,
        self::CHARACTER_MODIFY,
        self::CHARACTER_DELETE
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

    protected function canModify() {
        return true;
    }

    protected function canDelete() {
        return true;
    }
}

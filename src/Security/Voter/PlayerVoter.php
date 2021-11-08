<?php

namespace App\Security\Voter;

use App\Entity\Player;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PlayerVoter extends Voter
{
    public const PLAYER_DISPLAY = 'playerDisplay';
    public const PLAYER_CREATE = 'playerCreate';
    public const PLAYER_DISPLAY_ALL = 'playerDisplayAll';
    public const PLAYER_MODIFY ='playerModify';
    public const PLAYER_DELETE = 'playerDelete';

    private const ATTRIBUTES = array(
        self::PLAYER_DISPLAY_ALL,
        self::PLAYER_DISPLAY,
        self::PLAYER_CREATE,
        self::PLAYER_MODIFY,
        self::PLAYER_DELETE
    );

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        switch ($attribute) {

            case self::PLAYER_DISPLAY_ALL:
                return $this->canDisplay();
                break;
                
            case self::PLAYER_DISPLAY:
                return $this->canDisplay();
                break;

            case self::PLAYER_CREATE:
                return $this->canCreate();
                break;
            
            case self::PLAYER_MODIFY:
                return $this->canModify();
                break;

            case self::PLAYER_DELETE:
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
            return $subject instanceof Player && in_array($attribute, self::ATTRIBUTES);
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
<?php

namespace App\Listener;

use App\Event\CharacterEvent;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            CharacterEvent::CHARACTER_CREATED => 'characterCreated'
        );
    }

    public function characterCreated($event)
    {
        $character = $event->getCharacter();

        $character->setIntelligence(250);

        $date1 = new DateTime('22-11-2021');
        $date2 = new DateTime('30-11-2021');
        $now = new DateTime('now');
        if($date1 < $now && $now < $date2) {
            $character->setLife(20);
        }
    }
}

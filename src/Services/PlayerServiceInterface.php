<?php

namespace App\Services;

use App\Entity\Player;

interface PlayerServiceInterface 
{
    
    public function create();

    public function modify(Player $character);

    public function delete(Player $character);

}
<?php

namespace App\Services;

use App\Entity\Player;

interface PlayerServiceInterface 
{
    
    public function create(string $data);

    public function modify(Player $player, string $data);

    public function delete(Player $character);

    public function isEntityFilled(Player $player);

    public function submit(Player $player, $formName, $data);

}
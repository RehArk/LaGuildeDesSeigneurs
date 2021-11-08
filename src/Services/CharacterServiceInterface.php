<?php

namespace App\Services;

use App\Entity\Character;

interface CharacterServiceInterface 
{

    public function getAll();
    
    public function create();

    public function modify(Character $character);

}
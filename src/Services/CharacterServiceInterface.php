<?php

namespace App\Services;

use App\Entity\Character;

interface CharacterServiceInterface 
{

    public function getAll();
    
    public function create();

    public function modify(Character $character);

    public function delete(Character $character);

    public function getImages(int $number, string $kind);

}
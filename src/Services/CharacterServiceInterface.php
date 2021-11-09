<?php

namespace App\Services;

use App\Entity\Character;

interface CharacterServiceInterface 
{

    public function getAll();
    
    public function create(string $data);

    public function modify(Character $character, string $data);

    public function delete(Character $character);

    public function getImages(int $number, string $kind);

    public function isEntityFilled(Character $character);

    public function submit(Character $character, $formName, $data);

}
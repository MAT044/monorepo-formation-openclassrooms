<?php

namespace App\Dto;

use Doctrine\Common\Collections\Collection;

class WriteProjectDto {
    public string $title;
    public array|Collection $members;
}
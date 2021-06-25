<?php


namespace App\Libs;


use DateTimeImmutable;

interface PlanetTime
{
public function timeConverter(DateTimeImmutable $dateTimeImmutable):array;
}

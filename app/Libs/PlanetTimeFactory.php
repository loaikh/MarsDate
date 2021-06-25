<?php


namespace App\Libs;


use Exception;
use PhpParser\Node\Scalar\String_;
use function Symfony\Component\String\b;

class PlanetTimeFactory
{
public static function getPlanetTimeObject(String $planet) :?PlanetTime{
    switch (strtolower($planet)){
        case "mars":
            return new MarsPlanetTime();
            break;
        default:
          throw  new  Exception("The Planet ".$planet." time isn't not exists");
    }
}
}

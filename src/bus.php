<?php
/**
 * This file is part of the TripleI.bus
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace TripleI\bus;

class bus
{
    public function bus($priceAndPassengers)
    {
        $price = strstr($priceAndPassengers, ":", TRUE);

        $passengersWithColon = strstr($priceAndPassengers, ":");
        $passengersWithOutColon = str_replace(":", '', $passengersWithColon);

        $passengersArray = explode(",", $passengersWithOutColon);

        var_dump($passengersArray);
    }
}

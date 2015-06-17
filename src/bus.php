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

        $adult_number = 0;
        $child_number = 0;
        $infant_number = 0;
        foreach ($passengersArray as $passenger){
            $age = substr($passenger, 0, 1);
            $status = substr($passenger, 1, 1);

            if ($age === 'A') {
                $adult_number += 1;
            }

            if ($age === 'C') {
                $child_number += 1;
            }

            if ($age === 'I') {
                $infant_number += 1;
            }
        }

//        var_dump('A='.$adult_number);
//        var_dump('C='.$child_number);
//        var_dump('I='.$infant_number);
    }
}

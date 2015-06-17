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

        $adult_total_price = 0;
        $child_total_price = 0;
        $infant_total_price = 0;

        foreach ($passengersArray as $passenger){
            $age = substr($passenger, 0, 1);
            $status = substr($passenger, 1, 1);

            if ($age === 'A') {
                $adult_number += 1;
                $adult_edited_price = $price;

                $adult_final_price = $this->statusDiscount($adult_edited_price, $status);
                $adult_total_price += $adult_final_price;
            }

            if ($age === 'C') {
                $child_number += 1;
                $child_edited_price = $price * 0.5;

                $child_final_price = $this->statusDiscount($child_edited_price, $status);
                $child_total_price += $child_final_price;
            }

            if ($age === 'I') {
                $infant_number += 1;
                $infant_edited_price = $price * 0.5;

                $infant_final_price = $this->statusDiscount($infant_edited_price, $status);
                $infant_total_price += $infant_final_price;
            }
        }
        $total = $adult_total_price + $child_total_price+$infant_total_price;

        echo($total);
    }

    public function statusDiscount($edited_price, $status)
    {
        if ($status === 'n') {
            $final_price = $edited_price;
        }

        if ($status === 'p') {
            $final_price = 0;
        }

        if ($status === 'w') {
            $final_price = $edited_price * 0.5;
        }

        return $final_price;
    }
}

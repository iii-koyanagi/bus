<?php
/**
 * This file is part of the TripleI.bus
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace TripleI\bus;

class bus
{
    public function adultsAndChildCalculate($priceAndPassengers)
    {
        $price = strstr($priceAndPassengers, ":", TRUE);
        $passengersWithColon = strstr($priceAndPassengers, ":");
        $passengersWithOutColon = str_replace(":", '', $passengersWithColon);
        $passengersArray = explode(",", $passengersWithOutColon);

        $adult_number = 0;
        $adult_total_price = 0;
        $child_total_price = 0;

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
                $child_edited_price = $price * 0.5;
                $child_ceiling_price = $this->ceiling($child_edited_price, 10);

                $child_final_price = $this->statusDiscount($child_ceiling_price, $status);
                $child_total_price += $child_final_price;
            }
        }
        $adult_and_child_total = $adult_total_price + $child_total_price;

        $this->infantCalculate($passengersArray, $price , $adult_number, $adult_and_child_total);
    }

    private function statusDiscount($edited_price, $status)
    {
        if ($status === 'n') {
            $final_price = $edited_price;
        }

        if ($status === 'p') {
            $final_price = 0;
        }

        if ($status === 'w') {
            $before_final_price = $edited_price * 0.5;
            $final_price = $this->ceiling($before_final_price, 10);
        }

        return $final_price;
    }

    private function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }

    private function infantCalculate($passengersArray, $price, $adult_number, $adult_and_child_total)
    {
        $infant_number = 0;
        $infant_arr = array();

        foreach ($passengersArray as $passenger){
            $age = substr($passenger, 0, 1);
            $status = substr($passenger, 1, 1);

            if ($age === 'I') {
                $infant_number += 1;

                $infant_edited_price = $price * 0.5;
                $infant_ceiling_price = $this->ceiling($infant_edited_price, 10);
                $infant_final_price = $this->statusDiscount($infant_ceiling_price, $status);

                if ($status != 'p') {
                    $infant_arr[][$status] = $infant_final_price;
                }
            }
        }

        $free_infants = $adult_number * 2;

        var_dump($infant_arr);
    }
}

<?php
/**
 * This file is part of the TripleI.bus
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace TripleI\bus;

class bus
{
    //入力データを最適な形に編集
    public function editData($data)
    {
        //入力データから金額を取り出し
        $price = strstr($data, ":", TRUE);

        //入力データから年齢区分と料金区分を取り出す
        $passengersWithColon = strstr($data, ":");
        $passengersWithOutColon = str_replace(":", '', $passengersWithColon);

        //取り出した年齢区分と料金区分を一人につき、一要素として配列化
        $passengersArray = explode(",", $passengersWithOutColon);

        $edited_data = array($price, $passengersArray);
        return $edited_data;
    }

    //大人と小学生の計算
    public function adultsAndChildCalculate($edited_data)
    {
        $price = $edited_data[0];
        $passengersArray = $edited_data[1];

        $adult_number = 0;
        $adult_total_price = 0;
        $child_total_price = 0;

        //年齢区分と料金区分の配列を回す
        foreach ($passengersArray as $passenger){
            $age = substr($passenger, 0, 1);
            $status = substr($passenger, 1, 1);

            //大人の場合
            if ($age === 'A') {
                //幼児2人無料で使う為、人数をカウントしておく
                $adult_number += 1;
                //大人は通常料金
                $adult_edited_price = $price;

                //料金区分での割引を適用
                $adult_final_price = $this->statusDiscount($adult_edited_price, $status);
                $adult_total_price += $adult_final_price;
            }

            if ($age === 'C') {
                //小学生は大人の半額(10円未満切り上げ)
                $child_edited_price = $price * 0.5;
                //10円以下切り上げ
                $child_ceiling_price = $this->ceiling($child_edited_price, 10);

                //料金区分での割引を適用
                $child_final_price = $this->statusDiscount($child_ceiling_price, $status);
                $child_total_price += $child_final_price;
            }
        }

        //大人と小学生の合計算出
        $adult_and_child_total = $adult_total_price + $child_total_price;

        $adultsAndChildCalculate = array($adult_number, $adult_and_child_total);
        return $adultsAndChildCalculate;
    }

    //料金区分による値下げ
    private function statusDiscount($edited_price, $status)
    {
        //nなら通常料金
        if ($status === 'n') {
            $final_price = $edited_price;
        }

        //pなら無料
        if ($status === 'p') {
            $final_price = 0;
        }

        //wなら通常料金の半額(10円未満切り上げ)
        if ($status === 'w') {
            $before_final_price = $edited_price * 0.5;
            $final_price = $this->ceiling($before_final_price, 10);
        }

        return $final_price;
    }

    //10円未満切り上げ
    private function ceiling($number, $significance = 1)
    {
        return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
    }

    //幼児の計算と全ての合計金額の算出
    public function infantCalculateAndAllTotal($price, $passengersArray, $adult_number, $adult_and_child_total)
    {
        $infant_number = 0;
        $infant_arr = array();

        //年齢区分と料金区分の配列を回す
        foreach ($passengersArray as $passenger){
            $age = substr($passenger, 0, 1);
            $status = substr($passenger, 1, 1);

            //幼児の場合
            if ($age === 'I') {
                //幼児2人無料で使う為、人数をカウントしておく
                $infant_number += 1;
                //幼児は大人の半額(10円未満切り上げ)
                $infant_edited_price = $price * 0.5;
                $infant_ceiling_price = $this->ceiling($infant_edited_price, 10);

                //料金区分での割引を適用
                $infant_final_price = $this->statusDiscount($infant_ceiling_price, $status);

                //p = 無料でない場合
                if ($status != 'p') {
                    //幼児一人につき、一要素で配列化。料金区分もキーで渡す。
                    $infant_arr[][$status] = $infant_final_price;
                }
            }
        }

        //大人1人につき、2人無料。(以下、「幼児無料枠」)
        $free_infants = $adult_number * 2;

        //福祉区分より料金の高い通常区分の幼児から無料化する
        //通常区分の幼児を無料にする為に、配列を回す
        foreach ($infant_arr as $key => $infant) {
            //通常区分の子供の場合
            if (key($infant) === 'n') {
                //幼児無料枠がゼロでなければ
                if ($free_infants != 0) {
                    //幼児配列の要素ごと消して無料化
                    unset($infant_arr[$key]);
                    //幼児無料枠を1個減らす
                    $free_infants -= 1;
                }
            }
        }

        //通常区分より料金の安い福祉区分の幼児を後で無料化する
        //福祉区分の幼児を無料にする為に、配列を回す
        foreach ($infant_arr as $key => $infant) {
            //幼児無料枠がゼロでなければ
            if ($free_infants != 0) {
                //幼児配列の要素ごと消して無料化
                unset($infant_arr[$key]);
                //幼児無料枠を1個減らす
                $free_infants -= 1;
            }
        }

        //幼児の合計を算出する為に、配列を回す
        $infant_total = 0;
        foreach ($infant_arr as $infant_price) {
            //幼児の合計を加算
            $infant_total += array_values($infant_price)[0];
        }

        //全ての合計を足して返す。
        $all_total = $adult_and_child_total + $infant_total;
        return $all_total;
    }
}

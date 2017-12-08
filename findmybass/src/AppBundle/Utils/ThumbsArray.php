<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 06.12.2017
 * Time: 17:39
 */

namespace AppBundle\Utils;


class ThumbsArray
{
    public function getJSONArray($type, $message) {
        if (true == $type) {
            $array = [
                "error" => 0, "newRating" => $message
            ];
            return $array;
        }
        else {
            $array = [
                "error" => 1, "errorMessage" => $message
            ];
            return $array;
        }
    }
}
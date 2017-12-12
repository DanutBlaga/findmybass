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
    /**
     * @param $type bool if rating was correctly set
     * @param $message mixed
     * @return array
     */
    public function getJSONArray($type, $message) {
        if ($type) {
            $array = [
                "error" => 0, "newRating" => $message
            ];
        }
        else {
            $array = [
                "error" => 1, "errorMessage" => $message
            ];
        }
        return $array;
    }
}
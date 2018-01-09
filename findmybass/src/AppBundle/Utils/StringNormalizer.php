<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 27.10.2017
 * Time: 19:38
 */

namespace AppBundle\Utils;


class StringNormalizer
{
    public static function normalizeName($name){
        $normalizedName = strtolower($name);
        $normalizedName = preg_replace("/[^a-zA-Z0-9]+/", "", $normalizedName);

        if (strlen($normalizedName) == 0) {
            return $name;
        }

        return $normalizedName;
    }

    public static function normalizeArray(array $array) {
        $name = implode("", $array);

        return self::normalizeName($name);
    }


}
<?php

namespace AppBundle\Utils;

class PasswordUtils
{
    static function generateSalt() {
        return substr(base64_encode(random_bytes(10)), 0, 16);
    }
}
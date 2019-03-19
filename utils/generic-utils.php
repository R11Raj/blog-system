<?php
/**
 * Created by PhpStorm.
 * Date: 3/19/19
 * Time: 10:52 AM
 */

class GenericUtils {
    /**
     * Secure random string
     * @param $length
     * @param string $keyspace
     * @return string
     */
    public static function secure_random_string($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}?>
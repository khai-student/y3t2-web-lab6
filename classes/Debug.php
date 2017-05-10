<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2017
 * Time: 21:01
 */
class Debug
{
    const is_debug_mode = true;

    public function Warn($msg) {
        if (self::is_debug_mode == true) {
            echo $msg;
        }
    }

    public function Error($msg) {
        if (self::is_debug_mode == true) {
            die($msg);
        }
        else {
            die();
        }
    }
}
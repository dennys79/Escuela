<?php

/**
 * Description of Debug
 *
 * @author WERD
 */
class LibQ_Debug
{
    public function __construct()
    {
        ;
    }
    
    public static function print_debug($datos)
    {
        echo '<pre>';
        print_r($datos);
        echo '</pre>';
    }
}

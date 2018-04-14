<?php
/**
 * Created by PhpStorm.
 * User: dmitrijponizov
 * Date: 12.04.2018
 * Time: 22:48
 */

namespace App\Inspections;

use Exception;

class KeyHeldDown
{
    public function detect($body)
    {
        if(preg_match('/(.)\\1{4,}/',$body)){
            throw new Exception('Your reply contains spam');
        }
    }
}
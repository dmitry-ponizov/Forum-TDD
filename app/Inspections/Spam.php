<?php
/**
 * Created by PhpStorm.
 * User: dmitrijponizov
 * Date: 11.04.2018
 * Time: 21:57
 */

namespace App\Inspections;


class Spam
{
    protected $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection){
            app($inspection)->detect($body);
        }

        return false;
    }

}
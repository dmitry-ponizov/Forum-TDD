<?php
/**
 * Created by PhpStorm.
 * User: dmitrijponizov
 * Date: 12.04.2018
 * Time: 22:47
 */

namespace App\Inspections;

use Exception;

class InvalidKeyWords
{
    protected $keywords = ['Yahoo customer support'];

    public function detect($body)
    {

        foreach ($this->keywords as $keyword) {

            if (stripos($body, $keyword) !== false) {
                throw new Exception('our replies contains spam');
            }
        }
    }
}
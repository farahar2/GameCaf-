<?php

namespace App\Core;

abstract class Model
{
    protected static function db()
    {
        return Database::getInstance();
    }
}

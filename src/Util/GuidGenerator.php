<?php

namespace App\Util;


use Symfony\Component\Uid\Uuid;

class GuidGenerator
{
    public static function generate(): string
    {
        return strtoupper(Uuid::v7());
    }
}
<?php

namespace App\Entity;

use ReflectionClass;

enum ItemState: string
{
	case New = "neuf";
	case Used = "usagé";
	case Damaged = "endommagé";
	case Broken = "cassé";
	public static function values()
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getConstants();
    }
}

?>

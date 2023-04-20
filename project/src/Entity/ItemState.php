<?php

namespace App\Entity;

enum ItemState: string
{
	case New = "neuf";
	case Used = "usagé";
	case Damaged = "endommagé";
	case Broken = "cassé";
}

?>

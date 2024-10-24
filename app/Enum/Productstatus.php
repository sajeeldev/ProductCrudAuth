<?php

namespace App\Enum;

use PhpParser\Node\Stmt\Label;

enum Productstatus: string
{
    case In_stock = 'in stock';
    case Out_of_stock = 'out of stock';
}



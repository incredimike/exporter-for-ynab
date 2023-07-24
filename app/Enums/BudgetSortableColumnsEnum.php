<?php

namespace App\Enums;

enum BudgetSortableColumnsEnum: string
{
    case account_name = 'account_name';
    case amount = 'amount';
    case category_name = 'category_name';
    case date = 'date';
    case flag_color = 'flag_color';
    case memo = 'memo';
    case payee_name = 'payee_name';
}

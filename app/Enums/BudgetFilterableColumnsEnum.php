<?php

namespace App\Enums;

enum BudgetFilterableColumnsEnum: string
{
    case account_name = 'account_name';
    case approved = 'approved';
    case category_name = 'category_name';
    case flag_color = 'flag_color';
    case memo = 'memo';
    case payee_name = 'payee_name';
}

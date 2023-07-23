<?php

namespace App\Enums;

enum ArrangableColumnEnum: string
{
    case amount = 'amount';
    case date = 'date';
    case flag_color = 'flag_color';
    case account_name = 'account_name';
    case payee_name = 'payee_name';
    case cleared = 'cleared';
    case approved = 'approved';
}

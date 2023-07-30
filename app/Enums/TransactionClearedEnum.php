<?php

namespace App\Enums;

enum TransactionClearedEnum: string
{
    case cleared = 'cleared';
    case uncleared = 'uncleared';
    case reconciled = 'reconciled';
}

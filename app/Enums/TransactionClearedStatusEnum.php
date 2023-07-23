<?php

namespace App\Enums;

enum TransactionClearedStatusEnum: string
{
    case cleared = 'cleared';
    case uncleared = 'uncleared';
    case reconciled = 'reconciled';
}

<?php

namespace App\Enums;

enum NameOfGroup: string
{
 case General = 'General';
 case Asset = 'Asset';
 case Liabilities = 'Liabilities';
 case Income = 'Income';
 case Expense = 'Expense';
}

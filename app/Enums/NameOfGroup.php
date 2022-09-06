<?php

namespace App\Enums;

enum NameOfGroup: string
{
    case General = "General";
    case Asset = "Asset";
    case Liability = "Liability";
    case Income = "Income";
    case Expense = "Expense";
}

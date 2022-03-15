<?php

namespace App\Models;

use App\Enums\NameOfGroup;
use App\Enums\ParticularType;
use Illuminate\Database\Eloquent\Model;
use App\Helper\TransactionReports\Calculation;

class LedgerHead extends Model
{
    protected $table = "ledger_heads";
    protected $guarded = ["id"];
    protected $appends = [
        "parent",
        "has_child",
        "debit",
        "credit",
        "closing_balance",
    ];
    public function getParentAttribute()
    {
        if ($this->parent_id == "0") {
            return "Primary";
        } else {
            return LedgerHead::find($this->parent_id)->name;
        }
    }

    public function getHasChildAttribute()
    {
        $id = $this->id;
        $childs = LedgerHead::with("particulars")->find($id);
        return $childs->particulars->count();
    }

    public function particulars()
    {
        return $this->hasMany(LedgerHead::class, "parent_id", "id");
    }
    public function transactions()
    {
        $transactions = Calculation::calculate($this->id);
        return $transactions;
    }
    public function getDebitAttribute()
    {
        if ($this->has_child > 0) {
            // return $this->particulars->sum("debit");
            return 0;
        } else {
            $debit_amount = $this->transactions()
                ->where("particular", ParticularType::Debit)
                ->sum("amount");
            return $debit_amount;
            // return 0;
        }
    }
    public function getCreditAttribute()
    {
        if ($this->has_child > 0) {
            // return $this->particulars->sum("credit");
            return 0;
        } else {
            $credit_amount = $this->transactions()
                ->where("particular", ParticularType::Credit)
                ->sum("amount");
            return $credit_amount;
            // return 0;
        }
    }
    public function getClosingBalanceAttribute()
    {
        return $this->getDebitAttribute() - $this->getCreditAttribute();
    }

    protected $casts = [
        "name_of_group" => NameOfGroup::class,
    ];
}

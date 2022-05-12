<?php

namespace App\Models;

use App\Enums\NameOfGroup;
use App\Helper\TransactionReports\Calculation;
use Illuminate\Database\Eloquent\Model;

class LedgerHead extends Model
{
    protected $table = "ledger_heads";
    protected $guarded = ["id"];
    protected $appends = ["parent", "has_child"];

    public function particulars()
    {
        return $this->hasMany(LedgerHead::class, "parent_id", "id");
    }

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

    public function alias()
    {
        return $this->hasMany(LedgerHead::class, "alias_of", "id");
    }

    protected $casts = [
        "name_of_group" => NameOfGroup::class,
    ];
}

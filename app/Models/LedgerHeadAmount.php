<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerHeadAmount extends Model
{
    protected $table = "ledger_head_amounts";
    protected $guarded = ["id"];

    public function parent()
    {
        return $this->belongsTo(LedgerHead::class, "parent_id", "id");
    }
}

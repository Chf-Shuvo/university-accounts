<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LedgerHeadAmount extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "ledger_head_amounts";
    protected $guarded = ["id"];

    public function parent()
    {
        return $this->belongsTo(LedgerHead::class, "parent_id", "id");
    }
}

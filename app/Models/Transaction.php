<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "transactions";
    protected $guarded = ["id"];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, "voucher_type", "id");
    }
}

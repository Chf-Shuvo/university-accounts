<?php

namespace App\Models;

use App\Enums\ParticularType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TransactionDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = "transaction_details";
    protected $guarded = ["id"];
    protected $casts = [
        "particular" => ParticularType::class,
    ];
    protected $appends = ["voucher_type"];

    public function head()
    {
        return $this->belongsTo(LedgerHead::class, "ledger_head", "id");
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, "transaction_id", "id");
    }
    public function company_transactions()
    {
        return $this->transaction()->where(
            "company_id",
            auth()->user()->company
        );
    }
    public function getVoucherTypeAttribute()
    {
        $transaction = Transaction::find($this->transaction_id);
        return Voucher::select("name")->find($transaction->voucher_type)->name;
    }
}

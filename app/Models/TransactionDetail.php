<?php

namespace App\Models;

use App\Enums\ParticularType;
use Illuminate\Database\Eloquent\Model;
use PDO;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    protected $guarded = ['id'];
    protected $casts = [
        'particular' => ParticularType::class
    ];

    public function head()
    {
        return $this->belongsTo(LedgerHead::class, 'ledger_head', 'id');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
    public function company_transactions()
    {
        return $this->transaction()->where('company_id', auth()->user()->company);
    }
}

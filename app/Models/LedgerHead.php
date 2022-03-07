<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerHead extends Model
{
    const ASSET = 1;
    const LIABILITY = 2;
    const DEPT_INCOME = 1;
    const MASTER_HEAD = 0;
    protected $table = 'ledger_heads';
    protected $guarded = ['id'];
    protected $appends = ['parent', 'has_child'];

    public function getParentAttribute()
    {
        if ($this->parent_id == '0') {
            return "Master Head";
        } else {
            return LedgerHead::find($this->parent_id)->name;
        }
    }

    public function getHasChildAttribute()
    {
        $id = $this->id;
        $childs = LedgerHead::with('particulars')->find($id);
        return $childs->particulars->count();
    }

    public function particulars()
    {
        return $this->hasMany(LedgerHead::class, 'parent_id', 'id');
    }
}

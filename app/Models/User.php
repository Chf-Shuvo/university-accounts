<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable, HasRoles;
    protected $table = 'users';
    protected $guarded = ['id'];
    protected $appends = ['company_name', 'company_last_entry_date'];

    public function getCompanyNameAttribute()
    {
        $company = Company::find($this->company);
        return $company->name;
    }
    public function getCompanyLastEntryDateAttribute()
    {
        return Company::find($this->company)->last_entry_date;
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable, HasRoles, HasApiTokens;
    protected $table = "users";
    protected $guarded = ["id"];
    protected $appends = [
        "company_name",
        "company_address",
        "company_last_entry_date",
    ];
    protected $hidden = ["password"];
    public function getCompanyNameAttribute()
    {
        $company = Company::find($this->company);
        return $company->name;
    }
    public function getCompanyAddressAttribute()
    {
        $company = Company::find($this->company);
        return $company->address;
    }
    public function getCompanyLastEntryDateAttribute()
    {
        return Company::find($this->company)->last_entry_date;
    }
}

<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable, HasRoles;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'contact'];
}

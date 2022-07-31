<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class OTP extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = "otps";
    protected $fillable = ["otp"];
}

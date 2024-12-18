<?php

namespace Modules\BloodDonation\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\BloodDonation\Database\Factories\DistrictFactory;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];

    // protected static function newFactory(): DistrictFactory
    // {
    //     // return DistrictFactory::new();
    // }
}

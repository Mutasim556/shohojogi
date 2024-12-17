<?php

namespace Modules\BloodDonation\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\BloodDonation\Database\Factories\BloodDonorFactory;

class BloodDonor extends Model
{
    use HasFactory;

    protected $table = 'blood_donors';

    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];

    // protected static function newFactory(): BloodDonorFactory
    // {
    //     // return BloodDonorFactory::new();
    // }
}

<?php

namespace Modules\BloodDonation\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\BloodDonation\Database\Factories\UpazilaFactory;

class Upazila extends Model
{
    use HasFactory;

    protected $table = 'upazilas';

    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];

    // protected static function newFactory(): UpazilaFactory
    // {
    //     // return UpazilaFactory::new();
    // }
}

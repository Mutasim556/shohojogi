<?php

namespace Modules\BloodDonation\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\BloodDonation\Database\Factories\DivisionFactory;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';
    /**
     * The attributes that are mass assignable.
     */
    // protected $fillable = [];

    // protected static function newFactory(): DivisionFactory
    // {
    //     // return DivisionFactory::new();
    // }
}

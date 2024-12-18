<?php

namespace Modules\BloodDonation\app\Models;

use App\Models\User;
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

    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function division() {
        return $this->belongsTo(Division::class,'division_id','id');
    }
    public function district() {
        return $this->belongsTo(District::class,'district_id','id');
    }
    public function upazila() {
        return $this->belongsTo(Upazila::class,'upazila_id','id');
    }
}

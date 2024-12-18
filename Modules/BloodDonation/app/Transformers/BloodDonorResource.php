<?php

namespace Modules\BloodDonation\app\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\BloodDonation\app\Models\District;
use Modules\BloodDonation\app\Models\Upazila;

class BloodDonorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // dd($data);
        return [
            'user_id' => $this->user->name,
            'username' => $this->user->username,
            'division' => $this->division->id,
            'district' => $this->district->id,
            'upazila' => $this->upazila->id,
            'districts'=>District::where([['division_id',$this->division->id]])->select('id','name','bn_name')->get(),
            'upazilas'=>Upazila::where([['district_id',$this->district->id]])->select('id','name','bn_name')->get(),
            'address' => $this->address,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'dob' => $this->user->dob,
            'blood_group' => $this->blood_group,
            'last_donation_date' => $this->last_donation_date,
            'is_active' => $this->user->status,
            'is_tmp_password' => $this->user->password_status,
            'donation_details' => $this->last_donation_details,
            'donor_image' => $this->user->image,
            'donor_id' => $this->id,
        ];

    }
}

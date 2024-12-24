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
            'user_id' => $this->user->id,
            'donor_name' => $this->user->name,
            'username' => $this->user->username,
            'division' => $this->division->id,
            'district' => $this->district->id,
            'district_name' => $this->district->name,
            'upazila' => $this->upazila->id,
            'upazila_name' => $this->upazila->name,
            'districts'=>District::where([['division_id',$this->division->id]])->select('id','name','bn_name')->get(),
            'upazilas'=>Upazila::where([['district_id',$this->district->id]])->select('id','name','bn_name')->get(),
            'address' => $this->address,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'dob' => date('Y-m-d',strtotime($this->dob)),
            'blood_group' => $this->blood_group,
            'last_donation_date' => date('Y-m-d',strtotime($this->last_donation_date)),
            'next_donation_date' => date('Y-m-d',strtotime($this->next_donation_date)),
            'is_active' => $this->user->status,
            'is_tmp_password' => $this->user->password_status,
            'donation_details' => $this->last_donation_details,
            'donor_image' => $this->user->image,
            'donor_id' => $this->id,
        ];

    }
}

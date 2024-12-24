<?php

namespace Modules\BloodDonation\app\Http\Requests\BloodDonor;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Modules\BloodDonation\app\Models\BloodDonor;

class BloodDonorUpdateRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$this->user_id,
            'division' => 'required',
            'district' => 'required',
            'upazila' => 'required',
            'phone' => 'required|unique:users,phone,'.$this->user_id,
            'email' => [Rule::unique('users')->where(function($query){$query->where([['email','!=',''],['email','!=',$this->email]]);})],
            'dob' => 'required',
            'blood_group' => 'required',
            'donor_image' => 'max:2500|mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('admin_local.Donar full name is required'),
            'username.required' => __('admin_local.Donar user name is required'),
            'username.unique' => __('admin_local.Donar user name already used'),
            'division.required' => __('admin_local.Division is required'),
            'district.required' => __('admin_local.District is required'),
            'upazila.required' => __('admin_local.Upazila is required'),
            'phone.required' => __('admin_local.Donor phone number required'),
            'phone.unique' => __('admin_local.This phone number already used'),
            'email.unique' => __('admin_local.This email already used'),
            'dob.required' => __('admin_local.Date of birth required'),
            'blood_group.required' => __('admin_local.Blood group required'),
            'donor_image.max' => __('admin_local.Image must be less the 2 MB'),
            'donor_image.mimes' => __('admin_local.Image format must be jpg,jpeg,png'),
        ];
    }

    public function update($id){
        DB::beginTransaction();
        try {
            $user = User::findOrFail($this->user_id);


            $user->name = $this->name;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->password_status = $this->is_tmp_password ? 1 : 0;

            if ($this->donor_image) {
                $files = $this->donor_image;
                $file = time() . '.' . $files->getClientOriginalExtension();
                $file_name = 'Modules/BloodDonation/public/asset/donor/' . $file;
                $manager = new ImageManager(new Driver);
                $manager->read($this->donor_image)->save('Modules/BloodDonation/public/asset/donor/' . $file);
            } else {
                $file_name = $user->image;
            }
            $user->image = $file_name;


            $user->save();

            if ($this->last_donation_date) {
                $next_donation_date = date('Y-m-d', strtotime($this->last_donation_date . ' +90 days'));
            } else {
                $next_donation_date = date('Y-m-d');
            }
            $donor_info = BloodDonor::findOrFail($id);
            $donor_info->dob = $this->dob;
            $donor_info->blood_group = $this->blood_group;
            $donor_info->last_donation_date = $this->last_donation_date;
            $donor_info->next_donation_date = $next_donation_date;
            $donor_info->last_donation_details = $this->last_donation_details;
            $donor_info->division_id = $this->division;
            $donor_info->district_id = $this->district;
            $donor_info->upazila_id = $this->upazila;
            $donor_info->address = $this->address;
            $donor_info->save();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

}

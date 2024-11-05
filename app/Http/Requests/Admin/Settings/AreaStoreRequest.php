<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AreaStoreRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule =  [
            'area_type'=>'required',
            'name_english'=>'required',
            'name_bangla'=>'required',
        ];

        if($this->area_type=='Division'){
            $rule['area_code'] = 'required|unique:divisions,area_code';
        }elseif($this->area_type=='District'){
            $rule['area_code'] = 'required|unique:districts,area_code';
            $rule['division'] = 'required';
        }else{
            $rule['area_code'] = 'required|unique:upazilas,area_code';
            $rule['division'] = 'required';
            $rule['district'] = 'required';
        }

        return $rule;
    }

    public function storeDivision(){
        $store = DB::table('divisions')->insert([
            'name' => $this->name_english,
            'bn_name' => $this->name_bangla,
            'area_code' => $this->area_code,
            'status' => 1,
        ]);

        $id = DB::getPdo()->lastInsertId();
        $area = DB::table('divisions')->where('id',$id)->first();
        return [
            'id'=>$id,
            'area'=>$area,
            'area_type'=>'division',
        ];
        return $id;
    }
    public function storeDistrict(){
        $store = DB::table('districts')->insert([
            'division_id'=>$this->division,
            'name' => $this->name_english,
            'bn_name' => $this->name_bangla,
            'area_code' => $this->area_code,
            'status' => 1,
        ]);

        $id = DB::getPdo()->lastInsertId();
        $area = DB::table('districts')->join('divisions','districts.division_id','divisions.id')->where('districts.id',$id)->select('districts.*','divisions.name as division_name','divisions.bn_name as division_name_bangla')->first();
        return [
            'id'=>$id,
            'area'=>$area,
            'area_type'=>'district',
        ];
    }
    public function storeUpazila(){
        $store = DB::table('upazilas')->insert([
            'district_id'=>$this->district,
            'name' => $this->name_english,
            'bn_name' => $this->name_bangla,
            'area_code' => $this->area_code,
            'status' => 1,
        ]);

        $id = DB::getPdo()->lastInsertId();
        $area = DB::table('upazilas')->join('districts','upazilas.district_id','districts.id')->join('divisions','districts.division_id','divisions.id')->where('upazilas.id',$id)->select('upazilas.*','divisions.name as division_name','districts.name as district_name')->first();
        return [
            'id'=>$id,
            'area'=>$area,
            'area_type'=>'upazila',
        ];
    }
}

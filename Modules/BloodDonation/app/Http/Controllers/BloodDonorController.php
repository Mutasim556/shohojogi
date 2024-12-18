<?php

namespace Modules\BloodDonation\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\BloodDonation\app\Http\Requests\BloodDonor\BloodDonorStoreRequest;
use Modules\BloodDonation\app\Models\BloodDonor;
use Modules\BloodDonation\app\Transformers\BloodDonorResource;
use Spatie\Permission\Models\Role;

class BloodDonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:blood-donor-index,admin')->only('index');
        $this->middleware('permission:blood-donor-create,admin')->only('store');
        $this->middleware('permission:blood-donor-update,admin')->only(['edit','update']);
        $this->middleware('permission:blood-donor-delete,admin')->only('destroy');
    }
    public function index()
    {
        // echo "hi";
        $donors = BloodDonor::with('user','division','district','upazila');
        if(!hasPermission(['blood-donor-all-view'])){
            $donors=$donors->where('created_by',LoggedAdmin()->id);
        }
        $donors = $donors->get();
        $roles = Role::all();
        $divisions = get_division();
        $districts = get_district('7');
        return view('blooddonation::backend.donor.index',compact('donors','roles','divisions','districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blooddonation::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BloodDonorStoreRequest $data)
    {
        $donor_info = $data->store();
        if($donor_info){
            $donor = BloodDonor::with('user','division','district','upazila')->where([['id',$donor_info]])->first();
            return response([
                'donor' => $donor,
                'title' => __('admin_local.Congratulations !'),
                'text' => __('admin_local.Donor added successfully.'),
                'confirmButtonText' => __('admin_local.Ok'),
                'hasAnyPermission' => hasPermission(['blood-donor-update', 'blood-donor-delete']),
                'hasEditPermission' => hasPermission(['blood-donor-update']),
                'hasDeletePermission' => hasPermission(['blood-donor-delete']),
            ], 200);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blooddonation::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $donor = BloodDonor::with('user','division','district','upazila')->where([['id',$id]])->first();
        $donor = BloodDonorResource::make($donor);
        return $donor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus(){
        DB::beginTransaction();
        try {
            //code...
            $donor = BloodDonor::where([['id',request()->id]])->select('user_id')->first();
            $user = User::findOrFail($donor->user_id);
            $user->status = request()->status;
            $user->save();
            DB::commit();
            return [
                'status'=>$user->status,
            ];
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

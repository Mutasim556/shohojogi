<?php

namespace Modules\BloodDonation\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class BloodDonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // echo "hi";
        $users = User::where('delete',0);
        if(Auth::guard('admin')->check() && userRoleName()!='Super Amin'){
            $users=$users->where('created_by',LoggedAdmin()->id);
        }
        $users = $users->get();
        $roles = Role::all();
        return view('blooddonation::backend.donor.index',compact('users','roles'));
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
    public function store(Request $request)
    {
        //
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
        return view('blooddonation::edit');
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
}

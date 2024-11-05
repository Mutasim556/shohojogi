<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\AreaStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:area-index,admin');
        // $this->middleware('permission:area-store,admin')->only('store');
        // $this->middleware('permission:area-update,admin')->only(['edit','update','updateStatus']);
        // $this->middleware('permission:area-delete,admin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = DB::table('divisions')->where('status',1)->get();
        return view('backend.blade.settings.area.index',compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaStoreRequest $data)
    {
        $response = null;
        $area = '';
        $area_type = '';
        if($data->area_type =='Division'){
            $resopnse = $data->storeDivision();
            $area = $resopnse['area'];
            $area_type = $resopnse['area_type'];
        }elseif($data->area_type =='District'){
            $resopnse = $data->storeDistrict();
            $area = $resopnse['area'];
            $area_type = $resopnse['area_type'];
        }else{
            $resopnse = $data->storeUpazila();
            $area = $resopnse['area'];
            $area_type = $resopnse['area_type'];
        }
// dd($resopnse['area_type']);
        if($resopnse){
            return response([
                'area' => $area,
                'area_type'=>$area_type,
                'title' => __('admin_local.Congratulations !'),
                'text' => __('admin_local.Parent category create successfully.'),
                'confirmButtonText' => __('admin_local.Ok'),
                'hasAnyPermission' => hasPermission(['area-update', 'area-delete']),
                'hasEditPermission' => hasPermission(['area-update']),
                'hasDeletePermission' => hasPermission(['area-delete']),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(request()->ajax()){
            $districts = DB::table('districts')->where([['division_id',$id],['status',1]])->get();
            return response()->json($districts);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAreaData(string $type){
       
       if($type=='division'){
            $areas =  $area = DB::table('divisions')->where([['status',1]])->get();
       }elseif($type=='district'){
            $area = DB::table('districts')->join('divisions','districts.division_id','divisions.id')->where('districts.status',1)->select('districts.name','districts.id','districts.bn_name','districts.status','districts.area_code','divisions.name as division_name','divisions.bn_name as division_name_bangla')->get();
       }else{
            $area = DB::table('upazilas')->join('districts','upazilas.district_id','districts.id')->join('divisions','districts.division_id','divisions.id')->where('upazilas.status',1)->select('upazilas.name','upazilas.id','upazilas.bn_name','upazilas.status','upazilas.area_code','divisions.name as division_name','districts.name as district_name')->get();
       }

       return [
            'area'=>$area,
            'area_type'=>$type,
            'hasAnyPermission' => hasPermission(['area-update', 'area-delete']),
            'hasEditPermission' => hasPermission(['area-update']),
            'hasDeletePermission' => hasPermission(['area-delete']),
    ];
    }
}

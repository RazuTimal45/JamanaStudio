<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SettingRequest;
use App\Http\Requests\Backend\SocialServicesRequest;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\SocialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use function NunoMaduro\Collision\Exceptions\getMessage;

class   PermissionController extends BackendBaseController
{
    protected $panel = 'Permission';
    protected $base_route = 'backend.permissions.';
    protected $base_view = 'backend.permissions.';
    protected $model;

    function __construct(){
        $this->model = new Permission();
    }
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id=$this->model->query()->select('id')->limit(1)->pluck('id')->first();
        if($id!==null){
            return redirect()->route($this->base_route.'show',$id);
        }else{
            return view($this->__loadToView($this->base_view . 'create'),compact('id'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->request->add(['created_by' => auth()->user()->id]);
            $record = $this->model->create($request->all());
            if ($record){
                Alert::success('success',$this->panel.' created successfully');
            } else  {
                Alert::error('error',$this->panel.' creation failed');
            }
        }catch (\Exception $exception){
            Alert::error('error','Oops....Error occur:  ' . $exception->getMessage());
        }
        return redirect()->route($this->base_route . 'create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['record']=$this->model->find($id);
        if($data['record']==null){
            return redirect()->route($this->base_route.'create');
        }
        return view($this->__loadToView($this->base_view.'show'),compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['record']=$this->model->find($id);
        return view($this->__loadToView($this->base_view . 'edit'),compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data['records']=$this->model->find($id);
        $request->request->add(['updated_by' => auth()->user()->id]);
        $d=$data['records']->update($request->all());
        if($d){
            Alert::success('success',$this->panel.' updated successfully');
        }else{
            Alert::error('error',$this->panel.' update process failed');
        }
        return redirect()->route($this->base_route.'show',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=$this->model->find($id);
        $d=$data->delete();
        if($d){
            Alert::success('success',$this->panel.' deleted successfully');
        }else{
            Alert::error('error','Oops... something went wrong');
        }
        return redirect()->route($this->base_route.'create');
    }
    public function trash(){
        $data['record']=$this->model->onlyTrashed()->first();
        if(!$data['record']){
            Alert::error('No Data','No Data Found');
            return redirect()->route($this->base_route.'create');
        }
        return view($this->__loadToView($this->base_route.'trash'),compact('data'));
    }
    public function deletePermanent($id){
        $data['record']=$this->model->where('id',$id)->onlyTrashed()->first();
        if (!$data['record']){
            Alert::error('error','Opps ... record not found');
            return redirect()->route($this->base_route . 'index');
        }
        if($data['record']->forceDelete()){
            Alert::success('success',$this->panel.' deleted successfully');
        } else {
            Alert::error('error','Opps ... error occured while deleting record');
        }
        return redirect()->route($this->base_route.'create');
    }
    public function restore($id){
        $data['record']=$this->model->where('id',$id)->onlyTrashed()->first();
        if (!$data['record']){
            Alert::error('error','Opps ... record not found');
            return redirect()->route($this->base_route . 'create');
        }
        if($data['record']->restore()){
            Alert::success('success', $this->panel . ' Recovered Successfully');
        } else {
            Alert::error('error','Ooops ... error occurred while recovering record');
        }
        return redirect()->route($this->base_route . 'show',$data['record']->id);
    }
}

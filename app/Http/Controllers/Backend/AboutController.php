<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AboutRequest;
use App\Models\About;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends BackendBaseController
{
     protected $panel = 'about';
     protected $base_view='backend.about.';
     protected $base_route = 'backend.about.';
     protected $model;

     public function __construct()
     {
         $this->model = new About();
     }
    public function index()
    {
        $data['about'] = $this->model->orderBy('created_at','desc')->get();
        if (count($data['about'])<1) {
            Alert::error('No Data', 'No Data found');
            return redirect()->route($this->base_route.'create');
        } else {
            return view($this->__loadToView($this->base_view . 'index'), compact('data'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->__loadToView($this->base_view . 'create'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutRequest $request)
    {
        try{
            $request->request->add(['created_by' => auth()->user()->id]);
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images/about/', $imageFilename);
                $request->request->add(['image' => $imageFilename]);
            }
            $record = $this->model->create($request->all());
            if ($record){
                Alert::success('Success',$this->panel.' Added successfully');
            } else  {
                Alert::error('Error',$this->panel.' creation failed');
            }
        }catch (\Exception $exception){
            Alert::error('error','Oops....Error occur:  ' . $exception->getMessage() );
        }
        return redirect()->route($this->base_route . 'create');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['about']=$this->model->find($id);
        if(!$data['about']){
            Alert::error('No Data','Data Not Found');
            return view($this->__loadToView($this->base_view.'index'));
        }else{
            return view($this->__loadToView($this->base_view.'show'),compact('data'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['about']=$this->model->find($id);
        if(!$data['about']){
            Alert::error('No Data','No Data Found');
            return redirect()->route($this->base_route.'index');
        }
        return view($this->__loadToView($this->base_view . 'edit'),compact('data'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(AboutRequest $request, string $id)
    {
        $data['about']=$this->model->find($id);
        $request->request->add(['updated_by' => auth()->user()->id]);
        if($request->hasfile('image_file')) {
            $filename = uniqid() . '.' . $request->file('image_file')->getClientOriginalExtension();;
            $request->file('image_file')->move('images/about/', $filename);
            $request->request->add(['image' => $filename]);
            if ($data['about']->image && file_exists(public_path('images/about/' . $data['about']->image))) {
                unlink(public_path('images/about/' . $data['about']->image));
            }
        }
        $d=$data['about']->update($request->all());
        if($d){
            Alert::success('success',$this->panel.' updated successfully');
        }else{
            Alert::error('error','Oops... error occurred');
        }
        return redirect()->route($this->base_route.'index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=$this->model->find($id);
        $d=$data->delete();
        if($d){
            Alert::success('success',$this->panel.' deleted success');
        }else{
            Alert::error('error','Oops... something went wrong');
        }
        return redirect()->route($this->base_route.'index');
    }
    public function trash(){
        $data['about']=$this->model->onlyTrashed()->get();
        if(count($data['about'])<1){
            Alert::error('No Data','No Trash Data Found');
            return redirect()->route($this->base_route.'index');
        }
        return view($this->__loadToView($this->base_view.'trash'),compact('data'));
    }
    public function permanentDelete($id){
        $data['about']=$this->model->where('id',$id)->onlyTrashed()->first();
        if ($data['about']->image && file_exists(public_path('images/about/' . $data['about']->image))) {
            unlink(public_path('images/about/' . $data['about']->image));
        }
        if(!$data['about']){
            Alert::error('error','Oops ... record not found');
            return redirect()->route($this->base_route . 'index');
        }
        if($data['about']->forceDelete()){
            Alert::success('success', $this->panel. ' Deleted Permanently');
        } else {
            Alert::error('error','Oops ... error occurred while deleting record');
        }
        return redirect()->route($this->base_route.'index');
    }
    public function restore($id){
        $data['about']=$this->model->where('id',$id)->onlyTrashed()->first();
        if (!$data['about']){
            Alert::error('error','Oops ... record not found');
            return redirect()->route($this->base_route . 'index');
        }
        if($data['about']->restore()){
            Alert::success('success', $this->panel . ' Recovered Successfully');
        } else {
            Alert::error('error','Oops ... error occurred while recovering record');
        }
        return redirect()->route($this->base_route . 'index');
    }
}

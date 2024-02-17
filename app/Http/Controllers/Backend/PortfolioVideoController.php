<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PortfolioVideoRequest;
use App\Models\PortfolioVideo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PortfolioVideoController extends BackendBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $panel = 'Portfolio Videos';
    protected $base_route = 'backend.portfolio_videos.';
    protected $base_view = 'backend.portfolio_videos.';
    protected $model;

    function __construct(){
        $this->model = new PortfolioVideo();
    }
    public function index(){
        $data['videos'] = $this->model->all();
        if(count($data['videos'])<1){
            Alert::error('No Data','No Data Found');
            return view($this->__loadToView($this->base_view.'create'));
        }else{
            return view($this->__loadToview($this->base_view.'index'),compact('data'));
        }
    }
    public function create(){
        return view($this->__loadToView($this->base_view.'create'));
    }
    public function store(PortfolioVideoRequest $request){
        try {
            $request->request->add(['created_by' => auth()->user()->id]);
            if ($request->hasFile('image_thumbnail')) {
                $image = $request->file('image_thumbnail');
                $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images/portfolio_videos/', $imageFilename);
                $request->request->add(['thumbnail' => $imageFilename]);
            }
            $record = $this->model->create($request->all());
            if ($record) {
                Alert::success('success', $this->panel . 'created successfully');
            } else {
                Alert::error('error', $this->panel . 'creation failed');
            }
        }catch (\Exception $exception){
            Alert::error('error','Ooops.. Error Occur: '.$exception->getMessage());
        }
        return redirect()->route($this->base_route.'create');
    }
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
    public function update(PortfolioVideoRequest $request, string $id)
    {
        $data['records']=$this->model->find($id);
        if ($request->hasFile('image_thumbnail')) {
            $image = $request->file('image_thumbnail');
            $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('images/portfolio_videos/', $imageFilename);
            // Delete the old image file if it exists
            if ($data['records']->thumbnail && file_exists(public_path('images/portfolio_videos/' . $data['records']->thumbnail))) {
                unlink(public_path('images/portfolio_videos/' . $data['records']->thumbnail));
            }
            $request->request->add(['thumbnail' => $imageFilename]);
        }
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
        if ($data['record']->thumbnail && file_exists(public_path('images/portfolio_videos/' . $data['record']->thumbnail))) {
            unlink(public_path('images/portfolio_videos/' . $data['record']->thumbnail));
        }
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

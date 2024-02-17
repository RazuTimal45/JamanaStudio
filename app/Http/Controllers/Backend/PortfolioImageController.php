<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PortfolioImageRequest;
use App\Http\Requests\Backend\TeamRequest;
use App\Models\PortfolioImage;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use function NunoMaduro\Collision\Exceptions\getMessage;
use RealRashid\SweetAlert\Facades\Alert;

class PortfolioImageController extends BackendBaseController
{
    protected $panel = 'Portfolio Image';
    protected $base_route = 'backend.portfolio_images.';
    protected $base_view = 'backend.portfolio_images.';
    protected $model;
    function __construct(){
        $this->model = new PortfolioImage();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['records'] = $this->model->orderBy('created_at','desc')->get();
        if (count($data['records'])<1) {
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
    public function store(PortfolioImageRequest $request)
    {
        try{
            $request->request->add(['created_by' => auth()->user()->id]);
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images/portfolio_images/', $imageFilename);
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
        $data['record']=$this->model->find($id);
        if(!$data['record']){
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
        $data['record']=$this->model->find($id);
        if(!$data['record']){
            Alert::error('No Data','No Data Found');
            return redirect()->route($this->base_route.'index');
        }
        return view($this->__loadToView($this->base_view . 'edit'),compact('data'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PortfolioImageRequest $request, string $id)
    {
        $data['records']=$this->model->find($id);
        $request->request->add(['updated_by' => auth()->user()->id]);
        if($request->hasfile('image_file')) {
            $filename = uniqid() . '.' . $request->file('image_file')->getClientOriginalExtension();;
            $request->file('image_file')->move('images/portfolio_images/', $filename);
            $request->request->add(['image' => $filename]);
            if ($data['records']->image && file_exists(public_path('images/portfolio_images/' . $data['records']->image))) {
                unlink(public_path('images/portfolio_images/' . $data['records']->image));
            }
        }
        $d=$data['records']->update($request->all());
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
        $data['records']=$this->model->onlyTrashed()->get();
        if(count($data['records'])<1){
            Alert::error('No Data','No Trash Data Found');
            return redirect()->route($this->base_route.'index');
        }
        return view($this->__loadToView($this->base_view.'trash'),compact('data'));
    }
    public function permanentDelete($id){
        $data['record']=$this->model->where('id',$id)->onlyTrashed()->first();
        if ($data['record']->image && file_exists(public_path('images/portfolio_images/' . $data['record']->image))) {
            unlink(public_path('images/portfolio_images/' . $data['record']->image));
        }
        if(!$data['record']){
            Alert::error('error','Oops ... record not found');
            return redirect()->route($this->base_route . 'index');
        }
        if($data['record']->forceDelete()){
            Alert::success('success', $this->panel. ' Deleted Permanently');
        } else {
            Alert::error('error','Oops ... error occurred while deleting record');
        }
        return redirect()->route($this->base_route.'index');
    }
    public function restore($id){
        $data['record']=$this->model->where('id',$id)->onlyTrashed()->first();
        if (!$data['record']){
            Alert::error('error','Oops ... record not found');
            return redirect()->route($this->base_route . 'index');
        }
        if($data['record']->restore()){
            Alert::success('success', $this->panel . ' Recovered Successfully');
        } else {
            Alert::error('error','Oops ... error occurred while recovering record');
        }
        return redirect()->route($this->base_route . 'index');
    }
}

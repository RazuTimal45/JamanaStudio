<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\HeadingRequest;
use App\Models\Heading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use function NunoMaduro\Collision\Exceptions\getMessage;

class   HeadingController extends BackendBaseController
{
    protected $panel = 'Heading';
    protected $base_route = 'backend.headings.';
    protected $base_view = 'backend.headings.';
    protected $model;

    function __construct(){
        $this->model = new Heading();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['records'] = $this->model->all();
        if(count($data['records'])<1){
            Alert::error('No Data','No Data Found');
            return view($this->__loadToView($this->base_view.'create'));
        }else{
            return view($this->__loadToView($this->base_view . 'index'),compact('data'));
        }
    }

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
    public function store(HeadingRequest $request)
    {
        try{
            $request->request->add(['created_by' => auth()->user()->id]);
            if ($request->hasFile('image_file')) {
                $image = $request->file('image_file');
                $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images/settings/', $imageFilename);
                $request->request->add(['image' => $imageFilename]);
            }

            if ($request->hasFile('logo_header_file')) {
                $logoHeader = $request->file('logo_header_file');
                $logoHeaderFilename = uniqid() . '.' . $logoHeader->getClientOriginalExtension();
                $logoHeader->move('images/settings/', $logoHeaderFilename);
                $request->request->add(['logo_header' => $logoHeaderFilename]);
            }

            if ($request->hasFile('logo_footer_file')) {
                $logoFooter = $request->file('logo_footer_file');
                $logoFooterFilename = uniqid() . '.' . $logoFooter->getClientOriginalExtension();
                $logoFooter->move('images/settings/', $logoFooterFilename);
                $request->request->add(['logo_footer' => $logoFooterFilename]);
            }

            if ($request->hasFile('hero_image_file')) {
                $heroImage = $request->file('hero_image_file');
                $heroImageFilename = uniqid() . '.' . $heroImage->getClientOriginalExtension();
                $heroImage->move('images/settings/', $heroImageFilename);
                $request->request->add(['hero_image' => $heroImageFilename]);
            }
            if ($request->hasFile('video_file')) {
                $videoFile = $request->file('video_file');
                $videoFilename = uniqid() . '.' . $videoFile->getClientOriginalExtension();
                $videoFile->move('videos/settings/', $videoFilename);
                $request->request->add(['video' => $videoFilename]);
            }

            if ($request->hasFile('fav_icon_file')) {
                $favIcon = $request->file('fav_icon_file');
                $favIconFilename = uniqid() . '.' . $favIcon->getClientOriginalExtension();
                $favIcon->move('images/settings/', $favIconFilename);
                $request->request->add(['fav_icon' => $favIconFilename]);
            }
            $record = $this->model->create($request->all());
            if ($record){
                Alert::success('success',$this->panel.' created successfully');
            } else  {
                Alert::error('error',$this->panel.' creation failed');
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
    public function update(HeadingRequest $request, string $id)
    {
        $data['records']=$this->model->find($id);
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $imageFilename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('images/settings/', $imageFilename);
            // Delete the old image file if it exists
            if ($data['records']->image && file_exists(public_path('images/settings/' . $data['records']->image))) {
                unlink(public_path('images/settings/' . $data['records']->image));
            }
            $request->request->add(['image' => $imageFilename]);
        }
        if ($request->hasFile('logo_header_file')) {
            $logoHeader = $request->file('logo_header_file');
            $logoHeaderFilename = uniqid() . '.' . $logoHeader->getClientOriginalExtension();
            $logoHeader->move('images/settings/', $logoHeaderFilename);
            // Delete the old logo header file if it exists
            if ($data['records']->logo_header && file_exists(public_path('images/settings/' . $data['records']->logo_header))) {
                unlink(public_path('images/settings/' . $data['records']->logo_header));
            }
            $request->request->add(['logo_header' => $logoHeaderFilename]);
        }
        if ($request->hasFile('logo_footer_file')) {
            $logoFooter = $request->file('logo_footer_file');
            $logoFooterFilename = uniqid() . '.' . $logoFooter->getClientOriginalExtension();
            $logoFooter->move('images/settings/', $logoFooterFilename);
            // Delete the old logo footer file if it exists
            if ($data['records']->logo_footer && file_exists(public_path('images/settings/' . $data['records']->logo_footer))) {
                unlink(public_path('images/settings/' . $data['records']->logo_footer));
            }
            $request->request->add(['logo_footer' => $logoFooterFilename]);
        }
        if ($request->hasFile('hero_image_file')) {
            $heroImage = $request->file('hero_image_file');
            $heroImageFilename = uniqid() . '.' . $heroImage->getClientOriginalExtension();
            $heroImage->move('images/settings/', $heroImageFilename);
            // Delete the old hero_image file if it exists
            if ($data['records']->hero_image && file_exists(public_path('images/settings/' . $data['records']->hero_image))) {
                unlink(public_path('images/settings/' . $data['records']->hero_image));
            }
            $request->request->add(['hero_image' => $heroImageFilename]);
        }
        if ($request->hasFile('fav_icon_file')) {
            $favIcon = $request->file('fav_icon_file');
            $favIconFilename = uniqid() . '.' . $favIcon->getClientOriginalExtension();
            $favIcon->move('images/settings/', $favIconFilename);

            // Delete the old fav_icon file if it exists
            if ($data['records']->fav_icon && file_exists(public_path('images/settings/' . $data['records']->fav_icon))) {
                unlink(public_path('images/settings/' . $data['records']->fav_icon));
            }
            $request->request->add(['fav_icon' => $favIconFilename]);
        }
        $request->request->add(['updated_by'=>auth()->user()->id]);
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
        if ($data['record']->image && file_exists(public_path('images/settings/' . $data['record']->image))) {
            unlink(public_path('images/settings/' . $data['record']->image));
        }
        if ($data['records']->fav_icon && file_exists(public_path('images/settings/' . $data['records']->fav_icon))) {
            unlink(public_path('images/settings/' . $data['records']->fav_icon));
        }
        if ($data['records']->hero_image && file_exists(public_path('images/settings/' . $data['records']->hero_image))) {
            unlink(public_path('images/settings/' . $data['records']->hero_image));
        }
        if ($data['records']->logo_footer && file_exists(public_path('images/settings/' . $data['records']->logo_footer))) {
            unlink(public_path('images/settings/' . $data['records']->logo_footer));
        }
        if ($data['records']->logo_header && file_exists(public_path('images/settings/' . $data['records']->logo_header))) {
            unlink(public_path('images/settings/' . $data['records']->logo_header));
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

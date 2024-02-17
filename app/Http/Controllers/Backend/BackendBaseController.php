<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BackendBaseController extends Controller
{
    protected function __loadToView($file_path){
        View::composer($file_path, function ($view) {
            $view->with('panel',$this->panel);
            $view->with('base_route',$this->base_route);
            $view->with('base_view',$this->base_view);
        });
        return $file_path;
    }
}

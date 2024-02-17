<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='settings';
    protected $fillable=['name','slogan','about_website','image','logo_header','logo_footer','hero_image','fav_icon','email','optional_email','phone','mobile','address','status','created_by','meta_title','meta_description','meta_keyword','created_by','updated_by'];
    function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}

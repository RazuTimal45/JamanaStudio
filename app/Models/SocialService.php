<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialService extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='social_medias';
    protected $fillable=['facebook','linked_in','twitter','instagram','status','created_by','updated_by'];
    function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}

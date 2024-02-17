<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Heading extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='headings';
    protected $fillable = [
        'service', 'portfolio', 'blogs', 'contact', 'about', 'status', 'created_by', 'updated_by'
    ];
    function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}

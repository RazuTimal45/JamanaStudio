<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='blogs';
    protected $fillable = [
        'event_date',
        'event_type',
        'event_title',
        'rank',
        'image',
        'first_description',
        'second_description',
        'third_description',
        'status',
        'created_by',
        'updated_by',
    ];
    function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    function updatedBy(){
        return $this->belongsTo(User::class,'updated_by','id');
    }
}

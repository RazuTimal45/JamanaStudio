<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='appointments';
    protected $fillable=['name','email','phone','service_id','starting_date','ending_date','message','is_appointed'];
    public function services(){
        return $this->belongsTo(Service::class,'service_id','id');
       }

}

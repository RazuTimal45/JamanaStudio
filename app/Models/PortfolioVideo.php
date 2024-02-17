<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioVideo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'portfolio_videos';
    protected $fillable = ['title','rank','thumbnail','video_url','created_by','updated_by','status'];
    // Define relationships
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by','id');
    }
}

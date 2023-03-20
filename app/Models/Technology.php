<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technology extends Model
{
 
    protected $fillable=["label","color"];

    protected $dates = ['deleted_at'];
    use HasFactory;
    public function projects(){
        return $this->belongsToMany(Project::class);
    }
}
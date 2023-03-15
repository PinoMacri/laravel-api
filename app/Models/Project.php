<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{

    protected $fillable=["title","description","image","github", "is_published", "type_id"];
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function type(){
        return $this->belongsTo(Type::class);
    }


    public function technologies()
    {
        return $this->belongsToMany(Technology::class)->withPivot('deleted_at');
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
protected $fillable = ['name', 'email', 'class_id', 'is_verified', 'verification_token'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}

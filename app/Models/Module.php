<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $guarded = ['id'];

    public function contents() {
        return $this->hasMany(Content::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Issue;

class Store extends Model
{
    protected $table = 'stores';

    public function issues(){
        return $this->hasMany(Issue::class);
    }
}

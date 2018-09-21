<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function items_sort()
    {
        return $this->hasMany(Item::class)->orderBy('price', 'desc');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function items()
    {
        return $this->hasMany(Item::Class);
    }

    public function items_sort()
    {
        return $this->hasMany(Item::Class)->orderBy('price', 'desc');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Person extends Model
{
    protected $table = 'persons';

    public function memos()
    {
        return $this->hasMany(Memo::class);
    }
}

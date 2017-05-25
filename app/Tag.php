<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function posts() {
        return $this->belongsToMany('App\Post'); // ('app\post, name_of_table, tag_id, post_id(foreign key) )
    }
}

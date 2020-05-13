<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Tiên 14/03
    protected $table = 'binhluan';
	protected $primaryKey = 'bl_id';
	protected $guarded = [];
   
}

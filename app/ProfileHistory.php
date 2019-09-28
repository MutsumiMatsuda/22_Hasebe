<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileHistory extends Model
{
    public static $rules = array(
        'user_id' => 'required',
        'edited_at' => 'required',
    );
}

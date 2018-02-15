<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Idtype;

class Sopir extends Model {
    use SoftDeletes;

    public function idtype()
    {
        return $this->belongsTo(Idtype::class);
    }
}

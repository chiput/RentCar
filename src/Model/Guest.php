<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Negara;
use App\Model\Company;
use App\Model\Idtype;

class Guest extends Model {
    use SoftDeletes;

    public function country()
    {
        return $this->belongsTo(Negara::class,'country_id','id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function idtype()
    {
        return $this->belongsTo(Idtype::class);
    }
}

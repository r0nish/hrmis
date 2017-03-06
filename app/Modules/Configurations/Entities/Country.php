<?php

namespace App\Modules\Configurations\Entities;

use App\Modules\Foundation\Entities\BaseModel;
class Country extends BaseModel implements CountryInterface
{


    protected $table = 'tbl_country';

    protected $guarded = [];
    protected $primaryKey = 'id_country';

    protected $fillable = ['id_country', 'desc', 'status', 'created_by, updated_by', 'created_at', 'updated_at'];
}

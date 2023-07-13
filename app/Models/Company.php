<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function getDetail() {
        $companies = DB::table('companies')->get();

        return $companies;
    }

    public function products() {
        return $this->hasMany('App\Models\Product', 'company_id', 'id');
    }

    protected $fillable = [
        'company_name',
        'street_address',
        'representive_name',
    ];

    protected $attributes = [
        'representive_name' => '',
    ];
}

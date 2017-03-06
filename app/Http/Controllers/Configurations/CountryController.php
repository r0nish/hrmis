<?php

namespace App\Http\Controllers\Configurations;

use App\APIHelpers\Transformers\CountryTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Modules\Configurations\Services\CountryService;
use App\Modules\Foundation\Controllers\AbstractController;


class CountryController extends AbstractController
{
    protected $service;
    protected $dataTransformer;
    protected $primary_key = 'id_country';

    public function __construct(
        CountryService $service,
        CountryTransformer $countryTransformer
    ) {
        $this->service = $service;
        $this->dataTransformer = $countryTransformer;
    }

}

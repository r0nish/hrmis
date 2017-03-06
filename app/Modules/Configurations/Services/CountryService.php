<?php

namespace App\Modules\Configurations\Services;

use App\Modules\Configurations\Repositories\CountryRepositoryInterface;
use App\Modules\Configurations\Validators\CountryValidator;
use App\Modules\Foundation\Services\AbstractService;

class CountryService extends AbstractService
{
    protected $repository;
    protected $validator;

    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->validator = new CountryValidator();
    }

}

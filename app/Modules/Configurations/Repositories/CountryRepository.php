<?php
namespace App\Modules\Configurations\Repositories;

use App\Modules\Configurations\Entities\Country;
use App\Modules\Configurations\Entities\CountryInterface;
use App\Modules\Foundation\Repositories\AbstractRepository;

class CountryRepository extends AbstractRepository implements CountryRepositoryInterface
{
    protected $model;

    public function __construct(CountryInterface $model)
    {
        $this->model = $model;
    }


}

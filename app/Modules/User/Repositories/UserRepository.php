<?php

    namespace App\Modules\User\Repositories;

    use Illuminate\Pagination\Paginator;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use App\Modules\Exception\ExceptionLogger;
    use App\Modules\User\Entities\UserInterface;
    use App\Modules\Foundation\Repositories\AbstractRepository;

    class UserRepository extends AbstractRepository implements UserRepositoryInterface
    {
        protected $model;

        public function __construct(UserInterface $model)
        {
            $this->model = $model;
        }


    }

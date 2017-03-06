<?php

    namespace App\Modules\User\Http\Controllers;

    use App\Modules\Foundation\Controllers\AbstractController;
    use Illuminate\Contracts\Auth\Guard;
    use App\Modules\User\Entities\User;
    use App\Modules\User\Services\UserService;

    class UserController extends AbstractController
    {

        protected $service;
        protected $dataTransformer;
        protected $userDetailTransformer;
        protected $model;
        protected $primary_key = 'id_user';
        public $auth;
        protected $userSalesTransformer;
        protected $userLocationTransformer;


        /**
         * UserController constructor.
         *
         * @param UserService     $service
         * @param UserTransformer $userTransformer
         */
        public function __construct(
            Guard $auth,
            UserSalesTransformer $userSalesTransformer,
            UserHierarchyTransformer $userHierarchyTransformer,
            UserService $service,
            User $model,
            UserTransformer $userTransformer,
            UserDetailTransformer $userDetailTransformer,
            UserLocationTransformer $userLocationTransformer

        )
        {

            $this->service = $service;
            $this->model = $model;
            $this->dataTransformer = $userTransformer;
            $this->userDetailTransformer = $userDetailTransformer;
            $this->userSalesTransformer = $userSalesTransformer;
            $this->userHierarchyTransformer = $userHierarchyTransformer;
            $this->userLocationTransformer = $userLocationTransformer;
        }

        public function getUser()
        {
            $userId = $this->service->getById(2);

            return $userId;
        }

    }

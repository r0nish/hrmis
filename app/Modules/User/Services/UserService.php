<?php

	namespace App\Modules\User\Services;

	use App\Modules\Foundation\Services\AbstractService;
    use App\Modules\User\Repositories\UserRepositoryInterface;
	use App\Modules\User\Validators\UserValidator;

    class UserService extends AbstractService
	{
		protected $repository;
		protected $validator;

		public function __construct(UserRepositoryInterface $repository)
		{
			$this->repository = $repository;
			$this->validator = new UserValidator();
		}


//    public function getFilterList($data = [])
//    {
//        return $this->repository->getFilterList($data);
//    }


		/*
	
			login...abstract
	
			login  check
		session create
		auth key generate
		return authkey
	
	
		logout..
			session clear.*/


	}

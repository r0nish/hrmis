<?php

    namespace App\Modules\Foundation\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Response;


    class RestfulApiController extends ApiController
    {
        /**
         * @var int
         */
        protected $statusCode = 200;

        /**
         * @return mixed
         */
        public function getStatusCode()
        {
            return $this->statusCode;
        }

        /**
         * @param mixed $statusCode
         *
         * @return $this
         */
        public function setStatusCode($statusCode)
        {
            $this->statusCode = $statusCode;

            return $this;
        }

        public function responseNotFound($message = 'Not Found!')
        {
            return $this->setStatusCode(404)->respondWithError($message);
        }

        public function responseValidationError($message = ' Validation Required')
        {
            return $this->setStatusCode(200)->respondWithError($message);
        }

        public function respond($data, $headers = [])
        {
            return Response::json(array_merge($data), $this->getStatusCode(), $headers);
        }

        public function respondError($data, $headers = [])
        {
            return Response::json(array_merge(['status' => 'fail'], $data), $this->getStatusCode(), $headers);
        }

        public function respondWithError($message)
        {

            return (Response::json(['errors' =>
                                        [[
                                            'message'       => $message
                                            , 'status_code' => $this->getStatusCode()
                                        ]]
                                   ]
            ));

        }


        public function responseUnathorized($message = 'Not Found!')
        {
            return $this->setStatusCode(404)->respondWithError($message);
        }

        public function errorRespond($data, $headers = [])
        {
            return Response::json($data, $this->getStatusCode(), $headers);
        }

    }

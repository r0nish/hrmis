<?php

	namespace App\Modules\Foundation\Controllers;

	use Illuminate\Http\Request;
	use Illuminate\Http\Response;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\MessageBag;


	abstract class AbstractController extends ApiController
	{

		protected $service;
		protected $dataTransformer;
		protected $active = 1;
		protected $primary_key = 'id';

		/**
		 * paginatedList for all the models.
		 * Can include the filter section here.
		 *
		 * @return mixed
		 */
//	public function paginatedList()
//	{
////		$entityCollection = $this->service->getPaginate();
////
////		/**
////		 * Secure me please
////		 *
////		 * traits method
////		 */
////		return $this->respond([
////				'total' => $entityCollection['total'],
////				'data' => $this->dataTransformer->transformCollection($entityCollection['data'])
////		]);
//
//	}


		public function paginatedList(Request $request)
		{

			$restrictions = $this->getRestrictionFields($request);

			$entityCollection = $this->service->getPaginateList($request->input());


			/** Please correct the status here. It's only the quick fix.. Please send data as array if is paginate list. */

			if (is_array($entityCollection)) {

				return $this->respond([
										  'total'       => $entityCollection ['total'],
										  'data'        => $this->dataTransformer->transformCollection($entityCollection['data'], $restrictions),
										  'permissions' => $restrictions
									  ]);
			}

			//$entityCollection =(object)$entityCollection;

			return $this->respond([
									  'total'       => $entityCollection->total(),
									  'data'        => $this->dataTransformer->transformCollection($entityCollection, $restrictions),
									  'permissions' => $restrictions

								  ]);

		}

		public function NonHierarchyPaginatedList(Request $request)
		{
			$entityCollection = $this->service->getPaginateList($request->input());

			/**
			 * Secure me please
			 *
			 * traits method
			 */
			return $this->respond([
									  'total' => $entityCollection->total(),
									  'last'  => $entityCollection->lastPage(),
									  'data'  => $this->dataTransformer->transformCollection($entityCollection, true)
								  ]);

		}

		public function NonHierarchyList()
		{
			$entityCollection = $this->service->getAll();

			return $this->respond([
									  'data' => $this->dataTransformer->transformCollection($entityCollection, true),
								  ]);
		}


		/**
		 *
		 * get the list of model / table
		 * with the status active.
		 *
		 * Status 1 is active ( hardcoded )
		 */
		public function index()
		{

			$businessUnit = $this->service->getAll();
			$permissions = [];

			return $this->respond([
									  'data' => $this->dataTransformer->transformCollection($businessUnit, $permissions),
								  ]);
		}


		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request|\Illuminate\Http\Request $request
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{

			$permission = [];
			$input = $request->input();
			$data = isset($input['detail']) ? $input['detail'] : '';
			$createData = $this->service->create($data);

			/**
			 * Validation Error Section.
			 */
			if ($createData instanceof MessageBag) {
				return $this->responseValidationError($createData);
			}

			return $this->respond([
									  'data' => $this->dataTransformer->transform($createData, $permission),
								  ]);
		}


		/**
		 * Edit the model
		 *
		 * @param Request $request
		 * @param         $id
		 *
		 * @return mixed
		 */

		public function update(Request $request, $id)
		{
			$input = $request->input();
			$data = isset($input['detail']) ? $input['detail'] : '';

			$modelId = $this->service->getById($id);

			if (!$modelId) {
				return $this->responseNotFound('Not found Exception.');
			}
			$updateData = $this->service->update($modelId[ $this->primary_key ], $data);

			if (!$updateData) {
				return $this->responseValidationError($updateData);
			}

			if ($updateData instanceof MessageBag) {
				return $this->responseValidationError($updateData);
			}

			return $this->respond([
									  'data' => $updateData,
								  ]);
		}


		/**
		 * Display the specified resource.
		 *
		 * @param int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			$permission = [];
			$model = $this->service->getById($id);

			if (!$model) {
				return $this->responseNotFound('Not found Exception');
			}

			return $this->respond([
									  'data' => $this->dataTransformer->transform($model, $permission),
								  ]);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			$model = $this->service->getById($id);
			if (!($model)) {
				return $this->responseNotFound('Not Found');
			}
			$delete = $this->service->delete($model[ $this->primary_key ]);

			return $this->respond([
									  'data' => $delete,
								  ]);
		}


		/**
		 * Deactivate
		 *
		 * @param $id
		 *
		 * @return mixed
		 */

		public function deactivate($id)
		{
			$model = $this->service->getById($id);

			if (!$model) {
				return $this->responseNotFound('Not Found Exception');
			}

			$deactivate = $this->service->deactivate($model[ $this->primary_key ]);

			return $this->respond([
									  'data' => $deactivate,
								  ]);
		}


		/**
		 * Activate
		 *
		 * @param $id
		 *
		 * @return mixed
		 */


		public function activate($id)
		{

			$model = $this->service->getById($id);
			if (!$model) {
				return $this->responseNotFound('not  Found exists');
			}

			$activate = $this->service->activate($model[ $this->primary_key ]);

			return $this->respond([
									  'data' => $activate,
								  ]);
		}


		/**
		 * Generate the report and respond the file name.
		 * @return mixed
		 */

		public function getReports(Request $request)
		{

			$reportContent = $this->service->getReports($request->input());

			if ($reportContent) {
				$filename = 'report-' . time() . '.csv';

				$arrayList = $reportContent['report'];

				touch($filename);
				chmod($filename, 0775);

				$fp = fopen($filename, 'w');

				/**
				 * Write custom heading in the excel
				 */
				fputcsv($fp, $reportContent['columns']);

				foreach ($arrayList as $line) {


					/**
					 * Key comparison if key matches then write in excel else remove that particular key & value from the list
					 */

					foreach ($line as $key => $columnset) {
						if (!in_array($key, array_keys($reportContent['columns']))) {
							unset($line[ $key ]);
						}
					}

					fputcsv($fp, $line);

				}

				fclose($fp);


			}
			else {
				return $this->respondWithError('no file name provided');
			}

			return $this->respond(['data' => 'created file successfully', 'filename' => $filename]);

		}


		/**
		 *
		 * Download the file in the specific location with the file name provided.
		 *
		 * @param Request $request
		 *
		 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
		 *
		 */

		public function downloadFiles(Request $request)
		{

			$fileName = 'report.csv';

			if ($request->input('filename')) {
				$fileName = $request->input('filename');
			}

			if ($fileName) {
				$file = public_path() . "/" . $fileName;
				$headers = [
					'Content-Type: application/txt',
				];

				return response()->download($file, $fileName, $headers);
			}
			else {
				return $this->respondWithError('no file name provided');
			}


		}


		/**
		 * get the Restriction Fields for the permission setups
		 * Should be used by all the controller before responding back to Request.
		 */


		public function getRestrictionFields(Request $request)
		{

			/** Get the restriction fields from the security permission $restrictions */
			$restrictions = [];
			$permissionFilter = ($request->input());


			if (!empty($permissionFilter) && isset($permissionFilter['route_url']) && isset($permissionFilter[ $permissionFilter['route_url'] ])) {
				$restrictions = $permissionFilter[ $permissionFilter['route_url'] ];
			}


			return $restrictions;


		}

	}
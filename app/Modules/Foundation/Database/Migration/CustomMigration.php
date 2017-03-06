<?php

// app/Database/Migration.php

	namespace Modules\Foundation\Database\Migration;

	use Illuminate\Support\Facades\DB;

	class CustomMigration extends \Illuminate\Database\Migrations\Migration
	{
		protected $schema;

		public function __construct()
		{
			$this->schema = DB::connection()->getSchemaBuilder();

			$this->schema->blueprintResolver(function ($table, $callback) {
				return new CustomBluePrint($table, $callback);
			});
		}
	}

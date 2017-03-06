<?php

	use Modules\CustomBluePrint;
	use Modules\CustomMigration;

	class CreatePermissionTable extends CustomMigration
	{
		public function __construct()
		{
			parent::__construct();
		}

		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('permission', function (CustomBluePrint $table) {
				$table->increments('id_permission');
				$table->string('description');
				$table->string('role_name');
				$table->tinyInteger('status');
				$table->authors();
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			$this->schema->dropIfExists('permission');
		}
	}

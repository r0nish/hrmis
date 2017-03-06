<?php

	use Modules\CustomBluePrint;
	use Modules\CustomMigration;

	class CreateEntityTable extends CustomMigration
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
			$this->schema->create('entity', function (CustomBluePrint $table) {
				$table->increments('id_entity');
				$table->integer('title');

				$table->authors();

				$table->timestamps();

			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			$this->schema->dropIfExists('entity');
		}
	}
<?php

	use Modules\CustomBluePrint;
	use Modules\CustomMigration;

	class CreateEntityPropertyTable extends CustomMigration
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
			$this->schema->create('entity_property', function (CustomBluePrint $table) {
				$table->increments('id_entity_property');
				$table->integer('entity_id')->unsigned();
				$table->integer('role_id')->unsigned();
				$table->integer('field_name');
				$table->integer('label');

				$table->authors();

				$table->timestamps();

			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			$this->schema->dropIfExists('entity_property');
		}
	}
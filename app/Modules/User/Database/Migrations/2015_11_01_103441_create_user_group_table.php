<?php

	use Modules\CustomBluePrint;
	use Modules\CustomMigration;

	class CreateUserGroupTable extends CustomMigration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			$this->schema->create('user_group', function (CustomBluePrint $table) {
				$table->increments('id_user_group');
				$table->string('group_name')->unique();
				$table->integer('parent_group_id')->unsigned();
				$table->tinyInteger('status');
				$table->authors();
				$table->timestamps();
				$table->foreign('parent_group_id')->references('id_user_group')->on('user_group');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('user_group');
		}
	}

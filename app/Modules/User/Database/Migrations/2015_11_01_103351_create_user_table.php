<?php

	use Modules\CustomBluePrint;
	use Modules\CustomMigration;

	class CreateUserTable extends CustomMigration
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
			$this->schema->create('user', function (CustomBluePrint $table) {
				$table->increments('id_user');
				$table->integer('user_group_id')->unsigned();
				$table->string('email')->unique();
				$table->string('password', 60);
				$table->rememberToken();
				$table->string('first_name');
				$table->string('last_name');
				$table->string('IMEI_number')->unique();
				$table->string('mobile_number');
				$table->string('MAC_id')->unique();
				$table->string('auth_type');
				$table->string('password_reset_hash');
				$table->timestamp('password_reset_time');
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
			$this->schema->dropIfExists('user');
		}
	}

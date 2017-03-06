<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Migrations\Migration;

	class CreateAssignGroupToUser extends Migration
	{
		/**
		 * Run the migrations.
		 */
		public function up()
		{
			Schema::table('user', function (Blueprint $table) {
				$table->foreign('user_group_id')->references('id_user_group')->on('user_group');
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down()
		{
			Schema::drop('');
		}
	}

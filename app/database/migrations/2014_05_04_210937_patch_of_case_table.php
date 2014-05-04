<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchOfCaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('appeal_cases', function($table)
		{
		    $table->integer('reply_status')->default(1)->after('case_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('appeal_cases', function($table)
		{
		    $table->dropColumn('reply_status');
		});
	}

}

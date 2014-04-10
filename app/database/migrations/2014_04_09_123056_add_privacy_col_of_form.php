<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivacyColOfForm extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('appeal_forms', function($table)
        {
            $table->string('f_privacy')->after('f_status');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('appeal_forms', function($table)
        {
            $table->dropColumn('f_privacy');
        });
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appeal_actions', function($table)
        {
            $table->increments('id');
            $table->integer('operator_u_id')->unsigned()->unique();
            $table->string('type');
            $table->string('event');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('appeal_managers', function($table)
        {
        	// 1 正常
        	// 2 停權
            $table->integer('m_status')->unsigned()->default(1)->after('m_email');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('appeal_managers', function($table)
		{
		    $table->dropColumn('m_status');
		});

        $prefix = 'bak_';
        $suffix = '_' . date('YmdHis');

        Schema::rename('appeal_actions', $prefix . 'appeal_actions' . $suffix);
	}

}

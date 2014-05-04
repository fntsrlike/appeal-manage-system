<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeal_managers', function($table)
        {
            $table->increments('m_id');
            $table->integer('u_id')->unsigned()->unique();
            $table->string('m_name');
            $table->string('m_title');
            $table->string('m_email');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appeal_complainants', function($table)
        {
            $table->increments('c_id');
            $table->integer('u_id')->unsigned()->unique();
            $table->string('c_name');
            $table->integer('c_number');
            $table->string('c_department');
            $table->integer('c_grade');
            $table->string('c_phone');
            $table->string('c_email');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appeal_forms', function($table)
        {
            $table->increments('f_id');
            $table->integer('c_id')->unsigned();
            $table->string('f_title');
            $table->date('f_date');
            $table->string('f_place');
            $table->string('f_target');
            $table->text('f_content');
            $table->text('f_report');
            $table->integer('f_status');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appeal_replies', function($table)
        {
            $table->increments('r_id');
            $table->integer('f_id')->unsigned();
            $table->string('r_type');
            $table->text('r_content');
            $table->integer('r_u_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appeal_ilt_users', function($table)
        {
            $table->increments('u_id');
            $table->string('username')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = 'bak_';
        $suffix = '_' . date('YmdHis');

        Schema::rename('appeal_complainants', $prefix . 'appeal_complainants' . $suffix);
        Schema::rename('appeal_forms', $prefix . 'appeal_forms' . $suffix);
        Schema::rename('appeal_replies', $prefix . 'appeal_replies' . $suffix);
        Schema::rename('appeal_users', $prefix . 'appeal_users' . $suffix);
    }

}

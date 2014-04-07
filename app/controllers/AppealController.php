<?php

class AppealController extends BaseController {

    protected $layout = 'master';

	public function index()
	{
        $data = array();

        return View::make('appeal.appeal')->with($data);
	}

}
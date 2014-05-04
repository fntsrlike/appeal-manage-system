<?php

class API_ComplainantController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	private function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	private function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	private function store()
	{
		$rules      = Config::get('vallidation.complainant.store.rules');
		$messages   = Config::get('vallidation.complainant.store.massages');
		$validator  = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
		    return Response::json();
		}
		else {
		    $complainant = new Iltcomplainant;
		    $complainant->u_id 			= Input::get('u_id');
		    $complainant->c_name 		= Input::get('name');
		    $complainant->c_number 		= Input::get('number');
		    $complainant->c_department 	= Input::get('department');
		    $complainant->c_grade 		= Input::get('grade');
		    $complainant->c_phone 		= Input::get('phone');
		    $complainant->c_email 		= Input::get('email');
		    $complainant->save();

		    return Response::json();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	private function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	private function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	private function update($id)
	{
		$rules      = Config::get('vallidation.complainant.update.rules');
		$messages   = Config::get('vallidation.complainant.update.massages');
		$validator  = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
		    return Response::json();
		}
		else {
		    $complainant = Iltcomplainant::find($id);
		    $complainant->u_id 			= Input::get('u_id');
		    $complainant->c_name 		= Input::get('name');
		    $complainant->c_number 		= Input::get('number');
		    $complainant->c_department 	= Input::get('department');
		    $complainant->c_grade 		= Input::get('grade');
		    $complainant->c_phone 		= Input::get('phone');
		    $complainant->c_email 		= Input::get('email');
		    $complainant->save();

		    return Response::json();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	private function destroy($id)
	{
		$complainant = Iltcomplainant::find($id);
		$complainant->delete();
	}

}
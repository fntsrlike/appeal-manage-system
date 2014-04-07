<?php

class API_ReplyConroller extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules      = Config::get('vallidation.reply.store.rules');
		$messages   = Config::get('vallidation.reply.store.massages');
		$validator  = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
		    return Response::json();
		}
		else {
		    $reply = new Reply;
		    $reply->f_id  		= Input::get('form_id');
		    $reply->r_type  	= Input::get('type');
		    $reply->r_content  	= Input::get('content');
		    $reply->u_id  		= Input::get('u_id');
		    $reply->save();

		    return Response::json();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules      = Config::get('vallidation.reply.update.rules');
		$messages   = Config::get('vallidation.reply.update.massages');
		$validator  = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
		    return Response::json();
		}
		else {
		    $reply = Reply::find($id);
		    $reply->f_id  		= Input::get('form_id');
		    $reply->r_type  	= Input::get('type');
		    $reply->r_content  	= Input::get('content');
		    $reply->u_id  		= Input::get('u_id');
		    $reply->save();

		    return Response::json();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$reply = Reply::find($id);
		$reply->delete();
	}

}
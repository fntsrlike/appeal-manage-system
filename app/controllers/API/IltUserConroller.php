<?php

class API_IltUserConroller extends \BaseController {

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
        $rules      = Config::get('vallidation.user.store.rules');
        $messages   = Config::get('vallidation.user.store.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $user = new IltUser;
            $user->username = Input::get('username');
            $user->save();

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
        $rules      = Config::get('vallidation.user.update.rules');
        $messages   = Config::get('vallidation.user.update.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $user = IltUser::find($id);
            $user->username = Input::get('username');
            $user->save();

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
        $user = IltUser::find($id);
        $user->delete();
    }

}
<?php

class API_ManagerController extends \BaseController {

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
        $rules      = Config::get('vallidation.manager.store.rules');
        $messages   = Config::get('vallidation.manager.store.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $manager = new Manager;
            $manager->u_id    = Input::get('u_id');
            $manager->m_name  = Input::get('name');
            $manager->m_title = Input::get('title');
            $manager->m_email = Input::get('email');
            $manager->save();

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
        $rules      = Config::get('vallidation.manager.update.rules');
        $messages   = Config::get('vallidation.manager.update.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $manager = Manager::find($id);
            $manager->u_id    = Input::get('u_id');
            $manager->m_name  = Input::get('name');
            $manager->m_title = Input::get('title');
            $manager->m_email = Input::get('email');
            $manager->save();

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
        $manage = Manager::find($id);
        $manager->delete();
    }

}
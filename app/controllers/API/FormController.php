<?php

class API_FormController extends \BaseController {

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
        // $this->beforeFilter('csrf', array('on' => 'post'));

        $rules      = Config::get('vallidation.form.store.rules');
        $messages   = Config::get('vallidation.form.store.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $form = new Form;
            $form->f_title  = Input::get('title');
            $form->f_date   = Input::get('date');
            $form->f_place  = Input::get('place');
            $form->f_target = Input::get('target');
            $form->f_content = Input::get('content');
            $form->save();

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
        // $this->beforeFilter('csrf', array('on' => 'post'));

        $rules      = Config::get('vallidation.form.update.rules');
        $messages   = Config::get('vallidation.form.update.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $form = Form::find($id);
            $form->f_title  = Input::get('title');
            $form->f_date   = Input::get('date');
            $form->f_place  = Input::get('place');
            $form->f_target = Input::get('target');
            $form->f_content = Input::get('content');
            $form->save();

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
        $form = Form::find($id);
        $form->delete();
    }

}
<?php

class API_CaseController extends \BaseController {

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

        $rules      = Config::get('vallidation.case.store.rules');
        $messages   = Config::get('vallidation.case.store.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $case = new CaseModel;
            $case->f_title  = Input::get('title');
            $case->f_date   = Input::get('date');
            $case->f_place  = Input::get('place');
            $case->f_target = Input::get('target');
            $case->f_content = Input::get('content');
            $case->save();

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

        $rules      = Config::get('vallidation.case.update.rules');
        $messages   = Config::get('vallidation.case.update.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json();
        }
        else {
            $case = CaseModel::find($id);
            $case->f_title  = Input::get('title');
            $case->f_date   = Input::get('date');
            $case->f_place  = Input::get('place');
            $case->f_target = Input::get('target');
            $case->f_content = Input::get('content');
            $case->save();

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
        $case = CaseModel::find($id);
        $case->delete();
    }

}
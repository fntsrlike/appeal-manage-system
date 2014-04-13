<?php

class API_CaseController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cases = CaseModel::orderBy('case_id', 'desc')->get();
        $response = array();
        $case_list = array();

        foreach ($cases as $case) {
            $privacy = explode(',', $case->case_privacy);
            $case_privacy = $privacy[0];
            $case_files = array();

            $case_files['id'] = $case->case_id;
            $case_files['status'] = $case->case_status;
            $case_files['privacy'] = $case_privacy;
            $case_files['is_owner'] = false;
            $case_files['created_at'] = $case->created_at;

            if ( Session::has('user.login') and Session::get('user.c_id') == $case->c_id ) {
                $case_privacy = 'public';
                $case_files['is_owner'] = true;
            }

            switch ($case_privacy) {
                case 'secret':
                    $case_files['date'] = '????-??-??';
                    $case_files['title'] = '<本案件標題已經被設為隱藏>';
                    break;

                default:
                    $case_files['date'] = $case->case_date;
                    $case_files['title'] = $case->case_title;
                    break;
            }

            $case_list[] = $case_files;
        }

        return Response::json($case_list);

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

        $rules      = Config::get('validation.case.store.rules');
        $messages   = Config::get('validation.case.store.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $response['status'] = 'validation error';
            $response['msg'] = $messages;

            return Response::json($response);
        }
        else {
            $privacy = Input::get('privacy_case') . ',' . Input::get('privacy_complainant');

            $case = new CaseModel;
            $case->c_id     = Session::get('user.c_id');
            $case->case_title  = Input::get('title');
            $case->case_date   = Input::get('date');
            $case->case_place  = Input::get('place');
            $case->case_target = Input::get('target');
            $case->case_content = Input::get('content');
            $case->case_status  = '1';
            $case->case_privacy = $privacy;
            $case->save();

            $response['status'] = 'success';
            $response['case_id'] = $case->case_id;

            return Response::json($response);
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
        $case        = CaseModel::find($id);
        $complainant = Complainant::find($case->c_id);

        $privacy  = explode(',', $case->case_privacy);
        $case_privacy        = $privacy[0];
        $complainant_privacy = $privacy[1];

        $response = array();

        $response['title']  = $case->case_title;
        $response['target'] = $case->case_target;
        $response['place']  = $case->case_place;
        $response['date']   = $case->case_date;
        $response['status'] = $case->case_status;
        $response['content']= $case->case_content;
        $response['report'] = $case->case_report;

        $response['name']   = $complainant->c_name;
        $response['depart'] = $complainant->c_department;
        $response['grade']  = $complainant->c_grade;
        $response['phone']  = $complainant->c_phone;
        $response['email']  = $complainant->c_email;

        if ( Session::has('user.login') and Session::get('user.c_id') == $case->c_id ) {
            return Response::json($response);
        }
        else {
            $response['phone']  = '<個資>';
            $response['email']  = '<個資>';
        }

        if ( $case_privacy == 'private' or $case_privacy == 'secret' ) {
            $response['target'] = '<隱藏>';
            $response['place']  = '<隱藏>';
            $response['date']   = '<隱藏>';
            $response['content']= '<隱藏>';
            $response['report'] = '<隱藏>';
        }

        if ( $case_privacy == 'secret' ) {
            $response['title']  = '<隱藏>';
        }

        if ( $complainant_privacy == 'protect_dep' or $complainant_privacy == 'private' ) {
            $response['depart'] = '<隱藏>';
        }

        if ( $complainant_privacy == 'protect_name' or $complainant_privacy == 'private' ) {
            $response['name'] = '<隱藏>';
        }

        return Response::json($response);
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

        $rules      = Config::get('validation.case.update.rules');
        $messages   = Config::get('validation.case.update.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
                        $messages = $validator->messages()->all();
            $response['status'] = 'validation error';
            $response['msg'] = $messages;

            return Response::json($response);
        }
        else {
            $privacy = Input::get('privacy_case') . ',' . Input::get('privacy_complainant');

            $case = CaseModel::find($id);
            $case->case_title  = Input::get('title');
            $case->case_date   = Input::get('date');
            $case->case_place  = Input::get('place');
            $case->case_target = Input::get('target');
            $case->case_content = Input::get('content');
            $case->case_privacy = $privacy;
            $case->save();

            $response['status'] = 'success';

            return Response::json($response);
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
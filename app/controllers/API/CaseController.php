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

            $replies = Reply::where('case_id', '=', $case->case_id)->get();

            $privacy = explode(',', $case->case_privacy);
            $case_privacy = $privacy[0];

            $case_files = array();
            $case_files['id'] = $case->case_id;
            $case_files['date'] = $case->case_date;
            $case_files['title'] = $case->case_title;
            $case_files['status'] = $case->case_status;
            $case_files['privacy'] = $case_privacy;
            $case_files['is_owner'] = false;
            $case_files['replies_count'] = $replies->count();
            $case_files['created_at'] = $case->created_at;


            if ( Session::has('user.login') and
                    Session::get('user.c_id') == $case->c_id || Session::get('user.m_id') > 0 ) {
                $case_privacy = 'public';
                $case_files['is_owner'] = true;
            }
            elseif( $case_privacy == 'secret' ) {
                $case_files['date'] = '????-??-??';
                $case_files['title'] = '<本案件標題已經被設為隱藏>';
                $case_files['replies_count'] = '?';
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
        $case = CaseModel::find($id);

        if ( null == $case ) {
            return Response::json(array());
        }

        $complainant = Complainant::find($case->c_id);
        $user = IltUser::find($complainant->u_id);

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
        $response['reply_status'] = $case->reply_status;

        $response['name']   = $user->username;
        $response['depart'] = $complainant->c_department;
        $response['grade']  = $complainant->c_grade;
        $response['phone']  = $complainant->c_phone;
        $response['email']  = $complainant->c_email;

        if ( Session::has('user.login') and
                Session::get('user.c_id') == $case->c_id || Session::get('user.m_id') > 0 ) {
            return Response::json($response);
        }
        else {
            $response['phone']  = '#private';
            $response['email']  = '#private';
        }

        if ( $case_privacy == 'private' or $case_privacy == 'secret' ) {
            $response['target'] = '#private';
            $response['place']  = '#private';
            $response['date']   = '#private';
            $response['content']= '#private';
            $response['report'] = '#private';
        }

        if ( $case_privacy == 'secret' ) {
            $response['title']  = '#private';
        }

        if ( $complainant_privacy == 'protect_dep' or $complainant_privacy == 'private' ) {
            $response['depart'] = '#private';
        }

        if ( $complainant_privacy == 'protect_name' or $complainant_privacy == 'private' ) {
            $response['name'] = '#private';
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

        if ( Input::get('t') == 'update' and false ) {
            $rules      = Config::get('validation.case.update.files.rules');
            $messages   = Config::get('validation.case.update.files.messages');
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
        elseif ( Input::get('t') == 'manage' ) {
            $rules      = Config::get('validation.case.update.manage.rules');
            $messages   = Config::get('validation.case.update.manage.messages');
            $validator  = Validator::make(Input::all(), $rules, $messages);


            if ( false === Session::has('user.login') or Session::get('user.m_id') == 0 ) {
                $response['status'] = '403 Forbidden';
                return Response::json($response);
            }

            if ($validator->fails()) {
                $messages = $validator->messages()->all();
                $response['status'] = '400 Bad Request';
                $response['msg'] = $messages;

                return Response::json($response);
            }
            else {
                $case_status = array( 'todo' => 1, 'doing' => 2, 'done' => 3 );
                $reply_status = array( 'on' => 1, 'off' => 0);

                $case = CaseModel::find($id);
                $case->case_status  = $case_status[Input::get('case_status')];
                $case->reply_status = $reply_status[Input::get('reply_status')];
                Input::has('report') and $case->case_report = Input::get('report');
                $case->save();

                $response['status'] = '200 OK';
                return Response::json($response);
            }
        }
        else {
            $response['status'] = '400 Bad Request';
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
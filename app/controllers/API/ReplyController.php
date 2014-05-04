<?php

class API_ReplyController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $case = CaseModel::find(Input::get('case_id'));

        if ( $case == null ) {
            $response['status'] = '440 Bad Request';
            return Response::json($response);
        }

        $privacy  = explode(',', $case->case_privacy);
        $case_privacy        = $privacy[0];
        $complainant_privacy = $privacy[1];

        if ( $case_privacy != 'public' ) {
            if ( !Session::has('user.login') ) {
                $response['status'] = '401 Unauthorized';
                return Response::json($response);
            }
            elseif ( !(Session::get('user.c_id') == $case->c_id or Session::get('user.m_id') > 0) ) {
                $response['status'] = '403 Forbidden';
                return Response::json($response);
            }
        }

        $replies = Reply::where('case_id', '=', Input::get('case_id'))
                        ->orderBy('created_at', 'asc')
                        ->get();

        $response['count'] = $replies->count();
        $response['replies'] = array();

        foreach ($replies as $reply) {

            if ( $reply->r_type == 'manager') {
                $manager = Manager::where('u_id', '=', $reply->r_u_id)->first();
                $r['manager']['name'] = $manager->m_name;
                $r['manager']['title'] = $manager->m_title;
            }
            else {
                $complainant = Complainant::where('u_id', '=', $reply->r_u_id);
                $user = IltUser::find($reply->r_u_id);

                if ( $complainant_privacy == 'private' or $complainant_privacy == 'protect_name') {
                    $r['complainant']['name'] = '[Complainant]';
                }
                else {
                    $r['complainant']['name'] = $user->username;
                }

            }

            $r['id'] = $reply->r_id;
            $r['type'] = $reply->r_type;
            $r['content'] = $reply->r_content;
            $r['datetime'] = $reply->created_at;

            $response['replies'][] = $r;
        }

        $response['status'] = '200 OK';

        return Response::json($response);

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
    public function store()
    {
        $this->beforeFilter('api_is_login');

        $rules      = Config::get('validation.reply.store.rules');
        $messages   = Config::get('validation.reply.store.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);
        $reply      = new Reply;

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $response['status'] = '400 Bad Request';
            $response['msg'] = $messages;

            return Response::json($response);
        }
        else {
            $case = CaseModel::find(Input::get('case_id'));

            if ( $case->reply_status == 0 ) {
                return Response::json(array('status' => '403 Forbidden'));
            }
            elseif ( $case->c_id == Session::get('user.c_id') ) {
                $reply->r_type  = 'complainant';
            }
            elseif ( Session::get('user.m_id') > 0 ) {
                $reply->r_type  = 'manager';
            }
            else {
                return Response::json(array('status' => '403 Forbidden'));
            }

            $reply->r_u_id      = Session::get('user.u_id');
            $reply->case_id     = Input::get('case_id');
            $reply->r_content   = Input::get('content');
            $reply->save();

            $response['status'] = '402 OK';

            return Response::json($response);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    private function destroy($id)
    {
        $reply = Reply::find($id);
        $reply->delete();
    }

}
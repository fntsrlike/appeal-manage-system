<?php

class API_ManagerController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $managers = Manager::all();

        foreach ($managers as $manager) {

            $user = IltUser::find($manager->u_id);

            $m = array();
            $m['username']  = $user->username;
            $m['name']      = $manager->m_name;
            $m['title']     = $manager->m_title;
            $m['status']    = $manager->m_status;

            if ( Session::has('user.login') and (Session::get('user.is_sa') == true) ) {
                $m['m_id']     = $manager->m_id;
            }

            $list[] = $m;
        }

        $response['managers'] = $list;
        $response['status'] = '200 OK';
        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules      = Config::get('validation.manager.store.rules');
        $messages   = Config::get('validation.manager.store.massages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $response['status'] = '400 Bad Request';
            $response['msg'] = $messages;

            return Response::json($response);
        }
        else {
            $user        = IltUser::where('username', '=', Input::get('username'))->first();
            $complainant = Complainant::where('u_id', '=', $user->u_id)->first();
            $manager     = new Manager;

            $manager->u_id    = $user->u_id;
            $manager->m_name  = $complainant->name;
            $manager->m_title = Input::get('title');
            $manager->m_email = $complainant->email;
            $manager->save();

            $response['status'] = '200 OK';
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
        if (! ( Session::has('user.login') and (Session::get('user.is_sa') == true) )) {
            $response['status'] = '403 Forbidden';
            return Response::json($response);
        }

        $manager = Manager::find($id);

        if ( null == $manager ) {
            $response['status'] = '404 Not Found';
            return Response::json($response);
        }

        $user = IltUser::find($manager->u_id);

        $m = array();
        $m['username']  = $user->username;
        $m['name']      = $manager->m_name;
        $m['title']     = $manager->m_title;
        $m['status']    = $manager->m_status;

        $response['manager'] = $m;
        $response['status'] = '200 OK';
        return Response::json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {


        $rules      = Config::get('validation.manager.update.type.rules');
        $messages   = Config::get('validation.manager.update.type.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $response['status'] = '400 Bad Request';
            $response['msg'] = $messages;

            return Response::json($response);
        }


        $type = Input::get('type');
        $rules      = Config::get('validation.manager.update.' . $type . '.rules');
        $messages   = Config::get('validation.manager.update.' . $type . '.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $response['status'] = '400 Bad Request';
            $response['msg'] = $messages;

            return Response::json($response);
        }

        $manager = Manager::find($id);

        if ( $type == 'files' ) {
            $manager->m_title = Input::get('title');
            $manager->save();
        }
        else if ( $type == 'status' ) {
            $status = Input::get('status');
            $hash   = array('recover' => 1, 'stop' => 2);

            if ( $manager->m_status == $hash[$status] ) {
                $response['status'] = '400 Bad Request';
                $response['msg'] = '無法對已經是某狀態的管理員再次設定某狀態';

                return Response::json($response);
            }

            $manager->m_status = $hash[$status];
            $manager->save();

            $username   = IltUser::find($manager->u_id)->username;
            $operator   = Session::get('user.username');
            $reason     = Input::get('reason');

            $msg = "{$username} 因為理由「{$reason}」，所以被 {$operator} ";
            $msg .= ( $status == 'stop' ) ? "凍結管理者的權限。" : "恢復管理者的權限";

            $action = new Action;
            $action->type   = ($status == 1) ? 'RECOVERY_MANAGER_PERM' : 'STOP_MANAGER_PERM';
            $action->event  = $msg;
            $action->operator_u_id = Session::get('user.u_id');
            $action->save();
        }

        $response['status'] = '200 OK';
        return Response::json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if ( Session::has('user.login') and (Session::get('user.is_sa') == true) ) {
            $m['id']     = $manager->m_id;
        }

        $rules      = Config::get('validation.manager.delete');
        $messages   = Config::get('validation.manager.delete');
        $validator  = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $response['status'] = '400 Bad Request';
            $response['msg'] = $messages;

            return Response::json($response);
        }

        $user   = IltUser::where('username', '=', Input::get('username'))->first();
        $manage = Manager::find($id);

        if ( $id != $user->u_id or $manage->m_name != Input::get('name') ) {
            $response['status'] = '400 Bad Request';
            $response['msg'] = array('您輸入的資料與要求的目標不符！');

            return Response::json($response);
        }
        else {
            $manager->delete();

            $response['status'] = '200 OK';
            return Response::json($response);
        }
    }

}
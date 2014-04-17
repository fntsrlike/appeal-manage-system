<?php

class API_ActionController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $is_sa = ( Session::has('user.login') and (Session::get('user.is_sa') == true) );
        $is_manager = ( Session::has('user.login') and (Session::get('user.m_id') > 0) );

        $allow_action   = array('RECOVERY_MANAGER_PERM','STOP_MANAGER_PERM');
        $sa_only_action = array();

        if ( !Input::has('args') ) {
            $response['status']  = '200 OK';
            $response['actions'] = array();
            return Response::json($response);
        }

        $actions = Input::get('args');
        $actions = explode(' ', $actions);



        foreach ($actions as $action) {
            if ( in_array($action, $allow_action) === false ) {
                if ( !( $is_sa and (in_array($action, $sa_only_action) === true) )) {
                    $response['status']  = '400 Bad Request';
                    $response['actions'] = array();
                    return Response::json($response);
                }
            }

        }

        $actions_orm = Action::whereIn('type', $actions)->get();
        $list        = array();

        foreach ($actions_orm as $action) {
            $a = array();
            $a['type']      = $action->type;
            $a['reason']    = $action->event;
            $a['datetime']  = $action->created_at;

            if ($is_sa || $is_manager) {
                $user = IltUser::find($action->operator_u_id);
                $a['operator'] = $user->username;
            }

            $list[] = $a;
        }

        $response['status']  = '200-OK';
        $response['actions'] = $list;
        return Response::json($response);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
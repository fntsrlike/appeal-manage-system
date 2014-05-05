<?php

class PortalController extends BaseController {

    public function status() {

        if ( ! Session::has('user.login') ) {
            return Response::json( array('status' => false) );
        }

        $status = array(
            'status'    => Session::get('user.login'),
            'username'  => Session::get('user.username'),
            'u_id'      => Session::get('user.u_id'),
            'c_id'      => Session::get('user.c_id'),
            'm_id'      => Session::get('user.m_id'),
            'is_sa'     => Session::get('user.is_sa'),
        );

        return Response::json($status);
    }

    public function login(){

        $key        = Config::get('ilt_provider.key');
        $secret     = Config::get('ilt_provider.secret');
        $host_url   = Config::get('ilt_provider.host_url');
        $scope      = Config::get('ilt_provider.scope');

        $ilt_client = new IltOAuthClient($key, $secret, $host_url, $scope);
        $user_files = $ilt_client->run();

        if ( $user_files === false ||  $user_files === null) {
            $data['status'] = 'Did not get Ilt files';
            return View::make('portal.login_failed')->with($data);
        }

        $user = $user_files->data;
        $username = $user->info->username;

        $ilt_user = IltUser::where('username', '=', $username)->first();

        if ( $ilt_user == false || $ilt_user == null ) {
            Session::put('user.files', $user);
            return Redirect::action('PortalController@register');
        }

        $complainant = Complainant::where('u_id', '=', $ilt_user->u_id)->first();
        $manager = Manager::where('u_id', '=', $ilt_user->u_id)->first();

        $u_id = $ilt_user->u_id;
        $c_id = $complainant->c_id;
        $m_id = ( $manager == null || $manager->m_status == 2 ) ? 0 : $manager->m_id;
        $is_sa = in_array($username, Config::get('appeal.admin'));

        Session::put('user.login', true);
        Session::put('user.username', $username);
        Session::put('user.u_id', $u_id);
        Session::put('user.c_id', $c_id);

        // 這兩個選項在做涉及管理權的動作時，都必須重讀
        Session::put('user.m_id', $m_id);
        Session::put('user.is_sa', $is_sa);

        return Redirect::action('AppealController@index');
    }

    public function register() {

        if ( ! Session::has('user.files') ) {
            return Redirect::action('AppealController@index');
        }

        $user = Session::get('user.files');

        if ( $user->login->student === false ) {
            $data['status'] = '請先去伊爾特系統認證學生身份';
            return View::make('portal.login_failed')->with($data);
        }

        $data['username']   = $user->info->username;
        $data['number']     = $user->student->number;
        $data['department'] = $user->student->department;
        $data['grade']      = $user->student->grade;
        $data['name']       = $user->info->last_name . $user->info->first_name;
        $data['phone']      = $user->info->phone;
        $data['email']      = $user->info->email;

        $rules = Config::get('validation.register.rules');
        $messages = Config::get('validation.register.messages');

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails() )
        {
            $data['validation'] = false;
            return View::make('portal.register')->with($data)->withErrors($validator);
        }
        else {
            $data['validation'] = true;
            Session::put('register.checked', true);
            return View::make('portal.register')->with($data);
        }

    }

    public function register_proccess() {

        if ( ! Session::has('register.checked') ) {
            return Redirect::action('AppealController@index');
        }

        $user = Session::get('user.files');

        $ilt_user = new IltUser;
        $ilt_user->username = $user->info->username;
        $ilt_user->save();

        $u_id = $ilt_user->u_id;

        $complainant = new Complainant;
        $complainant->u_id      = $u_id;
        $complainant->c_name    = $user->info->last_name . $user->info->first_name;
        $complainant->c_number  = $user->student->number;
        $complainant->c_department = $user->student->department;
        $complainant->c_grade   = $user->student->grade;
        $complainant->c_phone   = $user->info->phone;
        $complainant->c_email   = $user->info->email;
        $complainant->save();

        $c_id = $complainant->c_id;

        Session::forget('register.checked');
        Session::forget('user.files');

        return Redirect::action('PortalController@login');
    }

    public function logout() {
        Session::forget('user');
        return Redirect::action('AppealController@index');
    }

}
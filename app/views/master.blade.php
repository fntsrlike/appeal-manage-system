<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>APPEAL_SYSTEM</title>

@section('head_css')
    <link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
@show
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">學權申訴系統</h1>
      <div class="div-center wd-600 bg-white-2 block bottom-sp-5">
        <ul class="nav nav-pills nav-justified" id="myTab">
          <li class="active"><a href="#appeal-list" data-toggle="pill">申訴清單</a></li>
          <li><a href="#appeal-view" data-toggle="pill">內文檢視</a></li>
          <li><a href="#appeal-form" data-toggle="pill">我要申訴</a></li>
          <li><a href="#appeal-manager" data-toggle="pill">學權團隊</a></li>
          <li class="login_hidden"><a href="{{action('PortalController@login')}}">使用者登入</a></li>
          <li class="login_show"><a href="{{action('PortalController@logout')}}">登出</a></li>
        </ul>
      </div>
      <div id="content" class="tab-content">
        @yield('content')
      </div> <!-- #content -->
    </div> <!-- .container -->

    <div class="row">
      <p class="text-center">
        Created by {{Config::get('site.copyright.creator')}},
        Maintaining by {{Config::get('site.copyright.maintainer')}} <br/>
        Copyright © 2014 {{Config::get('site.copyright.copyright')}}.
        All Rights Reserved <br/>
      </p>
    </div>

@section('footer_scripts')
    <script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="{{asset('js/appeal_case.js')}}"></script>
    <script src="{{asset('js/hash_tab.js')}}"></script>
    <script src="http://more.handlino.com/javascripts/moretext-1.2.js"></script>
@show
    {{ file_get_contents( 'http://fntsr.childish.tw/FntsrNav/' )}}
  </body>
</html>
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
          <li><a href="#appeal-track" data-toggle="pill">追蹤管理</a></li>
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
    <script type="text/javascript">
      appeal = {};
      appeal.config = {};
      appeal.config.base_url = "{{'http://localhost/fntsr/nchusg/app/app_appeal_laravel/public/'}}";
    </script>
    <script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    {{--
    <script src="{{asset('js/get_view.js')}}"></script>
    <script src="{{asset('js/get_list.js')}}"></script>
    <script src="{{asset('js/get_reply.js')}}"></script>
    <script src="{{asset('js/post_test.js')}}"></script>
    --}}
    <script src="http://res.nchusg.org/nav/load.js"></script>
    <script src="{{asset('js/form.js')}}"></script>
    <script src="{{asset('js/hash_tab.js')}}"></script>
    <script src="http://more.handlino.com/javascripts/moretext-1.2.js"></script>

@show
  </body>
</html>
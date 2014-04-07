<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>APPEAL_SYSTEM</title>

@section('head_css')
    <link rel="stylesheet" href="http://cdn.bootcss.com/twitter-bootstrap/3.0.3/css/bootstrap.min.css">
    <style type="text/css">
      .bg-white {
          background-color: rgba(255,255,255, 0.5);
      }

      .bg-white-2 {
          background-color: rgba(247, 247, 247, 0.99);
      }

      .bg-white-3 {
          background-color: rgba(255,255,255, 0.9);
      }

      .bg-blue {
          background-color: rgba(166, 191, 243, 0.5)
      }

      .bg-red {
          background-color: red;
      }

      .bg-appeal-reply {
          background-color: rgba(124, 209, 192, 0.2);
      }

      .bg-null {
          background-color: rgba(0, 0, 0, 0)
      }

      .bottom-sp-5 {
          margin-bottom: 5px;
      }

      .bottom-sp-15 {
          margin-bottom: 30px;
      }

      .bottom-sp-30 {
          margin-bottom: 30px;
      }

      .bottom-sp-null {
          margin-bottom: 0;
      }

      .block {
          padding: 15px;
          border: 1px solid transparent;
          border-radius: 4px;
      }

      .wd-100 {
          width: 100px;
      }

      .wd-150 {
          width: 150px;
      }

      .wd-600 {
          width: 600px;
      }

      .wd-800 {
          width: 800px;
      }

      .wd-min-500 {
          width: 500px;
      }

      .div-center {
          margin-left: auto;
          margin-right: auto;
      }
    </style>
@show
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">學權申訴系統</h1>
      <div class="div-center wd-600 bg-white-2 block bottom-sp-5">
        <ul class="nav nav-pills nav-justified" id="myTab">
          <li class="active"><a href="#appeal-list" data-toggle="pill">申訴清單</a></li>
          <li><a href="#appeal-form" data-toggle="pill">我要申訴</a></li>
          <li><a href="#appeal-view" data-toggle="pill">內文檢視</a></li>
          <li><a href="#appeal-track" data-toggle="pill">追蹤管理</a></li>
        </ul>
      </div>
      <div id="content" class="tab-content">

        @yield('content')
      </div> <!-- #content -->
    </div> <!-- .container -->

    <div class="row">
      <p class="text-center">
        Created by {{Config:get(site.copyright.creator)}},
        Maintaining by {{Config:get(site.copyright.maintainer)}} <br/>
        Copyright © 2014 {{Config:get(site.copyright.copyright)}}.
        All Rights Reserved <br/>
      </p>
    </div>

@section('footer_scripts')
    <script type="text/javascript">
        appeal = {};
        appeal.config = {};
        appeal.config.base_url = "{{base_url}}";
    </script>
    <script src="http://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="{{asset('js/get_view.js')}}"></script>
    <script src="{{asset('js/get_list.js')}}"></script>
    <script src="{{asset('js/get_reply.js')}}"></script>
    <script src="{{asset('js/form.js')}}"></script>
    <script src="{{asset('js/post_test.js')}}"></script>
    <script src="http://more.handlino.com/javascripts/moretext-1.2.js"></script>
    </script>
@show
  </body>
</html>
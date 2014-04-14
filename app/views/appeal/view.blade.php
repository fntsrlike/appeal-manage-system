<div id="appeal-view" class="row tab-pane fade in " >
  <div class="panel panel-default wd-800 div-center">
    <div class="panel-heading">
      <h3 id="appeal-view-title" class="text-center">...</h3>
    </div>
    <div class="panel-body">
      <ul class="list-inline text-center">
        <li>
          <span class="glyphicon glyphicon-bullhorn"></span>
          &nbsp;
          <span id="appeal-view-target" >...</span>
        </li>
        <li>
          <span class="glyphicon glyphicon-globe"></span>
          &nbsp;
          <span id="appeal-view-place" >...</span>
        </li>
        <li>
          <span class="glyphicon glyphicon-time"></span>
          &nbsp;
          <span id="appeal-view-date" >...</span>
        </li>
        <li>
          <span class="glyphicon glyphicon-search"></span>
          &nbsp;
          <span id="appeal-view-status" >...</span>
        </li>
      </ul>
      <div id="appeal-view-content" >...</div>
      <hr/>
      <ul class="list-inline text-center">
        <li>
          <span class="glyphicon glyphicon-user"></span>
          &nbsp;
          <span id="appeal-view-pName" >...</span>
        </li>
        <li>
          <span class="glyphicon glyphicon-tower"></span>
          &nbsp;
          <span id="appeal-view-pDepart" >...</span>
        </li>
        <li>
          <span class="glyphicon glyphicon glyphicon-phone"></span>
          &nbsp;
          <span id="appeal-view-pPhone" >...</span>
        </li>
        <li>
          <span class="glyphicon glyphicon glyphicon-envelope"></span>
          &nbsp;
          <span id="appeal-view-pEmail" >...</span>
        </li>
      </ul>
    </div>
  </div>

  <div class="div-center wd-800 block bg-blue bottom-sp-15">
    <h3 class="text-center">結案報告</h3>
    <div id="appeal-view-report">...</div>
  </div>
  <!-- <div class="alert alert-warning wd-800 div-center text-center ">處理中</div>
<div class="alert alert-danger wd-800 div-center text-center ">尚未處理</div>
-->
<div class="div-center block bg-appeal-reply wd-800 bottom-sp-30">

  <div style="padding:0 15px;">
    <h3 class="text-center">討論</h3>
    <div id="appeal-view-dialog">
      <div class="row bottom-sp-15">
        <div class="block pull-left bg-white wd-min-500">
          <h4>
            ...
            <small>...</small>
          </h4>
          ...
        </div>
      </div>
      <div class="row bottom-sp-15">
        <div class="block pull-right bg-white wd-min-500">
          <h4>
            ...
            <small>...</small>
          </h4>
          ...
        </div>
      </div>
    </div>
  </div>

  <div class="login_show" style="padding:0 15px;">
    <hr />
    <div>
      <form id="reply_form" role="form" method="post" action="{{action('API_ReplyController@store')}}">
        <div class="form-group">
          <textarea class="form-control" name="content" rows="4"></textarea>
        </div>
        <div class="form-group text-right">
          <input id="appeal-view-id" type="hidden" name="case_id" value="" />
          <span id="reply_form_error_msg"></span>
          <button type="submit" class="btn btn-default">留言</button>
        </div>
      </form>
    </div>

  </div>
</div>
</div>
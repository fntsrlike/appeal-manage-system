<div id="appeal-view" class="row tab-pane fade in " >
  <div class="alert alert-warning wd-800 div-center text-center hidden">
    您尚未選擇任一篇學權申訴，請選擇後再回來瀏覽。
  </div>
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
    <div class="text-right">
      <a class="btn btn-primary manager_show" data-toggle="modal" data-target="#AppealEndingModal">管理案件＆編寫結案報告</a>
    </div>
  </div>

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

<!-- Modal -->
<div class="modal fade manager_show" id="AppealEndingModal" tabindex="-1" role="dialog" aria-labelledby="AppealEndingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="AppealEndingModalLabel">管理案件 與 編寫結案報告</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="col-sm-12">
              <p class="text-danger">
                <em>
                  如果純粹只是要更改案件狀態，沒有要編寫結案報告，結案報告那欄留白即可。結案報告並不會記錄結案者的資料，請結案報告者自行署名。本功能並無自動儲存草稿的功能，建議使用其他編輯軟體邊寫完後，再到這裡貼上。
                </em>
              </p>
            </div>
          </div>
          <div class="form-group">
           <label for="AppealEndingModal_username" class="col-sm-3 control-label">案件狀態</label>
           <div class="col-sm-9">
            <select class="form-control" name="case_status">
              <option value="todo">未處理</option>
              <option value="doing">處理中</option>
              <option value="done">已結案</option>
            </select>
           </div>
          </div>
          <div class="form-group">
           <label for="AppealEndingModal_name" class="col-sm-3 control-label">開放留言狀態</label>
           <div class="col-sm-9">
            <select class="form-control" name="reply_status">
              <option value="on">開放留言。本案尚需持續追蹤。</option>
              <option value="off">停止留言。結案已久或明確結束，停止追蹤。</option>
            </select>
           </div>
          </div>
          <div class="form-group">
           <label for="AppealEndingModal_reason" class="col-sm-3 control-label">結案報告</label>
           <div class="col-sm-9">
             <textarea class="form-control" rows="3" name="report"></textarea>
           </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10" id="AppealEndingModal_msg">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="AppealEndingModal_id" />
          <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
          <button type="submit" class="btn btn-primary">送出</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
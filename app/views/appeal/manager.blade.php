<div id="appeal-manager" class="row tab-pane fade">
  <div class="div-center alert bg-white-2 bk-track">
    <h4>現職管理者清單</h4>
    <table id="being_manager_list" class="table">
      <thead>
        <tr>
          <td style="width: 185px;">ID</td>
          <td style="width: 75px;">名稱</td>
          <td style="min-width: 222px;">頭銜</td>
          <td class="sa_show hidden" style="width: 85px;">操作</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div class="div-center alert bg-white-2 bk-track">
    <h4>歷任管理者清單</h4>
    <table id="was_manager_list" class="table">
      <thead>
        <tr>
          <td style="width: 185px;">ID</td>
          <td style="width: 75px;">名稱</td>
          <td style="min-width: 222px;">頭銜</td>
          <td class="sa_show hidden" style="width: 85px;">操作</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div class="div-center alert bg-white-2 bk-track">
    <h4>停復權歷史記錄</h4>
    <table id="manager_action_list" class="table">
      <thead>
        <tr>
          <td style="width: 96px;">日期</td>
          <td style="width: 47px;">動作</td>
          <td>理由</td>
          <td class="manager_show hidden">Operator</td>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>

  <div class="div-center alert bg-red-2 bk-track sa_show hidden">
    <h4>新增管理者</h4>
    <div>
      <form class="form-inline" role="form">
        <div class="form-group">
          <label class="sr-only" for="InputUsername">Username</label>
          <input type="text" class="form-control" id="InputUsername" placeholder="輸入使用者名稱">
        </div>
        <div class="form-group">
          <label class="sr-only" for="InputTitle">Title</label>
          <input type="text" class="form-control" id="InputTitle" placeholder="輸入頭銜">
        </div>
        <button type="submit" class="btn btn-default">新增</button>
      </form>
    </div>
    <div class="text-danger" style="margin-top: 10px;">
      <ul>
        <li>錯誤訊息</li>
        <li>錯誤訊息</li>
      </ul>
    </div>
  </div>

  <div class="div-center alert bg-red-2 bk-track sa_show hidden">
    <h4>刪除管理者</h4>
    <div>
      <p>
        <em>
        因為刪除管理者可能造成一些學權申訴回覆者和處理者的資料失去聯繫，若非誤加且該管理者尚未處理事情，請謹慎思考再刪除，儘量用停權代替刪除身份。為避免誤刪，刪除方式採取雙驗證，亦即必須輸入正確的兩欄資料才可以刪除。
        </em>
      </p>
      <form class="form-inline" role="form">
        <div class="form-group">
          <label class="sr-only" for="InputUsername">Username（ID）</label>
          <input type="text" class="form-control" id="InputUsername" placeholder="輸入使用者名稱">
        </div>
        <div class="form-group">
          <label class="sr-only" for="InputTitle">名稱</label>
          <input type="text" class="form-control" id="InputTitle" placeholder="輸入管理者名稱">
        </div>
        <button type="submit" class="btn btn-default">刪除</button>
      </form>
    </div>
    <div class="text-danger" style="margin-top: 10px;">
      <ul>
        <li>錯誤訊息</li>
        <li>錯誤訊息</li>
      </ul>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="EditModalLabel">編輯</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">名稱</label>
            <div class="col-sm-10">
              <p id="EditModal_name" class="form-control-static">歐庭愷（Otk）</p>
            </div>
          </div>
          <div class="form-group">
            <label for="EditModal_title" class="col-sm-2 control-label">頭銜</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="title" id="EditModal_title" placeholder="輸入該管理者的頭銜">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10" id="EditModal_msg">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="EditModal_id" />
          <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
          <button type="submit" class="btn btn-primary">儲存</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="StopPermissionModal" tabindex="-1" role="dialog" aria-labelledby="StopPermissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="StopPermissionModalLabel">凍結權限</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">名稱</label>
            <div class="col-sm-10">
              <p id="StopPermissionModal_name" class="form-control-static">...</p>
            </div>
          </div>
          <div class="form-group">
            <label for="StopPermissionModal_reason" class="col-sm-2 control-label">理由</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="reason" id="StopPermissionModal_reason" placeholder="輸入凍結權限的理由">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10" id="StopPermissionModal_msg">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="StopPermissionModal_id" />
          <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
          <button type="submit" class="btn btn-primary">確定凍權</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div class="modal fade" id="RecoverPermissionModal" tabindex="-1" role="dialog" aria-labelledby="RecoverPermissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="RecoverPermissionModalLabel">恢復權限</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">名稱</label>
            <div class="col-sm-10">
              <p id="RecoverPermissionModal_name" class="form-control-static">...</p>
            </div>
          </div>
          <div class="form-group">
           <label for="RecoverPermissionModal_reason" class="col-sm-2 control-label">理由</label>
           <div class="col-sm-10">
             <input type="text" class="form-control" name="reason" id="RecoverPermissionModal_reason" placeholder="輸入恢復權限的理由">
           </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10" id="RecoverPermissionModal_msg">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="RecoverPermissionModal_id" />
          <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
          <button type="submit" class="btn btn-primary">確定復權</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
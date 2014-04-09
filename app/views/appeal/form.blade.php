<div id="appeal-form" class="row tab-pane fade in">
  <div class="div-center wd-600">
    <form id="appeal_form" class="form-horizontal" role="form" method="post" action="">
      <div class="alert bg-white">
        <h4 class="text-center">申訴資料</h4>
        <div class="form-group">
          <label for="input_e_title" class="col-sm-3 control-label">標題</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="e_title" id="input_e_title" placeholder="讓我們快速了解您的訴求"></div>
        </div>
        <div class="form-group">
          <label for="input_e_target" class="col-sm-3 control-label">申訴對象</label>
          <div class="col-sm-7">
            <input type="target" class="form-control" name="e_target" id="input_e_target" placeholder="讓您感到不滿的對象是誰"></div>
        </div>
        <div class="form-group">
          <label for="input_e_place" class="col-sm-3 control-label">事發地點</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="e_place" id="input_e_place" placeholder="關於此申訴的發生地點"></div>
        </div>
        <div class="form-group">
          <label for="input_e_date" class="col-sm-3 control-label">事發日期</label>
          <div class="col-sm-7">
            <input type="date" class="form-control" name="e_date" id="input_e_date" placeholder="關於此申訴的發生時間"></div>
        </div>
      </div>
      <div class="alert bg-white">
        <h4 class="text-center">申訴內容</h4>
        <textarea id="input_e_content" class="form-control" rows="8" name="e_content" placeholder="將您所申訴的敘述填寫在這。若有圖片請用網址附上。"></textarea>
      </div>
      <div class="form-group text-center">
        <button type="submit" class="btn btn-default">送出</button>
      </div>

    </form>
  </div>
</div>
<div id="appeal-success" class="row tab-pane fade">
  <div class="div-center wd-600 alert bg-white">
    <h3>成功了～～</h3>
  </div>
</div>
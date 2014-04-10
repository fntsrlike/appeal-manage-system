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
      <div class="alert bg-white">
        <div class="row">
          <div class="col-md-12">
            <h4 class="text-center">隱私設定</h4>
            <em>
              <p>
                以下設定僅針對一般訪客與使用者。為了有效率的處理案件，管理員是看得到您的個人資料，以方便與您聯絡的。
              </p>
              <p>
                為了避免您的個資外洩，在申訴者資訊上，若您願意讓大家知道該申訴是您提的，我們也用「使用者名稱」替代「姓名」作為「名稱」的主要辨識，減少真實資料在網路上的使用。
              </p>
            </em>
          </div>
        </div>
        <div class="row">

          <div class="col-md-8">
            <h5>案件資料</h5>
            <div class="radio">
              <label>
                <input type="radio" name="case" value="public" checked>
                公開案件內容、結案報告與留言
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="case" value="protect">
                僅公開案件內容與結案報告
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="case" value="private">
                僅在清單上顯示案件日期、標題與處理狀態
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="case" value="secret">
                全部隱藏
              </label>
            </div>
          </div>
          <div class="col-md-4">
            <h5>申訴者資訊</h5>
            <div class="radio">
              <label>
                <input type="radio" name="complainant" value="public" checked>
                公開名稱與系級
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="complainant" value="protect-dep">
                隱藏系級，僅公開名稱
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="complainant" value="protect-name">
                隱藏名稱，僅公開系級
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="complainant" value="private">
                全部隱藏
              </label>
            </div>
          </div>
        </div>
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
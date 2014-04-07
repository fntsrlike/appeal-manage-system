<div id="appeal-form" class="row tab-pane fade in">
  <div class="div-center wd-600">
    <form id="appeal_form" class="form-horizontal" role="form" method="post" action="">
      <div class="alert bg-white">
        <h4 class="text-center">申訴人</h4>
        <div class="form-group">
          <label for="input_p_name" class="col-sm-3 control-label">姓名</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="p_name" id="input_p_name" placeholder="中英文字"></div>
        </div>
        <div class="form-group">
          <label for="input_p_number" class="col-sm-3 control-label">學號</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="p_number" id="input_p_number" placeholder="數字10碼"></div>
        </div>
        <div class="form-group">
          <label for="input_p_depart" class="col-sm-3 control-label">科系</label>
          <div class="col-sm-7">
            <select class="form-control" class="form-control" name="p_depart" id="input_p_depart">
              <option value="C10">C10 文學院</option>
              <option value="C20">C20 管理學院</option>
              <option value="C30">C30 農業暨自然資源學院</option>
              <option value="U11">U11 中國文學系學士班</option>
              <option value="U12">U12 外國語文學系學士班</option>
              <option value="U13">U13 歷史學系學士班</option>
              <option value="U21">U21 財務金融學系學士班</option>
              <option value="U23">U23 企業管理學系學士班</option>
              <option value="U24">U24 法律學系學士班</option>
              <option value="U28">U28 會計學系學士班</option>
              <option value="U29">U29 資訊管理學系學士班</option>
              <option value="U30G">U30G 生物科技學程學士學位學程</option>
              <option value="U30F">U30F 景觀與遊憩學程學士學位學程</option>
              <option value="U30H">U30H 國際農企業學士學位學程</option>
              <option value="U31">U31 農藝學系學士班</option>
              <option value="U32">U32 園藝學系學士班</option>
              <option value="U33A">U33A 森林學系林學組學士班</option>
              <option value="U33B">U33B 森林學系木材科學組學士班</option>
              <option value="U34">U34 應用經濟學系學士班</option>
              <option value="U35">U35 植物病理學系學士班</option>
              <option value="U36">U36 昆蟲學系學士班</option>
              <option value="U37">U37 動物科學系學士班</option>
              <option value="U38B">U38B 獸醫學系學士班</option>
              <option value="U38A">U38A 獸醫學系學士班</option>
              <option value="U39">U39 土壤環境科學系學士班</option>
              <option value="U40">U40 生物產業機電工程學系學士班</option>
              <option value="U42">U42 水土保持學系學士班</option>
              <option value="U43">U43 食品暨應用生物科技學系學士班</option>
              <option value="U44">U44 行銷學系學士班</option>
              <option value="U51">U51 化學系學士班</option>
              <option value="U52">U52 生命科學系學士班</option>
              <option value="U53A">U53A 應用數學系學士班</option>
              <option value="U53B">U53B 應用數學系學士班</option>
              <option value="U54B">U54B 物理學系光電物理組學士班</option>
              <option value="U54A">U54A 物理學系一般物理組學士班</option>
              <option value="U56">U56 資訊科學與工程學系學士班</option>
              <option value="U60F">U60F 學士後太陽能光電系統應用學程學士學位學程</option>
              <option value="U61B">U61B 機械工程學系學士班</option>
              <option value="U61A">U61A 機械工程學系學士班</option>
              <option value="U62A">U62A 土木工程學系學士班</option>
              <option value="U62B">U62B 土木工程學系學士班</option>
              <option value="U63">U63 環境工程學系學士班</option>
              <option value="U64A">U64A 電機工程學系學士班</option>
              <option value="U64B">U64B 電機工程學系學士班</option>
              <option value="U65">U65 化學工程學系學士班</option>
              <option value="U66">U66 材料科學與工程學系學士班</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="input_p_gyear" class="col-sm-3 control-label">年級/畢業級數</label>
          <div class="col-sm-7">
            <select class="form-control" class="form-control" name="p_gyear" id="input_p_gyear">
              <option value="1">一年級</option>
              <option value="2">二年級</option>
              <option value="3">三年級</option>
              <option value="4">四年級</option>
              <option value="5">＞四年級</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="input_p_phone" class="col-sm-3 control-label">電話</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" name="p_phone" id="input_p_phone" placeholder="純數字，手機為佳。市話須加區碼"></div>
        </div>
        <div class="form-group">
          <label for="input_p_email" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-7">
            <input type="email" class="form-control" name="p_email" id="input_p_email" placeholder="若有更新我們會寄信給您"></div>
        </div>
      </div>
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
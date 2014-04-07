$(function() {
    appeal_view = {};

    appeal_view.run = function() {
        console.log('Appeal_view.run()');
        appeal_view.click_listener();
    };

    appeal_view.click_listener = function() {
        $('[href="#appeal-view"]').click(function () {
            var id = $(this).attr('view-id');
            appeal_view.get_view(id);
            $('#myTab a[href="#appeal-view"]').tab('show');

            console.log('click_listener: get id = '+id);
        });

        console.log('click_listener is loaded ');
    };

    appeal_view.get_view = function(id) {

        var url  = appeal.config.base_url + "api/get_view/";
        var data = { "id" : id };
        var cId  = '';

        $.post(
            url,
            data,
            function(data) {
                console.log(data);
                console.log(data.status);

                if (data.status == true) {
                  // Code..
                  console.log("appeal_view.get_view() get status = true");
                  console.log(data.files);
                  appeal_view.load_view(data.files);
                }
                else if (data.status == false) {
                  // Code..
                  console.log("appeal_view.get_view() get status = false");
                }
                else {
                  // Code..
                  console.log("appeal_view.get_view() get status = failed");
                }
            },
            "json"
        )
        .done(function() {
            // Code..
            console.log("appeal_view.get_view() Done.");
        })
        .fail(function() {
            // Code..
            console.log("appeal_view.get_view() Connect Failed");
        });
    };

    appeal_view.load_view = function (data) {

        data.form.fReport = (data.form.fReport==null||data.form.fReport=='') ? '<p class="text-info text-center">尚未結案</p>' : data.form.fReport;

        $('#appeal-view-title').html(data.form.fTitle);
        $('#appeal-view-target').html(data.form.fTarget);
        $('#appeal-view-place').html(data.form.fPlace);
        $('#appeal-view-date').html(data.form.fDate);
        $('#appeal-view-status').html(appeal_view.get_status(data.form.fStatus));

        $('#appeal-view-content').html(data.form.fContent);
        $('#appeal-view-report').html(data.form.fReport);

        $('#appeal-view-pName').html(data.cmplnnt.cName + ' (' + data.cmplnnt.cNumber + ')');
        $('#appeal-view-pDepart').html(appeal_view.get_depart(data.cmplnnt.cDepart) + ' (' + data.cmplnnt.cGraduteY + ')');
        $('#appeal-view-pPhone').html(data.cmplnnt.cPhone);
        $('#appeal-view-pEmail').html(data.cmplnnt.cEmail);

        appeal_reply.get_reply(data.form.fId);
    };

    appeal_view.get_status = function (code) {
        var status = {
            '1' : '未處理',
            '2' : '處理中',
            '3' : '已經處理'
        }
        return status[code];
    };

    appeal_view.get_grade = function (code) {

    };

    appeal_view.get_depart = function (code) {

        code = code.toUpperCase();

        var depart = {
               "C20"  : '管理學院',
               "C30"  : '農業暨自然資源學院',
               "U11"  : '中國文學系學士班',
               "U12"  : '外國語文學系學士班',
               "U13"  : '歷史學系學士班',
               "U21"  : '財務金融學系學士班',
               "U23"  : '企業管理學系學士班',
               "U24"  : '法律學系學士班',
               "U28"  : '會計學系學士班',
               "U29"  : '資訊管理學系學士班',
               "U30G" : '生物科技學程學士學位學程',
               "U30F" : '景觀與遊憩學程學士學位學程',
               "U30H" : '國際農企業學士學位學程',
               "U31"  : '農藝學系學士班',
               "U32"  : '園藝學系學士班',
               "U33A" : '森林學系林學組學士班',
               "U33B" : '森林學系木材科學組學士班',
               "U34"  : '應用經濟學系學士班',
               "U35"  : '植物病理學系學士班',
               "U36"  : '昆蟲學系學士班',
               "U37"  : '動物科學系學士班',
               "U38B" : '獸醫學系學士班',
               "U38A" : '獸醫學系學士班',
               "U39"  : '土壤環境科學系學士班',
               "U40"  : '生物產業機電工程學系學士班',
               "U42"  : '水土保持學系學士班',
               "U43"  : '食品暨應用生物科技學系學士班',
               "U44"  : '行銷學系學士班',
               "U51"  : '化學系學士班',
               "U52"  : '生命科學系學士班',
               "U53A" : '應用數學系學士班',
               "U53B" : '應用數學系學士班',
               "U54B" : '物理學系光電物理組學士班',
               "U54A" : '物理學系一般物理組學士班',
               "U56"  : '資訊科學與工程學系學士班',
               "U60F" : '學士後太陽能光電系統應用學程學士學位學程',
               "U61B" : '機械工程學系學士班',
               "U61A" : '機械工程學系學士班',
               "U62A" : '土木工程學系學士班',
               "U62B" : '土木工程學系學士班',
               "U63"  : '環境工程學系學士班',
               "U64A" : '電機工程學系學士班',
               "U64B" : '電機工程學系學士班',
               "U65"  : '化學工程學系學士班',
               "U66"  : '材料科學與工程學系學士班'
        };

        return depart[code];

    };

        // for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }

        appeal_view.run();

    });

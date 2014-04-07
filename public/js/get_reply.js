$(function() {
    appeal_reply = {};

    appeal_reply.run = function() {

    };

    appeal_reply.get_reply = function(id) {

        var url  = appeal.config.base_url + "api/get_reply/";
        var data = { "id" : id };
        var cId  = '';

        $.post(
            url,
            data,
            function(data) {
                console.log(data);
                console.log(data.status);

                if (data.status === true) {
                  // Code..
                  console.log("appeal_reply.get_reply() get status = true");
                  console.log(data.files);
                  appeal_reply.load(data.files);

                }
                else if (data.status === false) {
                  // Code..
                  console.log("appeal_reply.get_reply() get status = false");
                  $('#appeal-view-dialog').html('<p class="text-info text-center">目前沒有對話</p>');
                }
                else {
                  // Code..
                  console.log("appeal_reply.get_reply() get status = failed");
                  $('#appeal-view-dialog').html('<p class="text-danger text-center">對話讀取錯誤</p>');
                }

            },
            "json"
        )
        .done(function() {
            // Code..
            console.log("appeal_reply.get_reply() Done.");
        })
        .fail(function() {
            // Code..
            console.log("appeal_reply.get_reply() Connect Failed");
        });

    };

    appeal_reply.load = function(data) {

      var dialog = '';
      for (var key in data) {
        dialog += appeal_reply.make_reply(data[key]);
      }

      $('#appeal-view-dialog').html(dialog);
    };

    appeal_reply.make_reply = function(data) {

        var left_right  = (data.rType==1) ? "pull-left" : "pull-right";
        var name        = (data.rType==1) ? "申訴人" : "學權部";
        var date        = data.createTime;
        var content     = data.rContent;
        var tmp         = '';

        tmp += '<div class="row bottom-sp-15">';
        tmp += '<div class="block bg-white wd-min-500 ' + left_right + '">';
        tmp += '<h4>' + name + ' <small>' + date + '</small></h4>';
        tmp += content;
        tmp += '</div></div>';

        return tmp;
    };

    appeal_reply.run();

});

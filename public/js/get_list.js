$(function() {
    appeal_list = {};

    appeal_list.run = function() {

        appeal_list.get_list(status);

        $("#appeal-status button").click(function( event ) {
            event.preventDefault();
            var status = $(this).attr('value');

            appeal_list.get_list(status);
        });
    };

    appeal_list.get_list = function(status) {

        var url  = appeal.config.base_url + "api/get_list";
        var data = { "status" : status };

        $.post(
            url,
            data,
            function(data) {

                if (data.status == true) {
                  // Code..
                  console.log("appeal_list.get_list() get status = true");
                  appeal_list.make_table(data.files);
                }
                else if (data.status == false) {
                  // Code..
                  console.log("appeal_list.get_list() get status = false");
                  $('#list_table tbody').html('');
                }
                else {
                  // Code..
                  console.log("appeal_list.get_list() get status = failed");
                }
            },
            "json"
        )
        .done(function() {
            // Code..
            console.log("appeal_list.get_list() Done.");
        })
        .fail(function() {
            // Code..
            console.log("appeal_list.get_list() Connect Failed");
        });
    };

    appeal_list.make_table = function(files) {
        var trs = '';
        for ( var arr in files) {

            var href = '<a href="#appeal-view" data-toggle="pill" view-id="' + files[arr].fId + '">';
            href += files[arr].fTitle + '</a>';

            var tmp = '<tr>';
            tmp += '<td class="text-center">' + files[arr].createTime.substring(0,10) + '</td>';
            tmp += '<td>' + href + '</td>';
            tmp += appeal_list.make_status(files[arr].fStatus, 0);
            tmp += '</tr>';

            trs += tmp;

        }
        $('#list_table tbody').html(trs);

        // reload listener
        appeal_view.run();
    };

    appeal_list.make_status = function(status, reply_no) {
        var msg = '';
        switch(status) {
            case '1':
                msg += '<td class="text-danger text-center">';
                msg += '未處理 <span class="label label-danger">' + reply_no + '</span></td>';
                break;
            case '2':
                msg += '<td class="text-warning text-center">';
                msg += '處理中 <span class="label label-warning">' + reply_no + '</span></td>';
                break;
            case '3':
                msg += '<td class="text-success text-center">';
                msg += '處理完畢 <span class="label label-success">' + reply_no + '</span></td>';
                break;
            default:
                msg += '<td class="text-muted text-center">';
                msg += '讀取錯誤 <span class="label label-default">??</span></td>';
                break;
        }

        return msg;
    }


    appeal_list.run();

});

$(function() {
    var appeal_form = {};

    appeal_form.run = function() {

        $("#appeal_form").submit(function( event ) {
            event.preventDefault();
            var test    = "test";
            var form    = $(this);
            var name    = form.find( "input[name='name']" ).val();
            var parent  = form.find( "input[name='parent']" ).val();
            var sort    = form.find( "input[name='sort']" ).val();
            var url     = form.attr( "action" );
            console.log("url: "+url);
            console.log(form);
            console.log(test);

            var data = {
                "p_name":   form.find( "input[name='p_name']" ).val(),
                "p_number": form.find( "input[name='p_number']" ).val(),
                "p_depart": form.find( "select[name='p_depart']" ).val(),
                "p_gyear":  form.find( "select[name='p_gyear']" ).val(),
                "p_phone":  form.find( "input[name='p_phone']" ).val(),
                "p_email":  form.find( "input[name='p_email']" ).val(),
                "e_title":  form.find( "input[name='e_title']" ).val(),
                "e_target": form.find( "input[name='e_target']" ).val(),
                "e_place":  form.find( "input[name='e_place']" ).val(),
                "e_date":   form.find( "input[name='e_date']" ).val(),
                "e_content":form.find( "textarea[name='e_content']" ).val()
              };

            $.post(
                url,
                data,
                function(data) {
                    if (data.status == "true") {
                        // Code..
                        console.log("true");
                        $('#appeal_form')[0].reset();
                        $('#appeal-form').removeClass('active');
                        $('#appeal-success').addClass('active in');

                    }
                    else if (data.status == "false") {
                      // Code..
                      console.log("false");
                      console.log(data.err_msg);
                    }
                    else {
                      // Code..
                      console.log("failed");
                    }
                },
                "json"
            )
            .done(function() {
            // Code..
            console.log("Done.");
            })
            .fail(function() {
            // Code..
            console.log("Connect Failed");
            });
        });


    };

    appeal_form.run();

});

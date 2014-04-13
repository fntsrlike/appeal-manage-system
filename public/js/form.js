$( function() {

  ns_appeal = {};

  ns_appeal.run = function() {

    $( "#appeal_form" ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.store( $( this ) );
    });

  };

  ns_appeal.store = function( form ) {
    var
    url = form.attr( "action" ),
    input = {
      "title"   : form.find( "input[name='title']" ).val(),
      "target"  : form.find( "input[name='target']" ).val(),
      "place"   : form.find( "input[name='place']" ).val(),
      "date"    : form.find( "input[name='date']" ).val(),
      "content" : form.find( "textarea[name='content']" ).val(),
      'privacy_case'        : form.find( "input[name='privacy_case']" ).val(),
      'privacy_complainant' : form.find( "input[name='privacy_complainant']" ).val(),
    };

    $.ajax({
      type: 'POST',
      url: url,
      data: input,
      success: function( data ) {
        var msg, msgs, hash;

        if ( data.status == 'success' ) {
          alert( '您的申訴已經成功送出！' );
          $( '#appeal_form' ).each( function() {
            this.reset();
          });

          hash = window.location.hash = '#appeal-view-' + data.case_id;
          hash && $( 'ul.nav a[href="' + hash + '"]' ).tab( 'show' );
        }
        else {
          msgs = '<ul>';

          for ( key in data.msg ) {
            msgs += '<li><span class="text-danger">' + data.msg[key] + '</span></li>';
          }

          msgs += '</ul>';

          $( '#form_error_msg' ).html( msgs );
        }
      },
      dataType: 'json'
    })
    .done(function() {
      console.log( "Done." );
    })
    .fail(function() {
      alert( '連線失敗，請檢查網路狀況，或是聯絡管理員！' );
    });
  };

  ns_appeal.update = function() {

  };

  ns_appeal.read = function() {

  };

  ns_appeal.show_list = function() {

  };



  ns_appeal.run();

});

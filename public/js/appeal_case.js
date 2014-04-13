$( function() {

  ns_appeal = {};

  ns_appeal.run = function() {
    $( '#appeal_form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.store( $( this ) );
    });

    $( '#appeal-status button' ).click(function( event ) {
      event.preventDefault();
      var status = $( this ).attr ('value' );
      ns_appeal.show_list( status );
    });

    ns_appeal.show_list(0);
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
    .fail(function() {
      alert( '連線失敗，請檢查網路狀況，或是聯絡管理員！' );
    });
  };

  ns_appeal.update = function() {

  };

  ns_appeal.show = function( case_id ) {
    var
    url  = $( '#show_list' ).attr( 'action' ) + '/' + case_id,
    grade = { '1' : '一年級', '2' : '二年級', '3' : '三年級', '4' : '四年級', '5' : '四年級Up' };

    $.get(url, function(data){
      console.log(data);

      if ( data.length === 0 ) {
        console.log('case unexist');
        return;
      }

      for ( var key in data) {
        if ( data[key] == '#private' ) {
          if ( key == 'title' ) {
            data[key] = '<span class="text-center text-muted">本案件標題已經被設定為隱藏</span>';
          } else if ( key == 'content' || key == 'report' ) {
            data[key] = '<p class="text-center text-info">本案件內容已經被設定為隱藏</p>';
          } else {
            data[key] = '<span class="text-muted">#private</span>';
          }
        }
      }

      $( '#appeal-view-title'  ).html( data.title );
      $( '#appeal-view-target' ).html( data.target );
      $( '#appeal-view-place'  ).html( data.place );
      $( '#appeal-view-date'   ).html( data.date );
      $( '#appeal-view-status' ).html( data.status );
      $( '#appeal-view-content'  ).html( data.content );
      $( '#appeal-view-pName'    ).html( data.name );
      $( '#appeal-view-pDepart'  ).html( data.depart + '（' + grade[data.grade] + '）' );
      $( '#appeal-view-pPhone' ).html( data.phone );
      $( '#appeal-view-pEmail' ).html( data.email );
      $( '#appeal-view-report' ).html( data.report );

    });
  };

  ns_appeal.show_list = function( status ) {
    var
    case_list = [],
    url  = $( '#show_list' ).attr( 'action' );

    $.get(url, function(data){
      if ( status != '0' ) {
        for ( var key in data ) {
          if ( data[key].status == status ) {
            case_list.push( data[key] );
          }
        }
      }
      else {
        case_list = data;
      }

      ns_appeal.make_list_rows( case_list );
    });
  };

  ns_appeal.make_list_rows = function( case_list ) {
    var href, tmp, key, trs = '';

    for ( key in case_list) {

      href = '<a href="#appeal-view-' + case_list[key].id + '">';
      href += case_list[key].title + '</a>';

      tmp = '<tr>';
      tmp += '<td class="text-center">' + case_list[key].created_at.date. substring(0,10) + '</td>';
      tmp += '<td>' + href + '</td>';
      tmp += ns_appeal.make_list_status(case_list[key].status, 0);
      tmp += '</tr>';

      trs += tmp;
    }
    $( '#list_table tbody' ).html( trs );
  };

  ns_appeal.make_list_status = function( status, reply_no ) {
    status = '' + status;
    var msg = '';
    switch( status ) {
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
  };

  ns_appeal.run();

});

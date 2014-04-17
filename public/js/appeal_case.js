$( function() {

  ns_appeal = {};
  ns_user   = {};

  ns_user.status = false;
  ns_user.name = '';
  ns_user.u_id = 0;
  ns_user.c_id = 0;
  ns_user.m_id = 0;
  ns_user.is_sa= null;

  ns_user.update = function( ) {
    var url  = $( '#api_user' ).attr( 'action' );

    $.get( url, function( data ){
      if ( data.status === true ) {
        ns_user.status = data.status;
        ns_user.name = data.username;
        ns_user.u_id = data.u_id;
        ns_user.c_id = data.c_id;
        ns_user.m_id = data.m_id;
        ns_user.is_sa = data.is_sa;
      }
      else {
        ns_user.status = false;
        ns_user.name = '';
        ns_user.u_id = 0;
        ns_user.c_id = 0;
        ns_user.m_id = 0;
        ns_user.is_sa= null;
      }
    })
    .done( function() {
      ns_user.update_view();
    });

  };

  ns_user.update_view = function() {
    if ( ns_user.status === true ) {
      $( '.login_show' ).removeClass('hidden');
      $( '.login_hidden' ).addClass('hidden');
    }
    else {
      $( '.login_show' ).addClass('hidden');
      $( '.login_hidden' ).removeClass('hidden');
    }

    if ( ( ns_user.m_id > 0 ) || ( ns_user.is_sa === true ) === true ) {
      $( '.manager_show').removeClass('hidden');
    } else {
      $( '.manager_show').addClass('hidden');
    }

    if ( ns_user.is_sa === true ) {
      $( '.sa_show' ).removeClass('hidden');
    } else {
      $( '.sa_show' ).addClass('hidden');
    }
  };

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

    $( '#reply_form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.store_reply( $( this ) );
    });

    ns_user.update();
    ns_appeal.show_list(0);
    ns_appeal.show_manager_list();
    ns_appeal.show_manager_actions();

  };

  ns_appeal.update = function() {
    ns_appeal.show_list(0);
    ns_user.update();
    ns_appeal.show_manager_list();
    ns_appeal.show_manager_actions();
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

  // ns_appeal.update = function() {

  // };

  ns_appeal.show = function( case_id ) {
    var
    url  = $( '#show_list' ).attr( 'action' ) + '/' + case_id,
    grade = { '1' : '一年級', '2' : '二年級', '3' : '三年級', '4' : '四年級', '5' : '四年級Up' };

    $.get(url, function(data){

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
      $( '#appeal-view-id' ).attr( 'value', case_id );

      ns_appeal.show_replies( case_id );

      if ( ns_user.name != data.name ) {
        $( '#reply_form textarea' ).attr('disabled', 'disabled');
        $( '#reply_form button' ).attr('disabled', 'disabled');
      }
      else {
        $( '#reply_form textarea' ).removeAttr('disabled');
        $( '#reply_form button' ).removeAttr('disabled');
      }

    });
  };

  ns_appeal.show_list = function( status ) {
    var
    case_list = [],
    url  = $( '#show_list' ).attr( 'action' );

    $.get( url, function( data ){
      if ( status != '0' ) {
        for ( var key in data ) {
          if ( ( status == '4' ) ) {
            if ( data[key].is_owner === true ) {
              case_list.push( data[key] );
            }
          } else if ( data[key].status == status ) {
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
      tmp += ns_appeal.make_list_status(case_list[key].status, case_list[key].replies_count);
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

  ns_appeal.store_reply = function( form ) {
    var
    url = form.attr( "action" ),
    input = {
      "content"   : form.find( "textarea[name='content']" ).val(),
      "case_id"  : form.find( "input[name='case_id']" ).val(),
    };

    $.ajax({
      type: 'POST',
      url: url,
      data: input,
      success: function( data ) {
        var msg, msgs, hash;

        if ( data.status == '402 OK' ) {
          alert( '您的留言已經成功送出！' );
          $( '#reply_form' ).each( function() {
            this.reset();
          });

          ns_appeal.show_replies( input.case_id );
        }
        else if ( data.status == '400 Bad Request' ) {
          msgs = '<ul>';
          for ( var key in data.msg ) {
            msgs += '<li><span class="text-danger">' + data.msg[key] + '</span></li>';
          }
          msgs += '</ul>';

          $( '#reply_form_error_msg' ).html( msgs );
        }
        else {
          alert( '您無權在本案件留言！' );
        }
      },
      dataType: 'json'
    })
    .fail(function() {
      alert( '連線失敗，請檢查網路狀況，或是聯絡管理員！' );
    });
  };

  ns_appeal.show_replies = function( case_id ) {
    var
    url  = $( '#replies_list' ).attr( 'action' ) + '?case_id=' + case_id;

    $.get(url, function(data){

      if ( ( data.length === 0 ) || ( data.status == '400 Bad Request' ) ) {
        $('#appeal-view-dialog').html('<p class="text-danger text-center">對話讀取錯誤</p>');
        return;
      }

      if ( data.status == '401 Unauthorized' ) {
        $('#appeal-view-dialog').html('<p class="text-info text-center">本申訴案留言已經設成隱藏。</p>');
        return;
      }

      if ( data.replies_count <= 0 ) {
        $('#appeal-view-dialog').html('<p class="text-info text-center">目前沒有對話</p>');
        return;
      };

      ns_appeal.make_replies( data.replies );

    });
  };

  ns_appeal.make_replies = function( replies ) {
    var
    reply,
    location,
    name,
    date,
    content,
    block,
    blocks = '';

    for ( var key in replies ) {
      reply = replies[key];

      location  = ( reply.type == 'complainant' ) ? "pull-left" : "pull-right";
      name      = ( reply.type == 'complainant' ) ? reply.complainant.name : reply.manager.title + reply.manager.name;
      date      = reply.datetime.date;
      content   = reply.content;
      block     = '';

      block += '<div class="row bottom-sp-15">';
      block += '<div class="block bg-white wd-min-500 ' + location + '">';
      block += '<h4>' + name + ' <small>' + date + '</small></h4>';
      block += content;
      block += '</div></div>';

      blocks += block;
    }


    $('#appeal-view-dialog').html(blocks);
  };

  ns_appeal.show_manager_list = function() {
    var
    url  = $( '#api_manager_list' ).attr( 'action' );

    $.get(url, function(data){
      var
      being_managers = [],
      was_managers   = [],
      manager;

      if ( data.length === 0 ) {
        return;
      }

      for ( var key in data.managers ) {
        manager = data.managers[key];

        if ( manager.status == 1 ) {
          being_managers.push(manager);
        }
        else if ( manager.status == 2 ) {
          was_managers.push(manager);
        }
      }


      ns_appeal.make_manager_list( 'being', being_managers );
      ns_appeal.make_manager_list( 'was', was_managers );
    });
  };

  ns_appeal.make_manager_list = function( type, list ) {
    var
    hash = type + '_manager_list' ,
    rows = '',
    row, manager;

    for ( var key in list ) {
      manager = list[key];

      row = '<tr>';
      row += '<td>' + manager.username + '</td>';
      row += '<td>' + manager.name     + '</td>';
      row += '<td>' + manager.title    + '</td>';

      if ( ns_user.is_sa === true ) {
        if ( type == 'being' ) {
          row += '<td>';
          row += '<a data-toggle="modal" data-target="#EditModal" for="' + manager.m_id + '"><span class="text-primary">編輯</span></a>';
          row += ' | ';
          row += '<a data-toggle="modal" data-target="#StopPermissionModal" for="' + manager.m_id + '"><span class="text-warning">停權</span></a>';
          row += '</td>';
        }
        else if ( type == 'was' ) {
          row += '<td><a data-toggle="modal" data-target="#RecoverPermissionModal" for="' + manager.m_id + '"><span class="text-warning">停權</span></a></td>';
        }
      }

      row += '</tr>';

      rows += row;
    }

    $( '#' + hash + ' tbody' ).html( row );
  };

  ns_appeal.show_manager_actions = function() {
    var
    url  = $( '#api_action_list' ).attr( 'action' );

    url += '?args=RECOVERY_MANAGER_PERM+STOP_MANAGER_PERM';

    $.get(url, function(data){

      if ( data.length === 0 || data.actions === 0 ) {
        return;
      }

      ns_appeal.make_manager_actions( data.actions );
    });
  };

  ns_appeal.make_manager_actions = function( list ) {
    var
    action,
    rows = '',
    row,
    type = {'RECOVERY_MANAGER_PERM' : '復權', 'STOP_MANAGER_PERM' : '停權'},
    perm = ( ns_user.m_id > 0 ) || ( ns_user.is_sa === true ) ;

    for ( var key in list ) {
      action = list[key];

      row = '<tr>';
      row += '<td>' + action.datetime.date.substring(0,10) + '</td>';
      row += '<td>' + type[action.type]     + '</td>';
      row += '<td>' + action.reason         + '</td>';

      if ( perm === true ) {
        row += '<td>' + action.operator + '</td>';
      }
      row += '</tr>';

      rows += row;
    }

    $( '#manager_action_list tbody' ).html(rows);

  };

  ns_appeal.run();

});

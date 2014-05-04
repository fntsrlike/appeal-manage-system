var
ns_user,
ns_appeal;

jQuery.nl2br = function( varTest ){
  (varTest === null) && (varTest = '');
  return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br/>");
};

jQuery.br2nl = function( varTest ){
  (varTest === null) && (varTest = '');
  return varTest.replace(/<br[\w\s\/\-='"]*>/g, "\n");
};

$( function() {
  ns_user   = {
    'status': false,
    'name'  : '',
    'u_id'  : 0,
    'c_id'  : 0,
    'm_id'  : 0,
    'is_sa' : null,
  };

  ns_appeal = {
    'cases'    : {},
    'replies'  : {},
    'managers' : {},
    'actions'  : {},
  };

  ns_user.update = function() {
    var url  = $( '#api_user_url' ).attr( 'action' );

    $.get( url, function( data ){
      if ( true === data.status ) {
        ns_user.status  = data.status;
        ns_user.name    = data.username;
        ns_user.u_id    = data.u_id;
        ns_user.c_id    = data.c_id;
        ns_user.m_id    = data.m_id;
        ns_user.is_sa   = data.is_sa;
      } else {
        ns_user.status  = false;
        ns_user.name    = '';
        ns_user.u_id    = 0;
        ns_user.c_id    = 0;
        ns_user.m_id    = 0;
        ns_user.is_sa   = null;
      }
    })
    .done( function() {
      ns_user.update_view();
    });
  };

  ns_user.update_view = function() {
    if ( true === ns_user.status ) {
      $( '.login_show' ).removeClass('hidden');
      $( '.login_hidden' ).addClass('hidden');
    }
    else {
      $( '.login_show' ).addClass('hidden');
      $( '.login_hidden' ).removeClass('hidden');
    }

    if ( ( ns_user.m_id > 0 ) ) {
      $( '.manager_show').removeClass('hidden');
    } else {
      $( '.manager_show').addClass('hidden');
    }

    if ( true === ns_user.is_sa ) {
      $( '.sa_show' ).removeClass('hidden');
    } else {
      $( '.sa_show' ).addClass('hidden');
    }
  };

  ns_appeal.run = function() {
    ns_appeal.listener();
    ns_appeal.update();
  };

  ns_appeal.listener = function() {
    $( '#appeal-status button' ).click( function( event ) {
      event.preventDefault();
      var status = $( this ).attr ('value' );
      ns_appeal.cases.show_list( status );
    });

    $( '#appeal_form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.cases.store( $( this ) );
    });

    $( '#reply_form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.replies.store( $( this ) );
    });

    $( '#EditModal form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.managers.update_files( $( this ) );
    });

    $( '#StopPermissionModal form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.managers.update_status( $( this ), 'stop' );
    });

    $( '#RecoverPermissionModal form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.managers.update_status( $( this ), 'recover' );
    });

    $( '#DeleteModal form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.managers.destroy( $( this ) );
    });

    $( '#CreateManager form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.managers.store( $( this ) );
    });

    $( '#AppealEndingModal form' ).submit( function( event ) {
      event.preventDefault();
      ns_appeal.cases.update( $( this ) );
    });

    $( 'a[href="#appeal-list"]' ).click( function() {
      ns_appeal.cases.show_list( 0 );
    });
  };

  ns_appeal.update = function() {
    ns_user.update();
    ns_appeal.cases.show_list( 0 );
    ns_appeal.managers.show_list();
    ns_appeal.actions.show_actions();
  };

  ns_appeal.cases.store = function( form ) {
    var
    url = form.attr( "action" ),
    input = {
      "title"   : form.find( "input[name='title']" ).val(),
      "target"  : form.find( "input[name='target']" ).val(),
      "place"   : form.find( "input[name='place']" ).val(),
      "date"    : form.find( "input[name='date']" ).val(),
      "content" : form.find( "textarea[name='content']" ).val(),
      'privacy_case'        : form.find( "input[name='privacy_case']:checked" ).val(),
      'privacy_complainant' : form.find( "input[name='privacy_complainant']:checked" ).val(),
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
        } else {
          msgs = '<ul>';

          for ( var key in data.msg ) {
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

  ns_appeal.cases.show = function( case_id ) {
    var
    url  = $( '#api_case_url' ).attr( 'action' ) + '/' + case_id,
    grade = { '1' : '一年級', '2' : '二年級', '3' : '三年級', '4' : '四年級', '5' : '四年級Up' },
    case_status     = { 1 : '未處理', 2 : '處理中', 3 : '處理完畢' },
    case_status_m   = { 1 : 'todo', 2 : 'doing', 3 : 'done' },
    reply_status    = { 1 : '開放討論' , 0 : '不開放討論' },
    reply_status_m  = { 1 : 'on' , 0 : 'off' };

    $.get(url, function(data){

      if ( data.length === 0 ) {
        alert( '您所要求的申訴案件並不存在！' );
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
      $( '#appeal-view-status' ).html( case_status[data.status] + '（' + reply_status[data.reply_status] + '）' );
      $( '#appeal-view-content'  ).html( $.nl2br( data.content ) );
      $( '#appeal-view-pName'    ).html( data.name );
      $( '#appeal-view-pDepart'  ).html( data.depart + '（' + grade[data.grade] + '）' );
      $( '#appeal-view-pPhone' ).html( data.phone );
      $( '#appeal-view-pEmail' ).html( data.email );
      $( '#appeal-view-report' ).html( $.nl2br( data.report ) );
      $( '#appeal-view-id' ).attr( 'value', case_id );
      $( '#AppealEndingModal_id' ).attr( 'value', case_id );

      $( '#AppealEndingModal form').find( "select[name='case_status']" ).val( case_status_m[data.status] );
      $( '#AppealEndingModal form').find( "select[name='reply_status']" ).val( reply_status_m[data.reply_status] );
      $( '#AppealEndingModal form').find( "textarea[name='report']" ).html( $.br2nl( data.report ) );

      ns_appeal.replies.show( case_id );

      console.log( ns_user.name == data.name , data.reply_status == 1 );
      if ( ( ns_user.name == data.name || ns_user.m_id > 0 ) && data.reply_status == 1) {
        $( '#reply_form textarea' ).attr('placeholder', '請輸入想要討論的留言');
        $( '#reply_form textarea' ).removeAttr('disabled');
        $( '#reply_form button' ).removeAttr('disabled');
      } else {
        $( '#reply_form textarea' ).attr('placeholder', '討論功能已關閉。');
        $( '#reply_form textarea' ).attr('disabled', 'disabled');
        $( '#reply_form button' ).attr('disabled', 'disabled');
      }

    });
  };

  ns_appeal.cases.show_list = function( status ) {
    var
    case_list = [],
    url  = $( '#api_case_url' ).attr( 'action' );

    $.get( url, function( data ){
      if ( status != '0' ) {
        for ( var key in data ) {
          if ( ( status == '4' ) ) {
            if ( true === data[key].is_owner ) {
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

      ns_appeal.cases.make_list( case_list );
    });
  };

  ns_appeal.cases.make_list = function( case_list ) {
    var href, tmp, trs = '';

    for ( var key in case_list) {

      href = '<a href="#appeal-view-' + case_list[key].id + '">';
      href += case_list[key].title + '</a>';

      tmp = '<tr>';
      tmp += '<td class="text-center">' + case_list[key].created_at.date. substring(0,10) + '</td>';
      tmp += '<td>' + href + '</td>';
      tmp += ns_appeal.cases.make_list_status(case_list[key].status, case_list[key].replies_count);
      tmp += '</tr>';

      trs += tmp;
    }
    $( '#list_table tbody' ).html( trs );
  };

  ns_appeal.cases.make_list_status = function( status, reply_no ) {
    var msg = '';

    switch( status ) {
      case 1:
        msg += '<td class="text-danger text-center">';
        msg += '未處理 <span class="label label-danger">' + reply_no + '</span></td>';
        break;

      case 2:
        msg += '<td class="text-warning text-center">';
        msg += '處理中 <span class="label label-warning">' + reply_no + '</span></td>';
        break;

      case 3:
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

  ns_appeal.cases.update = function( form ) {
    var
    id  = $( '#AppealEndingModal_id').attr( 'value' ),
    url = $( '#api_case_url' ).attr( "action" ) + '/' + id + '?t=manage',
    input = {
      "case_status"   : form.find( "select[name='case_status']" ).val(),
      "reply_status"  : form.find( "select[name='reply_status']" ).val(),
      "report"        : form.find( "textarea[name='report']" ).val(),
    };

    $.ajax({
      type: 'PUT',
      url: url,
      data: input,
      success: function( data ) {
        var msg, msgs, hash;

        if ( data.status == '200 OK' ) {
          alert( '您的案件編輯表單已成功送出！' );
          form.each( function() {
            this.reset();
          });

          $( '#AppealEndingModal' ).modal( 'hide' );
          ns_appeal.cases.show( id );
        } else {
          msgs = '<ul>';

          for ( var key in data.msg ) {
            msgs += '<li><span class="text-danger">' + data.msg[key] + '</span></li>';
          }

          msgs += '</ul>';

          $( '#AppealEndingModal_msg' ).html( msgs );
        }
      },
      dataType: 'json'
    })
    .fail(function() {
      alert( '連線失敗，請檢查網路狀況，或是聯絡管理員！' );
    });
  };

  ns_appeal.replies.store = function( form ) {
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

          ns_appeal.replies.show( input.case_id );
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

  ns_appeal.replies.show = function( case_id ) {
    var
    url  = $( '#api_reply_url' ).attr( 'action' ) + '?case_id=' + case_id;

    $.get( url, function( data ){

      if ( ( data.length === 0 ) || ( data.status == '400 Bad Request' ) ) {
        $('#appeal-view-dialog').html('<p class="text-danger text-center">對話讀取錯誤</p>');
        return;
      }

      if ( data.status == '401 Unauthorized' || data.status == '403 Forbidden' ) {
        $('#appeal-view-dialog').html('<p class="text-info text-center">本申訴案留言已經設成隱藏。</p>');
        return;
      }

      if ( data.replies_count <= 0 ) {
        $('#appeal-view-dialog').html('<p class="text-info text-center">目前沒有對話</p>');
        return;
      }

      ns_appeal.replies.make( data.replies );
    });
  };

  ns_appeal.replies.make = function( replies ) {
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
      block += $.nl2br( content );
      block += '</div></div>';

      blocks += block;
    }

    $('#appeal-view-dialog').html(blocks);
  };

  ns_appeal.managers.show_list = function() {
    var
    url  = $( '#api_manager_url' ).attr( 'action' );

    $.get( url, function( data ){
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
          being_managers.push( manager );
        }
        else if ( manager.status == 2 ) {
          was_managers.push( manager );
        }
      }

      ns_appeal.managers.make_list( 'being', being_managers );
      ns_appeal.managers.make_list( 'was', was_managers );
    })
    .done(function(){
      ns_appeal.managers.refresh_listener();
    });
  };

  ns_appeal.managers.make_list = function( type, list ) {
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
          row += '<a data-toggle="modal" data-target="#StopPermissionModal" for="' + manager.m_id + '"><span class="text-warning">凍權</span></a>';
          row += '</td>';
        }
        else if ( type == 'was' ) {
          row += '<td>';
          row += '<a data-toggle="modal" data-target="#DeleteModal" for="' + manager.m_id + '"><span class="text-danger">刪除</span></a>';
          row += ' | ';
          row += '<a data-toggle="modal" data-target="#RecoverPermissionModal" for="' + manager.m_id + '"><span class="text-warning">復權</span></a>';
          row += '</td>';
        }
      }

      row += '</tr>';

      rows += row;
    }

    $( '#' + hash + ' tbody' ).html( rows );
  };

  ns_appeal.managers.refresh_listener = function() {
    $( 'a[data-target="#EditModal"]' ).click( function() {
      var id = $( this ).attr( 'for' );
      ns_appeal.managers.edit_files( id );
    });

    $( 'a[data-target="#StopPermissionModal"]' ).click( function() {
      var id = $( this ).attr( 'for' );
      ns_appeal.managers.edit_status( id, 'stop' );
    });

    $( 'a[data-target="#RecoverPermissionModal"]' ).click( function() {
      var id = $( this ).attr( 'for' );
      ns_appeal.managers.edit_status( id, 'recover' );
    });

    $( 'a[data-target="#DeleteModal"]' ).click( function() {
      var id = $( this ).attr( 'for' );
      ns_appeal.managers.delete( id );
    });
  };

  ns_appeal.actions.show_actions = function() {
    var
    url  = $( '#api_action_url' ).attr( 'action' );

    url += '?args=RECOVERY_MANAGER_PERM+STOP_MANAGER_PERM+DELETE_MANAGER_PERM';

    $.get( url, function( data ){

      if ( 0 === data.length || 0 === data.actions ) {
        return;
      }

      ns_appeal.actions.make_actions( data.actions );
    });
  };

  ns_appeal.actions.make_actions = function( list ) {
    var
    action,
    rows = '',
    row,
    type = {
        'RECOVERY_MANAGER_PERM' : '復權',
        'STOP_MANAGER_PERM'     : '凍權',
        'DELETE_MANAGER_PERM'   : '刪除'
      },
    perm = ( ns_user.m_id > 0 ) || ( ns_user.is_sa === true ) ;

    for ( var key in list ) {
      action = list[key];

      row = '<tr>';
      row += '<td>' + action.datetime.date.substring( 0, 10 ) + '</td>';
      row += '<td>' + type[action.type] + '</td>';
      row += '<td>' + action.reason     + '</td>';
      row += ( true === perm ) ? '<td>' + action.operator + '</td>' : '';
      row += '</tr>';

      rows += row;
    }

    $( '#manager_action_list tbody' ).html( rows );

  };

  ns_appeal.managers.edit_files = function( id ) {
    var
    url = $( '#api_manager_url' ).attr( 'action' ) + '/' + id;

    $.get( url, function( data ) {
      var manager = data.manager;

      $( '#EditModal_name' ).html( manager.name + '（' + manager.username + '）' );
      $( '#EditModal_title' ).val( manager.title );
      $( '#EditModal_id' ).val( id );
      $( '#EditModal_msg' ).html('');
    });
  };

  ns_appeal.managers.edit_status = function( id, type ) {
    var
    url = $( '#api_manager_url' ).attr( 'action' ) + '/' + id,
    type_hash = { 'stop' : 'StopPermissionModal', 'recover' : 'RecoverPermissionModal' },
    hash = '#' + type_hash[type];

    $.get( url, function( data ) {
      var manager = data.manager;

      $( hash + '_reason' ).val( '' );
      $( hash + '_name' ).html( manager.name + '（' + manager.username + '）' );
      $( hash + '_id' ).val( id );
      $( hash + '_msg' ).html('');
    });
  };

  ns_appeal.managers.update_files = function( form ) {
    var
    id  = form.find( 'input[name="id"]' ).val(),
    url = $( '#api_manager_url' ).attr( 'action' ) + '/' + id,
    input = {
      'type'  : 'files',
      'title' : form.find( 'input[name="title"]' ).val()
    };

    $.ajax({
      url: url,
      type: 'PUT',
      data: input,
      dataType: 'json',
      success: function(data) {
        var
        msg, msgs;

        if ( data.status == '200 OK' ) {
          alert('您的修改已經成功送出！');
          $( '#EditModal' ).modal( 'hide' );
        } else {
          msgs = '<ul>';

          for ( var key in data.msg ) {
            msg = '<li><span class="text-danger">';
            msg += data.msg[key];
            msg += '</span></li>';

            msgs += msg;
          }
          msgs += '</ul>';

          $( '#EditModal_msg' ).html( msgs );
        }
      }
    })
    .fail(function() {
      //
    })
    .done(function() {
      ns_appeal.managers.show_list();
    });
  };

  ns_appeal.managers.update_status = function( form, status ) {
    var
    id    = form.find( 'input[name="id"]' ).val(),
    hash  = { 'stop' : 'StopPermissionModal', 'recover' : 'RecoverPermissionModal'},
    url   = $( '#api_manager_url' ).attr( 'action' ) + '/' + id,
    input = {
      'type'    : 'status',
      'reason'  : form.find( 'input[name="reason"]' ).val(),
      'status'  : status
    };

    $.ajax({
      url: url,
      type: 'PUT',
      data: input,
      dataType: 'json',
      success: function(data) {
        var
        msg, msgs;

        if ( data.status == '200 OK' ) {
          alert('您的修改已經成功送出！');
          $( '#' + hash[status] ).modal( 'hide' );
        } else {
          msgs = '<ul>';

          for ( var key in data.msg ) {
            msg = '<li><span class="text-danger">';
            msg += data.msg[key];
            msg += '</span></li>';

            msgs += msg;
          }
          msgs += '</ul>';

          $( '#' + hash[status] + '_msg' ).html( msgs );
        }
      }
    })
    .fail(function() {
      //
    })
    .done(function() {
      ns_appeal.managers.show_list();
      ns_appeal.actions.show_actions();
    });
  };

  ns_appeal.managers.delete = function( id ) {
    var
    url = $( '#api_manager_url' ).attr( 'action' ) + '/' + id;

    $.get( url, function( data ) {
      var manager = data.manager;

      $( '#DeleteModal_target' ).html( manager.name + '（' + manager.username + '）' );
      $( '#DeleteModal_id' ).val( id );
      $( '#DeleteModal_msg' ).html('');
      $( '#DeleteModal_username' ).val('');
      $( '#DeleteModal_name' ).val('');
      $( '#DeleteModal_reason' ).val('');
    });
  };

  ns_appeal.managers.destroy = function( form ) {
    var
    id        = form.find( 'input[name="id"]' ).val(),
    url       = $( '#api_manager_url' ).attr( 'action' ) + '/' + id,
    input = {
      'username': form.find( 'input[name="username"]' ).val(),
      'name'    : form.find( 'input[name="name"]' ).val(),
      'reason'  : form.find( 'input[name="reason"]' ).val()
    };

    $.ajax({
      url: url,
      type: 'DELETE',
      data: input,
      dataType: 'json',
      success: function( data ) {
        var
        msg, msgs;

        if ( data.status == '200 OK' ) {
          alert('已經成功刪除該管理員！');
          $( '#DeleteModal' ).modal( 'hide' );
          form.each( function() {
            this.reset();
          });
        } else {
          msgs = '<ul>';

          for ( var key in data.msg ) {
            msg = '<li><span class="text-danger">';
            msg += data.msg[key];
            msg += '</span></li>';

            msgs += msg;
          }
          msgs += '</ul>';

          $( '#DeleteModal_msg' ).html( msgs );
        }
      }
    })
    .fail(function() {
      //
    })
    .done(function() {
      ns_appeal.managers.show_list();
      ns_appeal.actions.show_actions();
    });
  };

  ns_appeal.managers.store = function( form ) {
    var
    url       = $( '#api_manager_url' ).attr( 'action' ),
    input = {
      'username': form.find( 'input[name="username"]' ).val(),
      'title'    : form.find( 'input[name="title"]' ).val(),
    };

    $.ajax({
      url: url,
      type: 'POST',
      data: input,
      dataType: 'json',
      success: function( data ) {
        var
        msg, msgs;

        if ( data.status == '200 OK' ) {
          alert('已經成功新增該管理員！');
          form.each( function() {
            this.reset();
          });
        } else if ( data.status == '403 Forbidden' ) {
          alert('您沒有權限進行此操作！');
        } else {
          msgs = '<ul>';

          for ( var key in data.msg ) {
            msg = '<li><span class="text-danger">';
            msg += data.msg[key];
            msg += '</span></li>';

            msgs += msg;
          }
          msgs += '</ul>';

          $( '#CreateManager_msg' ).html( msgs );
        }
      }
    })
    .fail(function() {
      //
    })
    .done(function() {
      ns_appeal.managers.show_list();
    });
  };

  ns_appeal.run();

});

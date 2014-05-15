<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{Config::get('appeal.site.name')}}</title>
</head>
<body>
  <div>
    <h3># 帳號資訊</h3>
    <ul>
      <li>使用者名稱：{{$username}}</li>
    </ul>
  </div>
  <div>
    <h3># 學生資訊</h3>
    <ul>
      <li>學號：{{$number}}</li>
      <li>科系：{{$department}}</li>
      <li>年級：{{$grade}}</li>
    </ul>
  </div>
  <div>
    <h3># 個人資訊</h3>
    <ul>
      <li>姓名：{{$name}}</li>
      <li>電話：{{$phone}}</li>
      <li>Email：{{$email}}</li>
    </ul>
  </div>
  <div>
    <h3># 錯誤訊息</h3>
    <ul>
      @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
      @endforeach
    </ul>
  </div>
  <div>
    @if ($validation === false)
      這些資料皆來自伊爾特系統，若是資料有缺、錯誤，請先到伊爾特系統修改後，再註冊。
    @else
      {{ Form::open(array('action' => 'PortalController@register_proccess')) }}
        <a href="{{action('AppealController@index')}}"><button type="button">取消</button></a>
        <button type="submit">註冊</button>
      {{ Form::close() }}
    @endif
  </div>

</body>
</html>
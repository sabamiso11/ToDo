@extends('layouts.default')

@section('title', 'Laravelチュートリアル')

@section('content')
  <div class="form-group">
    <form method="post" action="/create">
      {{ csrf_field() }}
        <label for="nameInput">ToDoリスト名</label>
        <input type="text" class="form-control" id="listNameInput" name="list_name">
      <button type="submit" class="btn btn-primary" id="addList">新規追加</button>
    </form>
  </div>


  <!-- 追加完了時にフラッシュメッセージ　-->
  @if(Session::has('message'))
    <div class="bg-info">
      <p>{{ Session::get('message') }}</p>
    </div>
  @endif

  @if ($errors->has('list_name'))
    <div class="bg-info">
       <p class="error">{{ $errors->first('list_name') }}</p>
    </div>
  @endif

  <h2 class="text-left">ToDoリスト</h2>

  @foreach ($lists as $list)
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><a href="{{ url('/lists', $list) }}">{{ $list->list_name }}</a></h4>
        @if($list->tasks_count > 0)
          <h6 class="card-subtitle mb-2 text-muted">{{ $list->tasks_count }}個中{{ $list->done_count }}個がチェック済み</h6>
          @foreach($dead_lines as $dead_line)
            @if($dead_line->id == $list->id)
              @foreach($dead_line->tasks as $task_limit)
                @if($loop->first)
                  <p class="card-text">期限:{{ $task_limit->limit }}</p>
                @endif
              @endforeach
            @endif
          @endforeach
        @else
          <p class="card-text">ToDoがありません</p>
        @endif
      </div>
    </div>
  @endforeach
@endsection
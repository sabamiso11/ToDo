@extends('layouts.default')

@section('title', 'Laravelチュートリアル')

@section('content')
    <h1>{{ $list->list_name }}</h1>

    <h2>タスク一覧</h2>
    <form method="post" action="{{ action('TaskController@store', $list) }}" >
      {{ csrf_field() }}
      <div class="form-group">
        <label for="nameInput">タスク名</label>
        <input type="text" class="form-control" id="nameInput" name="task_name">
        <input type="date" class="form-control" id="limitInput" name="limit">
      </div>
      <button type="submit" class="btn btn-primary">新規追加</button>
    </form>

    <form method="post" action="{{ action('TaskController@destroy', $list) }}" >
      {{ csrf_field() }}
      <button type="submit" class="btn btn-primary" name="destroy" value="{{ $list->id }}">完了済みを一括削除</button>
    </form>


    <!-- 追加完了時にフラッシュメッセージ　-->
    @if(Session::has('message'))
      <div class="bg-info">
        <p>{{ Session::get('message') }}</p>
      </div>
    @endif

    @if ($errors->has('task_name'))
      <div class="bg-info">
        <p class="error">{{ $errors->first('task_name') }}</p>
      </div>
    @endif

        @if ($errors->has('limit'))
      <div class="bg-info">
        <p class="error">{{ $errors->first('limit') }}</p>
      </div>
    @endif
    <ul>
      @forelse ($list->tasks->sortByDesc('created_at') as $task)
      <li>{{ $task->task_name }}</li>
      <form method="post" action="{{ action('TaskController@state', $list) }}" >
        {{ csrf_field() }}
        @if($task->done)
          <button type="submit" class="btn btn-primary" name="done" value="{{ $task->id }}">完了</button>
        @else
          <button type="submit" class="btn btn-primary" name="done" value="{{ $task->id }}">未完了</button>
        @endif
      </form>
      <li>期限：{{ $task->limit }}</li>
      <li>作成日:{{ $task->created_at }}</li>
      @empty
      <p>登録されたToDoはございません</p>
      @endforelse
    </ul>
@endsection
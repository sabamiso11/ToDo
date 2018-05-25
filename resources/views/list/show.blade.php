@extends('layouts.default')

@section('content')
<h3>{{ $list->list_name }}</h3>

<form method="post" action="{{ action('TaskController@store', $list) }}" >
  {{ csrf_field() }}
  <div class="form-group">
    <label for="taskNameInput">タスク名</label>
    <input type="text" class="form-control" id="nameInput" name="task_name">
    <label for="limitInput">期限</label>
    <input type="date" class="form-control" id="limitInput" name="limit">
    <button type="submit" class="btn btn-primary mt-1">新規追加</button>
  </div>
</form>

<!-- 追加完了時にフラッシュメッセージ　-->
@if(Session::has('message'))
<div class="alert alert-sccess mt-1" role="alert">
  {{ Session::get('message') }}
</div>
@endif

@if ($errors->has('task_name'))
<div class="alert alert-danger mt-1" role="alert">
  {{ $errors->first('task_name') }}
</div>
@endif

@if ($errors->has('limit'))
<div class="alert alert-danger mt-1" role="alert">
  {{ $errors->first('limit') }}
</div>
@endif

<div class="row mb-2">
<h3 class="col">ToDo一覧</h3>

@if(count($list->tasks) > 0)
<form method="post" action="{{ action('TaskController@destroy', $list) }}" >
{{ csrf_field() }}
<button type="submit" class="btn btn-outline-success col" name="destroy" value="{{ $list->id }}">完了済みを一括削除</button>
</form>
@endif
</div>

@forelse ($list->tasks->sortByDesc('created_at') as $task)
<div class="card mb-2 w-100">
  <div class="card-body row">
    <div class="col-10">
      <h4 class="card-title">{{ $task->task_name }}</h4>
      <p class="card-text">期限：{{ $task->limit }}</p>
      <p class="card-text">作成日:{{ $task->created_at }}</p>
    </div>

    <div class="col-2 mx-0 my-auto w-100">
      <form method="post" action="{{ action('TaskController@state', $list) }}" >
      {{ csrf_field() }}
    @if($task->done)
        
        <button type="submit" class="btn btn-primary btn-lg" name="done" value="{{ $task->id }}">完了</button>
    @else
        <button type="submit" class="btn btn-danger btn-lg" name="done" value="{{ $task->id }}">未完了</button>
    @endif
      </form>
    </div>
  </div>
</div>
@empty
  <p class="mt-5 text-danger">登録されたToDoはございません</p>
@endforelse

@endsection
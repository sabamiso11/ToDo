@extends('layouts.default')

@section('style')
<style>
#destroy{
  top: 10px;
  right: 10px;
}
</style>
@endsection

@section('content')
<form method="post" action="/create">
  {{ csrf_field() }}
  <label for="nameInput">ToDoリスト名</label>
  <div class="input-group">
    <input type="text" class="form-control" id="listNameInput" name="list_name">
    <div class="input-group-append ml-2">
      <button type="submit" class="btn btn-primary" id="addList">新規追加</button>
    </div>
  </div>
</form>


<!-- 追加完了時にフラッシュメッセージ　-->
@if(Session::has('message'))
  <div class="alert alert-success mt-1" role="alert">
    {{ Session::get('message') }}
  </div>
@endif

@if ($errors->has('list_name'))
  <div class="alert alert-danger mt-1" role="alert">
    {{ $errors->first('list_name') }}
  </div>
@endif

<h2 class="text-left mt-3">ToDoリスト</h2>
@forelse ($lists as $list)
  <div class="card mb-2">
    <div class="card-body">
      <form method="post" action="{{ url('/lists', $list->id) }}" id="form_{{ $list->id }}">
        {{ csrf_field() }}
        {{ method_field('delete') }}
        <a href="#" data-id="{{ $list->id }}" class="btn btn-outline-secondary btn-sm position-absolute" id="destroy" onclick="deleteList(this);">×</a>
      </form>
      <h4 class="card-title"><a href="{{ url('/lists', $list) }}">{{ $list->list_name }}</a></h4>
      @if($list->tasks_count > 0)
        <h6 class="card-subtitle mb-2 text-muted">{{ $list->tasks_count }}個中{{ $list->done_count }}個がチェック済み</h6>
        @if($list->dead_line)
          <p class="card-text">期限:{{ $list->dead_line }}</p>
        @endif
      @else
        <p class="card-text">ToDoがありません</p>
      @endif
    </div>
  </div>
@empty
  <p class="mt-5 text-danger">登録されたToDoリストはございません</p>
@endforelse
@endsection

@section('script')
<script>
function deleteList(e) {
  'use strict';
 
  if (confirm('本当に削除していいですか?')) {
  document.getElementById('form_' + e.dataset.id).submit();
  }
}
</script>
@endsection
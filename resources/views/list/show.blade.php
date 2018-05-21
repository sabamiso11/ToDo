<html lang="ja">
  <head>
    <title>Laravelチュートリアル</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body class="p-3">
    <h1>{{ $list->list_name }}</h1>

    <h2>タスク一覧</h2>
    <form method="post" action="{{ action('TaskController@store', $list) }}" >
      {{ csrf_field() }}
      <div class="form-group">
        <label for="nameInput">タスク名</label>
        <input type="text" class="form-control" id="nameInput" name="task_name">
        <input type="date" class="form-control" id="limitInput" name="limit">
      </div>
      <button type="submit" class="btn btn-primary" name="list_id" value="{{$list->id}}">新規追加</button>
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

    <ul>
      @forelse ($list->tasks as $task)
      <li>{{ $task->task_name }}
      <form method="post" action="{{ action('TaskController@state', $list) }}" >
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary" name="done" value="{{ $task->id }}">{{ $task->done == false ? "未完了" : "完了" }}</button>
      </form>
      </li>
      @empty
      <li>No Tasks yet</li>
      @endforelse
    </ul>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ToDo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <style>
      body {
        width: 50%;
        margin: 0 auto;
      }
      #search{
        right: 0;
        bottom: 0;
      }
    </style>
    @yield('style')
  </head>
  <body>
    <header>
      <div class="row my-3 mx-auto">
        <div class="col" >
          <a href="{{ URL::to('/') }}"><img class="w-100" src={{ asset('/img/top.JPG') }} alt="ToDoApp"></a>
        </div>
        <div class="col position-relative">
          <a href="/search" id="search" class="position-absolute btn btn-outline-primary btn-lg">検索</a>
        </div>
      </div>
    </header>
    <main>
    @yield('content')
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    @yield('script')
    @yield('vue')
  </body>
</html>

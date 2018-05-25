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
    </style>

  </head>
  <body>
    <header>
        <div id="top" class="row">
            <div class="col my-3 mx-auto" >
                <a href="{{ URL::to('/') }}"><img class="w-100" src={{ asset('/img/top.JPG') }} alt="ToDoApp"></a>
            </div>
            <div class="col">
            </div>
        </div>
    </header>
    <main>
        <div id="app">
            <div class="input-group">
                {{ csrf_field() }}
                <input type="text" class="form-control" v-model="params.keyword">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" @click="onClick">検索</button>
                </div>
            </div>
            
            <h3 class="mt-3" v-if="tasks.length > 0">ToDo</h3>
            <p class="mt-3" v-if="tasks.length > 0">ToDoが@{{ tasks.length }}件見つかりました</p>
            <div class="card mb-2" v-for="task in tasks">
                <div class="card-body">
                    <div class="pull-left">
                        <h4 class="card-title"><a v-bind:href="'/lists/' + task.task_list_id">@{{ task.task_name }}<a></h4>
                        <p class="card-text">リスト:@{{ task.list_name }}</p>
                    </div>
                    <div class="pull-right">
                        <p class="card-text">期限:@{{ task.limit }}</p>
                        <p class="card-text">作成日:@{{ task.created_at }}</p>
                    </div>
                </div>
            </div>
            <p class="text-danger" v-if="tasks.length == 0">対象のToDoは見つかりません</p>

            <h3 class="mt-3" v-if="lists.length > 0">ToDoリスト</h3>
            <p v-if="lists.length > 0">ToDoリストが@{{ lists.length }}件見つかりました</p>
            <div class="card mb-2" v-for="list in lists">
                <div class="card-body">
                    <h4 class="card-title"><a v-bind:href="'/lists/' + list.id">@{{ list.list_name }}<a></h4>
                    <p class="card-text">作成日:@{{ list.created_at }}</p>
                </div>
            </div>
            <p class="text-danger" v-if="lists.length == 0">対象のToDoリストは見つかりません</p>            

            <a href="#top" class="pull-right" v-if="lists.length > 0 || tasks.length > 0">先頭へ戻る</a>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        Vue.prototype.$http = axios;

        new Vue({
            el: '#app',
            data:{
                params:{
                    keyword: ''
                },
                tasks: {},
                lists: {},
            },
            methods:{
                onClick: function(){
                    var self = this;
                    console.log("OK");
                    this.$http.post('/ajax/search', this.params)
                        .then(function(response){
                            //成功処理
                            self.tasks = response.data[0];
                            self.lists = response.data[1];
                        }).catch(function(error){
                            //失敗処理
                        });

                }
            }
        });
    </script>
  </body>
</html>
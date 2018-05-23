@extends('layouts.default')

@section('title', 'Laravelチュートリアル')

@section('content')

    <div id="app">
        <!-- <form method="post" action="/ajax/search"> -->
            {{ csrf_field() }}
            <input type="text" v-model="params.keyword">
            <button type="button" @click="onClick">検索</button>
        <!-- </form> -->
        <p v-if="tasks.length > 0">ToDoが@{{ tasks.length }}件見つかりました</p>
        <ul v-for="task in tasks">
            <li><a v-bind:href="'/lists/' + task.task_list_id">@{{ task.task_name }}<a></li>
            <li>リスト:@{{ task.list_name }}</li>
            <li>期限:@{{ task.limit }}</li>
            <li>作成日:@{{ task.created_at }}</li>
        </ul>
        <p v-if="tasks.length == 0">対象のToDoは見つかりません</p>


        <p v-if="lists.length > 0">ToDoリストが@{{ tasks.length }}件見つかりました</p>
        <ul v-for="list in lists">
            <li><a v-bind:href="'/lists/' + list.id">@{{ list.list_name }}<a></li>
            <li>作成日:@{{ list.created_at }}</li>
        </ul>
        <p v-if="lists.length == 0">対象のToDoリストは見つかりません</p>
        
    </div>

@endsection

@section('vue')
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
@endsection
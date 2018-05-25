# 使用した技術要素

- フレイムワーク
    - Laravel 5.5.40
    - BootStrap 4.0.0
    - Vue.js 2.5.13
- プログラミング言語
    - HTML5
    - CSS3
    - PHP7.0.25
    - JavaScript
- その他(ライブラリなど)
    - jQuery3.2.1
    - Ajax
    - axios

# 全体の設計・構成
## 開発環境
- CentOS6.9(Vagrant1.9.7)
- MySQL 5.6.38
- PHP 7.0.25
- Composer 1.6.5
- git 1.7.1
- nvm 0.33.11
- Node.js 8.11.2
- npm 5.6.0

## データベース設計
```ToDoリスト
+------------+------------------+------+-----+---------+----------------+
| Field      | Type             | Null | Key | Default | Extra          |
+------------+------------------+------+-----+---------+----------------+
| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| list_name  | varchar(191)     | NO   |     | NULL    |                |
| created_at | timestamp        | YES  |     | NULL    |                |
| updated_at | timestamp        | YES  |     | NULL    |                |
+------------+------------------+------+-----+---------+----------------+
```

```ToDo
+--------------+------------------+------+-----+---------+----------------+
| Field        | Type             | Null | Key | Default | Extra          |
+--------------+------------------+------+-----+---------+----------------+
| id           | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| task_list_id | int(10) unsigned | NO   | MUL | NULL    |                |
| task_name    | varchar(191)     | NO   |     | NULL    |                |
| limit        | date             | NO   |     | NULL    |                |
| done         | tinyint(1)       | NO   |     | 0       |                |
| created_at   | timestamp        | YES  |     | NULL    |                |
| updated_at   | timestamp        | YES  |     | NULL    |                |
+--------------+------------------+------+-----+---------+----------------+
```

```uml
@startuml

/'
  図の中で目立たせたいエンティティに着色するための
  色の名前（定数）を定義します。
'/
!define MAIN_ENTITY #E2EFDA-C6E0B4
!define MAIN_ENTITY_2 #FCE4D6-F8CBAD

/' 他の色も、用途が分りやすいように名前をつけます。 '/
!define METAL #F2F2F2-D9D9D9
!define MASTER_MARK_COLOR AAFFAA
!define TRANSACTION_MARK_COLOR FFAA00

/'
  デフォルトのスタイルを設定します。
  この場合の指定は class です。entity ではエラーになります。
'/
skinparam class {
    BackgroundColor METAL
    BorderColor Black
    ArrowColor Black
}


package "ToDoApp" as todo_app {
    /'
      マスターテーブルを M、トランザクションを T などと安直にしていますが、
      チーム内でルールを決めればなんでも良いと思います。交差テーブルは "I" とか。
      角丸四角形が描けない代替です。
      １文字なら "主" とか "従" とか日本語でも OK だったのが受ける。
     '/
    entity "ToDoリスト" as task_list <<主,TRANSACTION_MARK_COLOR>> MAIN_ENTITY {
        + ID [PK]
        --
        ToDoリスト名
        作成日
        更新日
    }

    entity "ToDo" as task <<T,TRANSACTION_MARK_COLOR>> MAIN_ENTITY_2 {
        + ID   [PK]
        --
        # ToDoリストID [FK]
        ToDo名
        期限
        完了の有無
        作成日
        更新日
    }
}

task_list        ----o{     task

@enduml
```

## MVC設計
- Model
    - TaskList `->ToDoリスト`
    - Task `->ToDo`

- Controller
    - TaskListController.php `->ToDoリストに関するコントローラ`
    - TaskController.php　`->ToDoに関するコントローラ`
    - SearchController.php `->検索に関するコントローラ`
    - Ajax\SearchController.php `->検索に関するAjax用コントローラ`
- View
    - index.blade.php `->Top画面`
    - show.blade.php　`->ToDo詳細画面`
    - search.blade.php `->検索画面`
    - default.blade.php `->共通部分`

- Request
    - TaskListRequest.php　`->TaskListに関するバリデーションチェック`


# 開発環境のセットアップ手順
1. Vagrantセットアップ
    1.  Vagrantのインストールを行う
    2.  任意のフォルダでCentOS6.9のインストールを行う
    ```cmd
    vagrant init bento/centos-6.9
    ```
    3. Vagrantfileを編集し、下記の行のコメントアウトを削除する
    ```
    config.vm.network "private_network", ip: "192.168.33.10"
    ```
    4. vagrntを立ち上げる
    ```
    vagrant up
    ```    
2. MySQLのインストール
    1. MySQL 公式 yum リポジトリの追加
    ```cmd
    sudo yum install http://dev.mysql.com/get/mysql-community-release-el6-5.noarch.rpm
    ```
    2. MySQLのインストール
    ```
    sudo yum install mysql-client mysql-server
    ```
3. PHPのインストール
    1. リポジトリの追加
    ```
    sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm
    ```
    2. PHPのインストール
    ```
    sudo yum install php70w php70w-bcmath php70w-cli php70w-common   php70w-dba php70w-devel php70w-embedded php70w-enchant   php70w-fpm php70w-gd php70w-imap php70w-interbase php70w-intl   php70w-ldap php70w-mbstring php70w-mcrypt   php70w-mysqlnd php70w-odbc php70w-opcache php70w-pdo   php70w-pdo_dblib php70w-pear php70w-pecl-apcu php70w-pecl-imagick   php70w-pecl-redis php70w-pecl-xdebug php70w-pgsql php70w-phpdbg   php70w-process php70w-pspell php70w-recode php70w-snmp php70w-soap   php70w-tidy php70w-xml php70w-xmlrpc
    ```
4. Composerのインストール
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

5. gitのインストール
```
yum -y install git
```

6. Node.js(nvm, node.js, npm)のインストール
    1. nvmのインストール
    ```
    curl -o- https://raw.githubusercontent.com/creationix/nvm/master/install.sh | bash
    ```
    2. node.js, npmのインストール
    ```
    nvm install v8.11.2
    ```
7. Laravelプロジェクトの作成
- composerをインストールしたディレクトリでLaravelプロジェクトを作成する
```
./composer.phar create-project --prefer-dist laravel/laravel プロジェクト名
```

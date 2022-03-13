<?php

// 接続に必要な情報を定数として定義
// hostにはコンテナ名を指定する
define('DSN', 'mysql:host=db;dbname=php_app;charset=utf8;');
define('USER', 'testuser');
define('PASSWORD', '9999');

define('MSG_KEYWORDS_REQUIRED', '検索ワードを入力してください');
define('MSG_SEARCHBOOK_REQUIRED', '本の情報が選択されていません');

define('MSG_TITLE_REQUIRED', 'タイトルを入力してください');
define('MSG_TITLE_NO_CHANGE', 'タイトルが変更されていません');
define('MSG_MEMO_REQUIRED', 'メモを入力してください');
define('MSG_MEMO_NO_CHANGE', 'メモが変更されていません');



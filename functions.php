<?php

// 設定ファイルを読み込む
require_once __DIR__ . '/config.php';

// 接続処理を行う関数
function connect_db()
{
    // try ~ catch 構文
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        // 接続がうまくいかない場合こちらの処理が実行される
        echo $e->getMessage();
        exit;
    }
}

// エスケープ処理を行う関数
function h($str)
{
    // ENT_QUOTES: シングルクオートとダブルクオートを共に変換する。
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function search_validate($keywords)
{
    $errors = [];
    if (empty($keywords)) {
        $errors[] = MSG_KEYWORDS_REQUIRED;
    }
    return $errors;
}

function insert_validate($title, $thumbnail)
{
    $errors = [];
    if (empty($title) || empty($thumbnail)) {
        $errors[] = MSG_SEARCHBOOK_REQUIRED;
    }
    return $errors;
}

function insert_book($title, $thumbnail)
{
    $dbh = connect_db();
    $sql = <<<EOM
    INSERT INTO
        books
        (title, image_url)
    VALUES
        (:title, :image_url)
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':image_url', $thumbnail, PDO::PARAM_STR);
    $stmt->execute();
}

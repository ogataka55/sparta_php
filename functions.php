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

function find_book_all()
{
    $dbh = connect_db();
    // statusを抽出条件に指定してデータ取得
    $sql = <<<EOM
    SELECT
        *
    FROM
        books
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function find_book_one($id)
{
    $dbh = connect_db();
    $sql = <<<EOM
    SELECT
        *
    FROM
        books
    WHERE
        id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function search_validate($keywords)
{
    $errors = [];
    if (empty($keywords)) {
        $errors[] = MSG_KEYWORDS_REQUIRED;
    }
    return $errors;
}

function insert_validate($book)
{
    $errors = [];
    if (empty($book[0]) || empty($book[1])) {
        $errors[] = MSG_SEARCHBOOK_REQUIRED;
    }
    return $errors;
}

function update_validate($title, $memo)
{
    $errors = [];
    if (empty($title)) {
        $errors[] = MSG_TITLE_REQUIRED;
    }
    if (empty($memo)) {
        $errors[] = MSG_MEMO_REQUIRED;
    }
    return $errors;
}

function insert_book($book)
{
    $dbh = connect_db();
    $sql = <<<EOM
    INSERT INTO
        books
        (title, image_url, authors)
    VALUES
        (:title, :image_url, :authors)
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $book[0], PDO::PARAM_STR);
    $stmt->bindParam(':image_url', $book[1], PDO::PARAM_STR);
    $stmt->bindParam(':authors', $book[2], PDO::PARAM_STR);
    $stmt->execute();
}

function update_book($id, $title, $memo)
{
    try {
        $dbh = connect_db();
        $sql = <<<EOM
        UPDATE
            books
        SET
            title = :title,
            memo = :memo
        WHERE
            id = :id
        EOM;
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':memo', $memo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (\PDOException $e) {
        echo '更新に失敗しました';
    }
}

function delete_book($id)
{
    $dbh = connect_db();
    $sql = <<<EOM
    DELETE FROM
        books
    WHERE
        id = :id
    EOM;
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

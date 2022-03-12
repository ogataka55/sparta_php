<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

$keywords = '';
$title = '';
$thumbnail = '';
$errors = [];
$book = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (filter_input(INPUT_GET, 'keywords')) {
        $keywords = filter_input(INPUT_GET, 'keywords');
        $re_keywords = str_replace(' ', '+', $keywords);
        // バリデーション
        $errors = search_validate($re_keywords);
        if (empty($errors)) {
            $data = "https://www.googleapis.com/books/v1/volumes?q={$re_keywords}&maxResults=12";
            $json = file_get_contents($data);
            // 2番目の引数を省略した場合、json_decode関数はオブジェクトを返す
            $json_decode = json_decode($json);
            // jsonデータ内の『items』部分を複数取得して、booksに格納
            if (isset($json_decode->items)) {
                $books = $json_decode->items;
            } else {
                $books = NULL;
            }
            
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book[] = filter_input(INPUT_POST, 'title');
    $book[] = filter_input(INPUT_POST, 'thumbnail');
    // バリデーション
    $errors = insert_validate($book);
    if (empty($errors)) {
        insert_book($book);
        header('Location: index.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_header.html' ?>

<body>
    <header id="header" role="banner">
        <div class="inner">
            <div class="logo">
                <a href="index.php" title="書籍・漫画管理アプリ" rel="home">書籍＆漫画管理アプリ<br /><span>Books and Comics Management</span></a>
            </div>
            <form action="" method="get" class="logo3">
                <input type="text" name="keywords" placeholder="検索ワード(スペース区切り)" required>
                <input type="submit" value="検索" class="btn submit-btn">
            </form>
        </div>
    </header>

    <?php if ($keywords) : ?>
        <h3 class="search_msg">画像を選択すると登録できます！<br>見つからない場合はもう一度ワードを変えて検索して下さい…</h3>
        <div id="wrapper">
            <section class="add_gridWrapper">
                <?php if ($books) : ?>
                    <?php foreach ($books as $book) : ?>
                        <form action="" method="post">
                            <?php
                            // タイトル
                            if (isset($book->volumeInfo->title)) {
                                $title = $book->volumeInfo->title;
                            } else {
                                $title = "-";
                            }
                            // サムネ画像
                            if (isset($book->volumeInfo->imageLinks->thumbnail)) {
                                $thumbnail = $book->volumeInfo->imageLinks->thumbnail;
                            } else {
                                $thumbnail = "images/noimage.png";
                            }
                            // 著者（配列なのでカンマ区切りに変更）
                            if (isset($book->volumeInfo->authors)) {
                                $authors = implode(',', $book->volumeInfo->authors);
                            } else {
                                $authors = "-";
                            }
                            ?>
                            <div class="grid">
                                <div class="box">

                                    <h3>『<?= h($title) ?>』<br><small><?= h($authors) ?></small></h3>
                                    <input type="hidden" name="title" value="<?= h($title) ?>">
                                    <input type="hidden" name="thumbnail" value="<?= h($thumbnail) ?>">
                                    <p class="img"><input type="image" src="<?= h($thumbnail) ?>" alt="<?= h($title) ?>"></p>
                                </div>
                            </div>
                        </form>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h3 class="search_msg">検索結果が0件です…</h3>
                <?php endif; ?>
            </section>
        </div>
    <?php else : ?>
        <h3 class="search_msg">右上の検索欄にワードを入れて検索して下さい！</h3>
    <?php endif; ?>

    <!-- <div id="mainBanner">
            <div class="inner">
                <img src="images/banners/pexels-ylanite-koppens-104431733.jpg" width="940" height="300" alt="ホームページサンプル株式会社のサイトです">
        </div>
    </div>

    <div id="wrapper">
        <section class="gridWrapper">
            <article class="grid">
                <div class="box">
                    <h3>ホームページサンプル</h3>
                    <p class="img"><img width="220" height="220" src="images/banners/eyecatch1.jpg" alt="" /></p>
                    <p>ホームページサンプル株式取り組み ホームページサンプル株式会社と自然との調和を目指。 &#8230;</p>
                    <p class="readmore"><a href="sample.html">詳細を確認する</a></p>
                </div>
            </article>
        </section>
    </div> -->

    <footer id="footer">
        <div class="inner">
            <p class="logo"><a href="index.html" title="sparta camp php" rel="home">Sparta Camp ~PHP~<br /><span>@Hiraizumi</span></a></p>
        </div>
    </footer>

</body>

</html>
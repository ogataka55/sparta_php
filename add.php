<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

$keywords = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (filter_input(INPUT_POST, 'keywords')) {
        $keywords = filter_input(INPUT_POST, 'keywords');
        // バリデーション
        $errors = search_validate($keywords);
        if (empty($errors)) {
            $data = "https://www.googleapis.com/books/v1/volumes?q={$keywords}&maxResults=8";
            $json = file_get_contents($data);
            // 2番目の引数を省略した場合、json_decode関数はオブジェクトを返す
            $json_decode = json_decode($json);
            // jsonデータ内の『items』部分を複数取得して、booksに格納
            $books = $json_decode->items;
        }
    }
    if (filter_input(INPUT_POST, 'search_book')) {
        $book = filter_input(INPUT_POST, 'search_book');
        // バリデーション
        $errors = insert_validate($title, $thumbnail);
        if (empty($errors)) { 
            insert_book($title, $thumbnail);
        }
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
                <a href="index.php" title="本・漫画管理アプリ" rel="home">本＆漫画管理アプリ<br /><span>Books and Comics Management</span></a>
            </div>
            <form action="" method="post" class="logo3">
                <input type="text" name="keywords" placeholder="検索ワードを入力" required>
                <input type="submit" value="検索" class="btn submit-btn">
            </form>
        </div>
    </header>

    <?php if ($keywords) : ?>
        <h3 class="search_msg">画像を選択すると登録できます！ない場合はもう一度検索して下さい…</h3>
        <div id="wrapper">
            <form action="" method="post" class="gridWrapper">
                <?php if ($books) : ?>
                    <?php foreach ($books as $book) :
                        // タイトル
                        $title = $book->volumeInfo->title;
                        // サムネ画像
                        $thumbnail = $book->volumeInfo->imageLinks->thumbnail;
                        // 著者（配列なのでカンマ区切りに変更）
                        $authors = implode(',', $book->volumeInfo->authors); ?>
                        <div class="grid">
                            <div class="box">
                                <h3>
                                    <nobr>『<?= h($title) ?>』</nobr><br><small><?= h($authors) ?></small>
                                </h3>
                                <p class="img"><input type="image" name="search_book" src="<?= h($thumbnail) ?>" alt="検索画像" /></p>
                            </div>
                        </div>
                        <!--  -->
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>検索結果が0件です…</p>
                <?php endif; ?>
            </form>
        </div>
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
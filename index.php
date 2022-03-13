<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

// 一覧表示
$all_books = find_book_all();

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once __DIR__ . '/_header.html' ?>

<body>
    <div class="container">
        <header id="header" role="banner">
            <div class="inner">
                <div class="logo">
                    <a href="index.php" title="書籍・漫画管理アプリ" rel="home">書籍＆漫画管理アプリ<br /><span>Books and Comics Management</span></a>
                </div>
                <div class="logo2">
                    <a href="add.php" title="書籍・漫画管理アプリ" rel="home">検索・登録</a>
                </div>
            </div>
        </header>

        <div id="mainBanner">
            <div class="inner">
                <img src="images/banners/pexels-ylanite-koppens-104431733.jpg" width="940" height="300" alt="ホームページサンプル株式会社のサイトです">
            </div>
        </div>

        <?php if ($all_books) : ?>
            <div id="wrapper">
                <section class="gridWrapper">
                    <?php foreach ($all_books as $one_book) : ?>
                        <div class="grid">
                            <div class="box">
                                <h3>『<?= h($one_book['title']) ?>』<br><small><?= h($one_book['authors']) ?></small></h3>
                                <p class="img"><a class="" href="view.php?id=<?= h($one_book['id']) ?>">
                                        <img src="<?= h($one_book['image_url']) ?>" alt="<?= h($one_book['title']) ?>"></a></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>
            </div>
        <?php else : ?>
            <h3 class="search_msg">登録されている書籍・漫画はありません</h3>
        <?php endif; ?>

        <!-- <div id="wrapper">
        <section class="gridWrapper">
            <article class="grid">
                <div class="box">
                    <h3>ホームページサンプル</h3>
                    <p class="img"><img width="220" height="220" src="images/banners/eyecatch1.jpg" alt="" /></p>
                    <p>ホームページサンプル株式取り組み ホームページサンプル株式会社と自然との調和を目指。 &#8230;</p>
                    <p class="readmore"><a href="sample.html">詳細を確認する</a></p>
                </div>
            </article>
            <article class="grid">
                <div class="box">
                    <h3>自然との調和を目指す</h3>
                    <p class="img"><img width="220" height="220" src="images/banners/eyecatch2.jpg" alt="" /></p>
                    <p>ホームページサンプル株式会社の取り組み では最新技術と自然との自然との調和を目指。 &#8230;</p>
                    <p class="readmore"><a href="sample.html">詳細を確認する</a></p>
                </div>
            </article>
            <article class="grid">
                <div class="box">
                    <h3>ホームページ株式会社</h3>
                    <p class="img"><img width="220" height="220" src="images/banners/eyecatch3.jpg" alt="" /></p>
                    <p>ホームページサンプル株式会社の取り組み ホームページサンプル株式会社では調和を目指。 &#8230;</p>
                    <p class="readmore"><a href="sample.html">詳細を確認する</a></p>
                </div>
            </article>
            <article class="grid">
                <div class="box">
                    <h3>自然との調和を目指す</h3>
                    <p class="img"><img width="220" height="220" src="images/banners/eyecatch4.jpg" alt="" /></p>
                    <p>ホームページサンプル株式会社の取り組み ホームページサンプル株式会社では調和を目指します。 &#8230;</p>
                    <p class="readmore"><a href="sample.html">詳細を確認する</a></p>
                </div>
            </article><br>
            <article class="grid">
                <div class="box">
                    <h3>自然との調和を目指す</h3>
                    <p class="img"><img width="220" height="220" src="images/banners/eyecatch4.jpg" alt="" /></p>
                    <p>ホームページサンプル株式会社の取り組み ホームページサンプル株式会社では調和を目指します。 &#8230;</p>
                    <p class="readmore"><a href="sample.html">詳細を確認する</a></p>
                </div>
            </article>
        </section> -->
        <footer id="footer">
            <div class="inner">
                <p class="logo"><a href="index.html" title="sparta camp php" rel="home">Sparta Camp ~PHP~<br /><span>@Hiraizumi</span></a></p>
            </div>
        </footer>
    </div>


</body>

</html>
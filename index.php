<!DOCTYPE html>
<html lang="ja">

<?php
//ユーザーエージェントを取得
$ua = $_SERVER['HTTP_USER_AGENT'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>9 Splitter for Instagram</title>
    <?php
    //CSSファイルをユーザーエージェントに合わせて読み込む
    if (strpos($ua, 'iPhone') !== false || strpos($ua, 'iPod') !== false || strpos($ua, 'Android') !== false && strpos($ua, 'Mobile') !== false) { //スマホの場合
        echo '<link rel="stylesheet" href="./css/style_sp.css">';
    } else { //PCの場合
        echo '<link rel="stylesheet" href="./css/style.css">';
    }
    ?>
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kiwi+Maru&family=Pacifico&display=swap" rel="stylesheet">
    <!-- Google Adsense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7363201401295069" crossorigin="anonymous"></script>
    <script data-ad-client="ca-pub-7363201401295069" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
    <div id="header">
        <a href="./index"><img src="./img/logo.png" alt="9 Splitter for Instagram"></a>
        <a href="./index" style="color: black; text-decoration: none;">
            <h1>9 Splitter for Instagram</h1>
        </a>
    </div>

    <div id="content">
        <p>画像を3×3に9等分します．</p>
        <p>正方形の画像を選択して，「Split!」ボタンを押してください．ファイルの形式は jpg（jpeg）か png にしてください．</p>
        <form action="./split" method="post" enctype="multipart/form-data">
            <input type="file" name="img" accept=".png,.jpg,.jpeg" required>
            <br>
            <button type="submit">Split!</button>
        </form>
    </div>

    <footer>
        <small>
            <p>Source code is available on <a href="https://github.com/sekaino-usay/9-splitter" target="_blank">GitHub</a></p>
            <p>Copyright © 2022 <a href=" https://9split.usay05.com">9 Splitter</a> All Rights Reserved.</p>
        </small>
    </footer>
</body>

</html>
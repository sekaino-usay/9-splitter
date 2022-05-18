<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>9 Splitter for Instagram</title>
    <link rel="stylesheet" href="./style.css">
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
    <a href="./index.php"><img src="./img/logo.png" width="10%" alt="9 Splitter for Instagram"></a>
    <a href="./index.php" style="color: black; text-decoration: none;">
        <h1>9 Splitter for Instagram</h1>
    </a>
    <div>

        <?php
        //dataディレクトリが存在しない場合は作成
        if (!file_exists("./data")) {
            mkdir("./data");
        }

        //画像が選択されていない場合はエラーを出力
        if (empty($_FILES['img']['tmp_name'])) {
            echo '画像が選択されていません．';
            exit;
        }

        //画像を受け取り
        $oimg = $_FILES['img'];

        //画像のmineタイプを取得
        $mine = mime_content_type($oimg['tmp_name']);

        if ($mine == 'image/jpeg') { //画像のmineタイプがimage/jpegの場合
            img_split_jpg();
        } elseif ($mine == 'image/png') { //画像のmineタイプがimage/pngの場合
            img_split_png();
        } else { //画像のmineタイプがimage/jpeg以外の場合
            echo "この画像のmineタイプは" . $mine . "です．jpg（jpeg）またはpngのを選択してください．";
            exit;
        }

        //画像処理の関数を作成
        //mineタイプがimage/jpegの場合の関数
        function img_split_jpg()
        {
            $oimg = $_FILES['img'];
            $img = imagecreatefromjpeg($oimg['tmp_name']);

            //画像のハッシュ値を取得
            $hash = hash_file('md5', $oimg['tmp_name']);

            //画像を3x3に分割
            $img_x = imagesx($img);
            $img_y = imagesy($img);
            $img_x_3 = $img_x / 3;
            $img_y_3 = $img_y / 3;

            //画像を3x3に分割した画像を配列に格納
            $img_array = array();
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $img_array[$i][$j] = imagecreatefromjpeg($oimg['tmp_name']);
                    imagecopy($img_array[$i][$j], $img, 0, 0, $img_x_3 * $j, $img_y_3 * $i, $img_x_3, $img_y_3);
                }
            }

            //画像を3x3に分割した画像をリサイズ
            $img_x_3_2 = $img_x;
            $img_y_3_2 = $img_y;

            //リサイズ後の画像を配列に格納
            $img_array_2 = array();
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $img_array_2[$i][$j] = imagecreatetruecolor($img_x_3_2, $img_y_3_2);
                    imagecopyresampled($img_array_2[$i][$j], $img_array[$i][$j], 0, 0, 0, 0, $img_x_3_2, $img_y_3_2, $img_x_3, $img_y_3);
                }
            }

            //ディレクトリを作成
            $dir = "./data/" . $hash . "/";
            if (!file_exists($dir)) {
                mkdir($dir);
            }

            //画像を3x3に分割した画像をリサイズした画像を保存
            $n = 10;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $n = $n - 1;
                    imagepng($img_array_2[$i][$j], $dir . "split-" . $n . ".jpg");
                }
            }

            //画像を3x3に分割した画像をリサイズした画像をzip圧縮して保存
            $zip = new ZipArchive();
            $zip_name = $dir . "9-split.zip";
            if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
                $n = 9;
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        $zip->addFile($dir . "split-" . $n . ".jpg", "split-" . $n . ".jpg");
                        $n = $n - 1;
                    }
                }
                $zip->close();
            }

            //画像を3x3に分割した画像をリサイズした画像をzip圧縮してダウンロード
            echo "<p>分割が正常に完了しました！<br>以下のZIPファイルのURLから，または画像を長押しして保存し，ご使用ください．</p>";
            echo "<a href='" . $zip_name . "' download='9-split.zip'>ZIPでまとめてダウンロード</a><br>";
            echo "<a href='" . $dir . "split-9.jpg' target='_blank'><img src='" . $dir . "split-9.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-8.jpg' target='_blank'><img src='" . $dir . "split-8.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-7.jpg' target='_blank'><img src='" . $dir . "split-7.jpg' width='10%'></a><br>";
            echo "<a href='" . $dir . "split-6.jpg' target='_blank'><img src='" . $dir . "split-6.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-5.jpg' target='_blank'><img src='" . $dir . "split-5.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-4.jpg' target='_blank'><img src='" . $dir . "split-4.jpg' width='10%'></a><br>";
            echo "<a href='" . $dir . "split-3.jpg' target='_blank'><img src='" . $dir . "split-3.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-2.jpg' target='_blank'><img src='" . $dir . "split-2.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-1.jpg' target='_blank'><img src='" . $dir . "split-1.jpg' width='10%'></a>";
        }

        //mineタイプがimage/pngの場合の関数
        function img_split_png()
        {
            $oimg = $_FILES['img'];
            $img = imagecreatefrompng($oimg['tmp_name']);

            //画像のハッシュ値を取得
            $hash = hash_file('md5', $oimg['tmp_name']);

            //画像を3x3に分割
            $img_x = imagesx($img);
            $img_y = imagesy($img);
            $img_x_3 = $img_x / 3;
            $img_y_3 = $img_y / 3;

            //画像を3x3に分割した画像を配列に格納
            $img_array = array();
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $img_array[$i][$j] = imagecreatefrompng($oimg['tmp_name']);
                    imagecopy($img_array[$i][$j], $img, 0, 0, $img_x_3 * $j, $img_y_3 * $i, $img_x_3, $img_y_3);
                }
            }

            //画像を3x3に分割した画像をリサイズ
            $img_x_3_2 = $img_x;
            $img_y_3_2 = $img_y;

            //リサイズ後の画像を配列に格納
            $img_array_2 = array();
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $img_array_2[$i][$j] = imagecreatetruecolor($img_x_3_2, $img_y_3_2);
                    imagecopyresampled($img_array_2[$i][$j], $img_array[$i][$j], 0, 0, 0, 0, $img_x_3_2, $img_y_3_2, $img_x_3, $img_y_3);
                }
            }

            //ディレクトリを作成
            $dir = "./data/" . $hash . "/";
            if (!file_exists($dir)) {
                mkdir($dir);
            }

            //画像を3x3に分割した画像をリサイズした画像を保存
            $n = 10;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $n = $n - 1;
                    imagepng($img_array_2[$i][$j], $dir . "split-" . $n . ".jpg");
                }
            }

            //画像を3x3に分割した画像をリサイズした画像をzip圧縮して保存
            $zip = new ZipArchive();
            $zip_name = $dir . "9-split.zip";
            if ($zip->open($zip_name, ZipArchive::CREATE) === TRUE) {
                $n = 9;
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        $zip->addFile($dir . "split-" . $n . ".jpg", "split-" . $n . ".jpg");
                        $n = $n - 1;
                    }
                }
                $zip->close();
            }

            //画像を3x3に分割した画像をリサイズした画像をzip圧縮してダウンロード
            echo "<p>分割が正常に完了しました！<br>以下のZIPファイルのURLから，または画像を長押しして保存し，ご使用ください．</p>";
            echo "<a href='" . $zip_name . "' download='9-split.zip'>ZIPでまとめてダウンロード</a><br>";
            echo "<a href='" . $dir . "split-9.jpg' target='_blank'><img src='" . $dir . "split-9.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-8.jpg' target='_blank'><img src='" . $dir . "split-8.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-7.jpg' target='_blank'><img src='" . $dir . "split-7.jpg' width='10%'></a><br>";
            echo "<a href='" . $dir . "split-6.jpg' target='_blank'><img src='" . $dir . "split-6.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-5.jpg' target='_blank'><img src='" . $dir . "split-5.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-4.jpg' target='_blank'><img src='" . $dir . "split-4.jpg' width='10%'></a><br>";
            echo "<a href='" . $dir . "split-3.jpg' target='_blank'><img src='" . $dir . "split-3.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-2.jpg' target='_blank'><img src='" . $dir . "split-2.jpg' width='10%'></a>";
            echo "<a href='" . $dir . "split-1.jpg' target='_blank'><img src='" . $dir . "split-1.jpg' width='10%'></a>";
        }
        ?>
        <p>何か問題があれば，<a href="https://twitter.com/sekaino_usay" target="_blank">U_SAY</a>までご連絡をお願いします．</p>
    </div>
    <footer>
        <small>
            <p>Source code is available on <a href="https://github.com/sekaino-usay/9-splitter" target="_blank">GitHub</a></p>
            <p>Copyright © 2022 <a href=" https://9split.usay05.com">9 Splitter</a> All Rights Reserved.</p>
        </small>
    </footer>
</body>

</html>
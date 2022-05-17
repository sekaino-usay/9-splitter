<?php
//画像が選択されていない場合はエラーを出力
if (empty($_FILES['img']['tmp_name'])) {
    echo '画像が選択されていません';
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
        $n = 10;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $zip->addFile($dir . "split-" . $n . ".jpg", "split-" . $n . ".jpg");
                $n = $n - 1;
            }
        }
        $zip->close();
    }

    //画像を3x3に分割した画像をリサイズした画像をzip圧縮してダウンロード
    echo '<a href="' . $zip_name . '">ダウンロード</a>';
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
        $n = 10;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $zip->addFile($dir . "split-" . $n . ".jpg", "split-" . $n . ".jpg");
                $n = $n - 1;
            }
        }
        $zip->close();
    }

    //画像を3x3に分割した画像をリサイズした画像をzip圧縮してダウンロード
    echo "<a href='" . $zip_name . "' download='" . $zip_name . "'>ダウンロード</a>";
}

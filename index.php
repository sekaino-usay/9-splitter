<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>9 splitter</title>
</head>

<body>
    <form action="./split.php" method="post" enctype="multipart/form-data">
        <input type="file" name="img" accept=".png,.jpg,.jpeg" required>
        <button type="submit">split</button>
    </form>
</body>

</html>
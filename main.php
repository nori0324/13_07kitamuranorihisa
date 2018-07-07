<?php
session_start();

include("functions.php");

//$_SESSION["lid"]の有無を判定（ログインの後か前か判定）
if(!isset($_SESSION["lid"]) || $_SESSION["lid"]=="" ){
  $a = "ゲスト";//ログイン前ならゲスト表記
}else{
  $a = $_SESSION["lid"];//ログイン後なら$_SESSION["lid"]を表記
}

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_an_table");
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
  queryError($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $view .= '<p>';
    // $view .= '<a href="detail.php?id='.$result["id"].'">';
    // $view .= "『";
    // $view .= h($result["bookname"]);
    // $view .= "』";
    // $view .= '</a>　';
    // $view .= '</p>';

    $view .= '<p>';
    $view .= '<a href="detail.php?id='.$result["id"].'">';
    $view .= h($result["bookname"]);
    $view .= '</a>　';
    $view .= '<a href="delete.php?id='.$result["id"].'">';
    $view .= '[削除]';
    $view .= '</a>';
    $view .= '</p>';


  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>メイン</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
  div{padding: 10px;font-size:16px;}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<!-- ログイン前メニュー -->
<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="main.php">メイン</a>
            <a class="navbar-brand" href="new_account.php">新規作成</a>
            <a class="navbar-brand" href="login.php">ログイン</a>
            <!-- <a class="navbar-brand" href="logout.php">ログアウト</a> -->
        </div>
    </nav>
</header>

<!-- Head[End] -->
<!-- ログインの有無により表示する名前を変更 -->
<div><?=$a?>さん、こんにちは</div>

<!-- Main[Start] -->
<div>
  <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>

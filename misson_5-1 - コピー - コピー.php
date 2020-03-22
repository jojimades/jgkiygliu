<html>
<?php
	//編集フォーム
	//編集項目のそれぞれの値を取得
	  $pass="world";
  if ((!empty($_POST["edit"]))&&(!empty($_POST["password3"]))&&
      ($_POST["password3"]==$pass)){
    $number=$_POST["edit"];
//  SELECT CustomerID, CompanyName, City FROM Customers WHERE City = 'London'
//SELECTで指定の列を取得
    //$sql = 'SELECT FROM whatest WHERE id = '$_POST["edit"]'';
    $sql = 'SELECT * FROM yui';
    	//sql内の文字列を取得
	$stmt = $pdo->query($sql);
//配列に変換
	$results = $stmt->fetchAll();//fetchAll:全ての結果行を含む配列を返す
//	var_dump($stmt);
//ループ表示
	foreach ($results as $row){
	if ($row['id']==$_POST["edit"]){
		//$rowの中にはテーブルのカラム名が入る
		$number=$row['id'];
		$name=$row['name'];
		$sentence=$row['comment'];
	}
    }
   }

?>

 <form action="" method="post">
    <input type="hidden" name="id" value="<?php if (!empty($number)) echo $number ?>">
       <p style="margin:0;">
       　　名　前：<input type="text" name="name" size="15" maxlength="20"value="<?php if (!empty($name)) echo $name ?>"></p>
       <p style="margin:0;">
       　コメント：<input type="text" name="sentence" size="15" maxlength="20"value="<?php if (!empty($sentence)) echo $sentence ?>" >
        </p>
       <p style="margin:0;">
       パスワード：<input type="text" name="password1" size="15" maxlength="20"value="">
       <input type="submit" value="送信する">
       </p><hr>
       <p style="margin:0;">
       削除対象番号：<input type="text" name="delete" size="15" maxlength="20"value="">
       　パスワード：<input type="text" name="password2" size="15" maxlength="20"value="">
       <input type="submit" value="削除する">
       </p><hr>
       <p>
       編集対象番号：<input type="text" name="edit" size="15" maxlength="20" value="">
       　パスワード：<input type="text" name="password3" size="15" maxlength="20" value="">
       <input type="submit" value="編集する">
       </p><hr>
</form>

<body>
<?php
//フォーム送信後に確認で表示されるコメント
	$pass="world";
 if((!empty($_POST["sentence"]))&&(!empty($_POST["password1"]))&&($_POST["password1"] == $pass)){
 	 if (!empty($_POST["id"])){
 	    echo "「NO.".htmlspecialchars($_POST["id"],ENT_QUOTES)."」"."を編集しました";
 	 }
 	 else {
       echo "「".htmlspecialchars($_POST["name"],ENT_QUOTES)."さんの".htmlspecialchars($_POST["sentence"],ENT_QUOTES)."」"."を受け付けました";
     }}
  if ((!empty($_POST["delete"]))&&(!empty($_POST["password2"]))&&
      ($_POST["password2"]==$pass)){
       echo "「No.".htmlspecialchars($_POST["delete"],ENT_QUOTES)."」"."を削除しました";
     } 
  if ((!empty($_POST["edit"]))&&(!empty($_POST["password3"]))&&
      ($_POST["password3"]==$pass)){
       echo "「No.".htmlspecialchars($_POST["edit"],ENT_QUOTES)."」"."を編集します";
    }
?><br><br>
------以下、記入内容----------------------------------
</body><br><br>

<body>
<?php
//初期設定ではPDOのデータベース操作で発生したエラーは何も表示されない
	$sql = "CREATE TABLE IF NOT EXISTS what"//IF NOT EXISTSを入れないと２回目以降にこのプログラムを呼び出した際に、既に存在するテーブルがあるためエラー
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"//IDを格納,後ろは設定
	. "name char(100),"//名前を格納
	. "comment TEXT,"//文字を格納
	. "date DATETIME"
	. ");";
//queryで上記のものを実行(12～17)
	$stmt = $pdo->query($sql);//query:SQLクエリ(ソフトウェアに対するデータの問い合わせや要求)

	$pass="world";
//もし、ファイルが存在する・名前・コメント挿入・パスワードあり・パス＝worldなら
 if((!empty($_POST['name']))&&(!empty($_POST['sentence']))&&(!empty($_POST["password1"]))&&($_POST["password1"]==$pass)&&(empty($_POST["id"]))){
 //prepare　　:値部分に文字列を付けて実行待ち
    $sql = $pdo -> prepare("INSERT INTO yui (name, comment, date) VALUES (:name, :comment, :date)");
   
    $datetime = date('Y-m-d H:i:s');
    //var_dump($datetime);
	$sql -> bindParam(':name', $_POST["name"], PDO::PARAM_STR);
	$sql -> bindParam(':comment', $_POST["sentence"], PDO::PARAM_STR);
	$sql -> bindParam(':date', $datetime, PDO::PARAM_STR);
	$sql -> execute();
  }

  //削除項目
 if ((!empty($_POST["delete"]))&&(!empty($_POST["password2"]))&&($_POST["password2"]==$pass)){
    $id = $_POST["delete"];
    	//テーブル内の削除番号を取得
	$sql = 'delete from yui where id=:id';
	   //値部分にパラメータを付けて実行待ち
	$stmt = $pdo->prepare($sql);
	   //bindParam　:与えられた変数を文字列としてパラメータに入れる
       //PDO::PARAM_INT :変数の値を数値として扱う
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	   //execute()　:準備したprepareに入っているSQL文を実行
	$stmt->execute();
  }
  
 //編集コメントを変更させたら
    $pass="world";
 if ((!empty($_POST["id"]))&&(!empty($_POST["password1"]))&&($_POST["password1"]==$pass)){
    $id = $_POST["id"]; //変更する投稿番号
	$name = $_POST["name"];
	$sentence = $_POST["sentence"];
	//$date = new DateTime();
    $datetime = date('Y-m-d H:i:s');
	$sql = 'update yui set date=:date, name=:name,comment=:comment where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $sentence, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':date', $datetime, PDO::PARAM_STR);
	$stmt->execute();
 }

 //select表示
	$sql = 'SELECT * FROM yui';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'　';
        echo $row['date'].'<br>';
    	echo "<hr>";
	}
?>
</body>	
</html>
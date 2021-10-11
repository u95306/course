<?php
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

//查詢【employee】資料表【性別】、【姓名】與【電話】三個欄位的資料
$sql="SELECT 性別,姓名,電話 FROM employee";
$result=mysql_query($sql);

//取得查詢結果的筆數
$total=mysql_num_rows($result);

//使用二維陣列儲存查詢結果
$i=0;
while ($row = mysql_fetch_array($result)) {
  $employee[$i]=$row;
  $i++;
}

//列出女性員工的資料
echo "女性員工資料表<br />
      <table border='1'><tr><td>姓名</td><td>電話</td></tr>";
//以迴圈逐一讀取 $employee[0], $employee[1]... $employee[$total-1]
for ($i=0; $i<$total; $i++){
  if ($employee[$i]['性別']=='女'){
    echo "<tr><td>{$employee[$i]['姓名']}</td>
              <td>{$employee[$i]['電話']}</td></tr>";
  }
}
echo '</table>';

//列出男性員工的資料
echo "<br />男性員工資料表<br />
      <table border='1'><tr><td>姓名</td><td>電話</td></tr>";
for ($i=0; $i<$total; $i++){
  if ($employee[$i]['性別']=='男'){
    echo "<tr><td>{$employee[$i]['姓名']}</td>
              <td>{$employee[$i]['電話']}</td></tr>";
  }
}
echo '</table>';
?>

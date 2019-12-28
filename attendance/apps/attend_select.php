<?php
//引入公共文件
require("./conn.php");

// 获取考勤数
$var=mysqli_fetch_assoc(mysqli_query($conn, "select sum_all from var"));
$sum=$var['sum_all'];
echo "当前考勤数为：".$sum;

$sql = "select * from staff_temp order by dept,jobnum";
$res = mysqli_query($conn, $sql);
//建立一个空数组
$data = array();
//执行循环
while($row = mysqli_fetch_assoc($res)){
     $data[] = $row;
}
//引入列表页面
require("../views/attend_select.html");
?>
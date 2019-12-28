<?php

//引入公共文件
require("./conn.php");

// 考勤数sum_all+1
mysqli_query($conn, "update var set sum_all=sum_all+1;");

// 获取考勤数
$var=mysqli_fetch_assoc(mysqli_query($conn, "select sum_all from var"));
$sum=$var['sum_all'];
echo "当前考勤数为：".$sum;

// 创建临时表选择考勤职工
mysqli_query($conn, "drop table if exists staff_temp");
mysqli_query($conn, "create table staff_temp as select * from staff_info");

// 获取临时表数据
$res = mysqli_query($conn, "select * from staff_temp order by dept,jobnum");
//建立一个空数组
$data = array();
while($row = mysqli_fetch_assoc($res)){
     $data[] = $row;
}

//引入列表页面
require("../views/attend_select.html");

?>

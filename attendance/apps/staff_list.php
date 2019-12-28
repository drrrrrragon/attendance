<?php
//引入公共文件
require("./conn.php");
//查询语句
$sql = "select * from staff_info order by dept,jobnum";
//执行语句
$res = mysqli_query($conn, $sql);
//建立一个空数组
$data = array();
//执行循环
while($row = mysqli_fetch_assoc($res)){
     $data[] = $row;
}
//引入列表页面
require("../views/staff_list.html");
?>
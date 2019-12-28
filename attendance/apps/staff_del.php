<?php

header("Content-Type: text/html;charset=utf-8");
//引入公共文件
require("./conn.php");
//获取删除数据ID
$id = $_GET[id];
//删除语句
$sql = "delete from staff_info where jobnum=$id;";
$sql .= "delete from attend_score where jobnum=$id";
//执行语句
$res = mysqli_multi_query($conn, $sql);
//判断
if($res){
   echo "<script>window.location='./staff_list.php'</script>";
}else{
   die("连接错误：".mysqli_connect_error());	
}

?>
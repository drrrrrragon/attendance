<?php

header("Content-Type: text/html;charset=utf-8");
//引入公共文件
require("./conn.php");

//获取删除数据ID
$id = $_GET[id];

// 获取当前考勤序号
$var=mysqli_fetch_assoc(mysqli_query($conn, "select sum_all from var"));
$sum=$var['sum_all'];

// 删除职工，默认通过
$sql = "delete from staff_temp where jobnum='$id';";
$sql .= "insert into attend_record values ('$id', '$sum', '通过')";
$res = mysqli_multi_query($conn, $sql);

//判断
if($res){
   echo "<script>window.location='./attend_select.php'</script>";
}else{
   die("连接错误：".mysqli_connect_error());	
}

?>
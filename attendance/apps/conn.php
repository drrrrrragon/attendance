<?php
//链接数据库
$conn = mysqli_connect("localhost", "root", null, "attendance"); 
//判断错误函数
if(!$conn){
die('连接Mysql失败:'.mysqli_connect_error());
}

//设定字符集编码
mysqli_set_charset($conn, 'utf8');

?>
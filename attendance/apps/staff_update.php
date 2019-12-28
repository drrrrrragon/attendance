<?php
//引入公共文件
require("./conn.php");
//获取删除数据ID
$id = $_GET[id];
 
if(empty($_POST)){
   //查询语句
   $sql = "select * from staff_info where jobnum=$id";
   //执行语句
   $res = mysqli_query($conn, $sql);
   //放入数组
   $arr = mysqli_fetch_assoc($res);
   //引入修改页面
   require("../views/staff_update.html");
}else{
   //更新语句
   $sql =  "update staff_info set jobnum='$_POST[jobnum]',name='$_POST[name]',dept='$_POST[dept]',depthead='$_POST[depthead]' where jobnum=$id;";
   $sql .=  "update attend_score set jobnum='$_POST[jobnum]' where jobnum=$id";
   //执行语句
   $res = mysqli_multi_query($conn, $sql);

   //判断结果
   if($res){
      echo "<script>window.location='./staff_list.php'</script>";
   }else{
      die("连接错误：".mysqli_connect_error());	
   }
}
?>
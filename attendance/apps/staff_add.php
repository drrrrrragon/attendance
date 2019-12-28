<?php
//引入公共文件
require("./conn.php");
 
if(empty($_POST)){
  //引入数据添加静态页面
  require("../views/staff_add.html");
}else{
  //获取表单值
  $jobnum = $_POST['jobnum'];
  $name = $_POST['name'];
  $dept = $_POST['dept'];
  $depthead =$_POST['depthead'];
  //插入数据库语句
  $sql = "insert into staff_info (jobnum,name,dept,depthead) values ('$jobnum','$name','$dept','$depthead');";
  $sql .= "insert into attend_score (jobnum) values ('$jobnum')";
  //执行数据
  $res = mysqli_multi_query($conn, $sql);
  //判断结果
  if($res){
      echo "<script>window.location='./staff_list.php'</script>";
  }else{
     die("连接错误：".mysqli_connect_error());	
 }
}

?>
<?php
//引入公共文件
require("./conn.php");

// 获取考勤数
$var=mysqli_fetch_assoc(mysqli_query($conn, "select sum_all from var"));
$sum=$var['sum_all'];
echo "当前考勤数为：".$sum."<br>";


/***************************
 * 获取所选名单考勤结果
 * *************************/
$sql1 = "select staff_temp.jobnum,name,dept,depthead,sum_fail,score
from staff_temp,attend_score 
where staff_temp.jobnum=attend_score.jobnum 
order by dept,staff_temp.jobnum";
$res1 = mysqli_query($conn, $sql1);
//建立一个空数组
$data1 = array();
//执行循环
while($row1 = mysqli_fetch_assoc($res1)){
     $data1[] = $row1;
}


/***********************************
 * 获取全部名单考勤结果
 * *********************************/
$sql2 = "select staff_info.jobnum,name,dept,depthead,sum_fail,score
from staff_info,attend_score 
where staff_info.jobnum=attend_score.jobnum 
order by dept,staff_info.jobnum";
$res2 = mysqli_query($conn, $sql2);
$data2 = array();$num=array();
while($row2 = mysqli_fetch_assoc($res2)){
     $data2[] = $row2;
}

/***************************
 * 获取所有考勤记录
 * *************************/
mysqli_query($conn,"drop table if exists t");
mysqli_query($conn,"create table t (
     select staff_info.jobnum as id,name,dept,depthead,number,state
     from attend_record,staff_info
     where attend_record.jobnum=staff_info.jobnum
     order by dept,staff_info.jobnum,number)");
$sql3 = "select id,name,dept,depthead,
group_concat(number) as num,group_concat(state) as state
from t
group by id
order by dept,id";
$res3 = mysqli_query($conn, $sql3);
$data3 = array();
while($row3 = mysqli_fetch_assoc($res3)){
     $data3[] = $row3;
}
mysqli_query($conn,"drop table if exists t");

//引入列表页面
require("../views/attend_attendance.html");

?>

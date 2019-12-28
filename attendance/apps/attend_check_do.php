<?php

header("Content-Type: text/html;charset=utf-8");
//引入公共文件
require("./conn.php");

// 获取考勤数
$var=mysqli_fetch_assoc(mysqli_query($conn, "select sum_all from var"));
$sum=$var['sum_all'];


/***********************************************************
 * 签到记录,表单的attend和考勤的data的比较
 ***********************************************************/
// 获取签到表单
$attend=$_POST['attend'];
// 获取考勤职工
$res = mysqli_query($conn,"select jobnum from staff_temp order by dept, jobnum");
$data = array();
while($row = mysqli_fetch_assoc($res)){
     $data[] = $row['jobnum'];
}
// 签到记录,attend中有的签通过，attend中没有的签不通过；
for($i=0;$i< count($data);$i++) {
     $flag=0;
     for($j=0;$j<count($attend);$j++){
          if($data[$i]==$attend[$j]){
               mysqli_query($conn, "insert into attend_record values ('$data[$i]', '$sum', '通过')");
               array_splice($attend, $j, 1);
               $flag=1;
               break;
          }
     }
     if($flag==0)
          mysqli_query($conn, "insert into attend_record values ('$data[$i]', '$sum', '不通过')");
}


/*********************************************************
 * 连续三次考勤不通过score=0
 * 累计考勤不通过数大于5，score=0
 *********************************************************/
// 获取所有职工工号
$res2 = mysqli_query($conn, "select jobnum from staff_info order by jobnum");
$num=array();
while($row2 = mysqli_fetch_assoc($res2)){
     $num[]=$row2['jobnum'];
}
// 连续三次考勤不通过score=0
for($i=0;$i<count($num);$i++){
     mysqli_query($conn, " update attend_score 
     set score=0
     where not exists(
          select * 
          from (
                    select * from attend_record
                    where jobnum='$num[$i]'
                    order by number  desc
                    limit 3
          ) t
     where state='通过'
     ) and jobnum='$num[$i]'");
}
// 累计考勤不通过数大于5，score=0
mysqli_query($conn, "update attend_score set score=0 where sum_fail>=5");


// 跳转到查看考勤结果
echo "<script>window.location='./attend_attendance.php'</script>";

?>

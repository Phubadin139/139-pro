<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <h1>ฟังค์ชั่นที่สร้างขึ้นเอง</h1>
     <?php
     // เรียกใช้ฟังก์ชัน sum()
     echo "ผลบวกของ 10 และ 20 คือ " . sum(10, 20) . "<br>";
     echo "ผลบวกของ 15 และ 25 คือ " . sum(15, 25) . "<br>";

     // ทดสอบ add_five()
     $num = 50;
     echo "<br>";
     echo "ค่าของ num ก่อนเรียกใช้ฟังค์ชั่น add_five() คือ $num<br>";

     $new_value = add_five($num);

     echo "ค่าของ num หลังเรียกใช้ฟังค์ชั่น add_five() คือ $new_value<br>";
     ?>

     <h2>ฟังค์ชั่นที่มพารามิเตอร์หลายตัว</h2>
     <?php
     function sumListofnumber(...$x) {
        $n = 0;
        $len = count($x);
        for ($i = 0; $i < $len; $i++) {
            $n += $x[$i];
     }
     return $n;
    }
    //เรียกใช้ฟังค์ชั่น sumListofnumber
    echo "ผลบวกของเลข 5,10,15 คือ ". sumListofnumber(5,10,15) ."<br>";
     echo "ผลบวกของเลข 1,2,3,4,5,6,7,8,9,10 คือ ". sumListofnumber(1,2,3,4,5,6,7,8,9,10) ."<br>";


     //สร้างฟังค์ชั่นรับนาสกุลและชื่อหลายคน
     function Myfamily($lastname, ...$firstname) {
$len = count ($firstname);
for ($i = 0; $i < $len; $i++) {
    echo" สวัสดีคุณ ". $firstname[$i]. "" .$lastname. "<br>";

     }

    }
    //เรียกใช้function Myfamily
    Myfamily( "สวยใส","สมชัย","john", "tah", "jee");
     ?>

    <h2>ตัวอย่างฟังค์ชั่นที่มีพรามิเตอร์เริ่มต้น</h2>
    <?php
    function thai_date($strDate="now"  ) {
        $strYear = date("Y",strtotime($strDate))+  543;
        $strMonth = date("n",strtotime($strDate));
        $strDay = date("j",strtotime($strDate));

        $thaiMonthNames = ["", "มกราคม", "กุมภา", "มีนา", "เมษา", "พฤษภา", "มิถุนา", "กรกฏา",
                             "สิงหา", "กันยา", "ตุลา", "พฤษจิ", "ธันวา"];
        $strMonthThai = $thaiMonthNames[$strMonth];
        return "$strDay $strMonthThai พ.ศ $strYear";
    }
    echo thai_date("2025/12/11"). "<br>";
    echo thai_date();
    
    ?>
      
</body>
</html>

<?php
function sum($sum1, $sum2) {
    return $sum1 + $sum2;
}

function add_five($num) {
    $value = $num + 5;
    echo "ค่าภายในฟังค์ชั่น add_five() คือ $value<br>";
    return $value;   // ส่งค่ากลับไปเก็บใน $new_value
}
?>

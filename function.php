<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟังค์ชั่นที่มีพร้อมใช้ใน php</title>
</head>
<body>
    <h1>PHP built-in function ฟังค์ชั่นที่มีพร้อมใช้ใน PHP</h1>

    <h2>ทดสอบการใช้ function date()</h2>
    <?php
        echo "วันนี้วันที่ " . date("d/m/Y") . "<br>";
        echo "เวลาปัจจุบัน " . date("H:i:sa") . "<br>";
        echo "วันนี้เป็นวัน " . date("l") . "<br>";
    ?>


    <h2>ทดสอบการใช้ฟังค์ชั่น date_diff()</h2>
    <?php
        $date1 = date_create("2006-02-14");
        $date2 = date_create("2000-01-01");
        $diff = date_diff($date1, $date2);

        echo "จำนวนวันระหว่างวันที่ 1 มกราคม 2000 ถึง 14 กุมภาพันธ์ 2006 = "
             . $diff->days . " วัน<br>";

        echo "หรือเท่ากับ "
             . $diff->y . " ปี, "
             . $diff->m . " เดือน, "
             . $diff->d . " วัน<br>";
    ?>


    <h2>ทดสอบการใช้ฟังค์ชั่นทางคณิตศาสตร์</h2>
    <?php
        $num1 = 10.3;
        $num2 = 15.7;
        $pi = 3.14150;

        echo "ค่าปัดขึ้นของ num1 คือ " . ceil($num1) . "<br>";
        echo "ค่าปัดลงของ num2 คือ " . floor($num2) . "<br>";
        echo "ค่าของ pi ปัดขึ้นทศนิยม 2 ตำแหน่งคือ " . round($pi, 2) . "<br>";
        echo "ค่าของ pi คือ " . pi() . "<br>";
        echo "ค่ายกกำลัง 3 ของ 5 คือ " . pow(5, 3) . "<br>";
        echo "ค่ารากที่สองของ 49 คือ " . sqrt(49) . "<br>";
        echo "ค่าสุ่มระหว่าง 1 - 100 คือ " . rand(1, 100) . "<br>";
        echo "ค่าสุ่มระหว่าง 50 - 150 คือ " . rand(50, 150) . "<br>";
        echo "ค่าสุ่มคือ " . rand() . "<br>";

        $arr = array(3, 5, 1, 8, 2);
        echo "ค่าสูงสุดใน array คือ " . max($arr) . "<br>";
        echo "ค่าต่ำสุดใน array คือ " . min($arr) . "<br>";
    ?>


    <h2>ทดสอบการใช้ string function</h2>
    <?php
        $str = "hello php function";

        echo "ความยาวของ string str คือ " . strlen($str) . " ตัวอักษร<br>";
        echo "สตริง '$str' เมื่อแปลงเป็นตัวพิมพ์ใหญ่ทั้งหมดคือ " . strtoupper($str) . "<br>";
        echo "สตริง '$str' เมื่อแปลงเป็นตัวพิมพ์เล็กทั้งหมดคือ " . strtolower($str) . "<br>";
        echo "สตริง '$str' เมื่อแปลงเป็นตัวพิมพ์ใหญ่ตัวแรกคือ " . ucfirst($str) . "<br>";
        echo "สตริง '$str' เมื่อแปลงเป็นตัวพิมพ์ใหญ่ทุกคำคือ " . ucwords($str) . "<br>";

        // ค้นหาคำว่า PHP
        $substr = "php";
        echo "ตำแหน่งของคำว่า '$substr' ใน string คือ " . strpos(strtolower($str), $substr) . "<br>";

        // แทนที่คำ
        $replace = str_replace("function", "ฟังค์ชั่น", $str);
        echo "เมื่อแทนที่คำว่า 'function' ด้วย 'ฟังค์ชั่น' จะได้สตริงใหม่คือ '$replace'<br>";

        $str2 = "  PHP      Function    WITH   SPACEs    ";
        echo "สตริงก่อนลบช่องว่างด้านหน้าและหลัง: '$str2'<br>";
        echo "สตริงหลังลบช่องว่างด้านหน้าและหลัง: '" . trim($str2) . "'<br>";
    ?>

    <?php myFooter("โรนัลโด้"); ?>

</body>
</html>

<?php
function myFooter( $โรนัลโด้) {
    echo "<footer><br>";
    echo "<p>PHP built-in Function Example &copy; 2024</p>";
    echo "<p>สร้างโดย : Phubadin Surachon</p>";
    echo "</footer>";
}
?>

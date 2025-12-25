<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนอบรม</title>
    <style>
        /* ตกแต่ง UI พื้นฐาน */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
            margin-bottom: 30px;
        }
        h2, h3 {
            color: #2c3e50;
            text-align: center;
        }
        /* ตกแต่งฟอร์ม */
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box; /* ป้องกันขนาดเพี้ยน */
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        /* ตกแต่งผลลัพธ์การลงทะเบียน */
        .success-box {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #d6e9c6;
            margin-bottom: 20px;
        }
        /* ตกแต่งตาราง */
        table {
            width: 100%;
            max-width: 900px;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        th {
            background-color: #34495e;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        // --- ส่วนที่ 2: โค้ดรับค่าจากฟอร์ม และ ประมวลผล ---
        if (isset($_POST['submit'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $course = $_POST['course'];
            $type = $_POST['type'];

            // อาหาร (Checkbox)
            if (isset($_POST['food'])) {
                $food = implode(", ", $_POST['food']);
            } else {
                $food = "ไม่ระบุ";
            }

            // คำนวณค่าลงทะเบียน
            $price = ($type == "Onsite") ? 1500 : 800;

            // บันทึกลงไฟล์
            $data = $fullname . "|" . $email . "|" . $course . "|" . $food . "|" . $type . "|" . $price . "\n";
            file_put_contents("register.txt", $data, FILE_APPEND);

            // แสดงผลหลังกดปุ่ม
            echo "<div class='success-box'>";
            echo "<strong>ลงทะเบียนสำเร็จ!</strong><br>";
            echo "คุณ: $fullname | รูปแบบ: $type | ค่าใช้จ่าย: " . number_format($price, 2) . " บาท";
            echo "</div>";
        }
        ?>

        <h2>ฟอร์มลงทะเบียนอบรม</h2>
        <form method="post" action="">
            ชื่อ-นามสกุล:
            <input type="text" name="fullname" placeholder="ชื่อจริง-นามสกุล" required>

            Email:
            <input type="email" name="email" placeholder="example@mail.com" required>

            หัวข้ออบรม:
            <select name="course">
                <option value="AI สำหรับงานสำนักงาน">AI สำหรับงานสำนักงาน</option>
                <option value="Excel สำหรับการทำงาน">Excel สำหรับการทำงาน</option>
                <option value="การเขียนเว็บด้วย PHP">การเขียนเว็บด้วย PHP</option>
            </select>

            อาหารที่ต้องการ:<br>
            <label><input type="checkbox" name="food[]" value="ปกติ"> ปกติ</label>
            <label><input type="checkbox" name="food[]" value="มังสวิรัติ"> มังสวิรัติ</label>
            <label><input type="checkbox" name="food[]" value="ฮาลาล"> ฮาลาล</label>
            <br><br>

            รูปแบบการเข้าร่วม:<br>
            <label><input type="radio" name="type" value="Onsite" required> Onsite (1,500.-)</label>
            <label><input type="radio" name="type" value="Online"> Online (800.-)</label>
            <br><br>

            <button type="submit" name="submit">ลงทะเบียนเข้าร่วมอบรม</button>
        </form>
    </div>

    <h3>รายชื่อผู้ลงทะเบียนทั้งหมด</h3>
    <?php
    if (file_exists("register.txt")) {
        $lines = file("register.txt");
        echo "<table>";
        echo "<tr>
                <th>ชื่อ</th>
                <th>Email</th>
                <th>หัวข้อ</th>
                <th>อาหาร</th>
                <th>รูปแบบ</th>
                <th>ราคา</th>
              </tr>";

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (!empty($trimmed)) {
                list($_name, $_email, $_course, $_food, $_type, $_price) = explode("|", $trimmed);
                echo "<tr>
                        <td>$_name</td>
                        <td>$_email</td>
                        <td>$_course</td>
                        <td>$_food</td>
                        <td>$_type</td>
                        <td>" . number_format($_price, 2) . "</td>
                      </tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p>ยังไม่มีข้อมูลผู้ลงทะเบียน</p>";
    }
    ?>
    
</body>
</html>
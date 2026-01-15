<?php
/* ====== PDO CONNECT ====== */
$host = "localhost";
$dbname = "db_it67";
$user = "root";
$pass = "";

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("เชื่อมต่อไม่สำเร็จ: " . $e->getMessage());
}

/* ===== ลบข้อมูล ===== */
if (isset($_GET['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: show_users_pdo.php");
    exit;
}

/* ===== ตัวแปรแก้ไข ===== */
$editData = null;

/* ===== ดึงข้อมูลมาแก้ไข ===== */
if (isset($_GET['edit_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ===== เพิ่ม / อัปเดต ===== */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        $_POST['name'],
        $_POST['sex'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['birthday']
    ];

    if (!empty($_POST['id'])) {
        $data[] = $_POST['id'];
        $sql = "UPDATE users SET
                name = ?, sex = ?, phone = ?, email = ?, birthday = ?
                WHERE id = ?";
    } else {
        $sql = "INSERT INTO users (name, sex, phone, email, birthday)
                VALUES (?, ?, ?, ?, ?)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    header("Location: show_users_pdo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ระบบจัดการผู้ใช้ (PDO)</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">

<h3 class="text-center text-primary mb-4">ระบบจัดการผู้ใช้ (PDO)</h3>

<!-- ===== ตาราง ===== -->
<table class="table table-bordered table-hover text-center">
<thead class="table-primary">
<tr>
<th>ID</th><th>ชื่อ</th><th>เพศ</th><th>โทร</th><th>Email</th><th>วันเกิด</th><th>จัดการ</th>
</tr>
</thead>
<tbody>
<?php
$stmt = $conn->query("SELECT * FROM users");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>
<td><?= $row['sex'] ?></td>
<td><?= $row['phone'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['birthday'] ?></td>
<td>
<a href="show_users_pdo.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
<a href="show_users_pdo.php?delete_id=<?= $row['id'] ?>"
   onclick="return confirm('ยืนยันการลบ?')"
   class="btn btn-danger btn-sm">ลบ</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>

<!-- ===== ฟอร์ม ===== -->
<div class="card mt-4">
<div class="card-header bg-primary text-white">
<?= $editData ? 'แก้ไขผู้ใช้' : 'เพิ่มผู้ใช้ใหม่' ?>
</div>

<div class="card-body">
<form method="post">
<input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

<div class="mb-2">
<label>ชื่อ</label>
<input type="text" name="name" class="form-control" required
       value="<?= $editData['name'] ?? '' ?>">
</div>

<div class="mb-2">
<label>เพศ</label>
<select name="sex" class="form-select">
<option value="ชาย" <?= ($editData['sex'] ?? '')=='ชาย'?'selected':'' ?>>ชาย</option>
<option value="หญิง" <?= ($editData['sex'] ?? '')=='หญิง'?'selected':'' ?>>หญิง</option>
</select>
</div>

<div class="mb-2">
<label>โทร</label>
<input type="text" name="phone" class="form-control"
       value="<?= $editData['phone'] ?? '' ?>">
</div>

<div class="mb-2">
<label>Email</label>
<input type="email" name="email" class="form-control"
       value="<?= $editData['email'] ?? '' ?>">
</div>

<div class="mb-3">
<label>วันเกิด</label>
<input type="date" name="birthday" class="form-control"
       value="<?= $editData['birthday'] ?? '' ?>">
</div>

<button class="btn btn-success">บันทึก</button>
<?php if ($editData) { ?>
<a href="show_users_pdo.php" class="btn btn-secondary ms-2">ยกเลิก</a>
<?php } ?>
</form>
</div>
</div>

</div>
</body>
</html>

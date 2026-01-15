<?php
include 'db_connect.php';

/* ===== ลบข้อมูล ===== */
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: users.php");
    exit;
}

/* ===== ตัวแปรแก้ไข ===== */
$editData = null;

/* ===== ดึงข้อมูลมาแก้ไข ===== */
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $editData = $result->fetch_assoc();
}

/* ===== เพิ่ม / อัปเดต ===== */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE users SET
                name='$name',
                sex='$sex',
                phone='$phone',
                email='$email',
                birthday='$birthday'
                WHERE id=$id";
    } else {
        $sql = "INSERT INTO users (name, sex, phone, email, birthday)
                VALUES ('$name','$sex','$phone','$email','$birthday')";
    }

    $conn->query($sql);
    header("Location: users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ระบบจัดการผู้ใช้</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    background-color: #f5f7fb;
  }
</style>
</head>

<body>
<div class="container mt-5">

  <h3 class="text-center fw-semibold text-primary mb-4">
    <i class="bi bi-people-fill me-1"></i>
    ระบบจัดการผู้ใช้
  </h3>

<!-- ===== ตาราง ===== -->
<div class="card shadow-sm mb-4">
  <div class="card-header bg-gradient bg-primary text-white fw-bold">
  <i class="bi bi-table"></i> รายชื่อผู้ใช้ในระบบ
</div>

 <div class="card-body table-responsive p-0">
  <table class="table table-hover align-middle mb-0">
    <thead class="table-primary text-center">
      <tr>
        <th>ID</th>
        <th>ชื่อ</th>
        <th>เพศ</th>
        <th>โทร</th>
        <th>Email</th>
        <th>วันเกิด</th>
        <th>จัดการ</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $result = $conn->query("SELECT * FROM users");
      while ($row = $result->fetch_assoc()) {
      ?>
        <tr>
          <td class="text-center"><?= $row['id'] ?></td>
          <td><?= $row['name'] ?></td>
          <td class="text-center"><?= $row['sex'] ?></td>
          <td><?= $row['phone'] ?></td>
          <td><?= $row['email'] ?></td>
          <td class="text-center"><?= $row['birthday'] ?></td>
          <td class="text-center">
            <a href="users.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
              แก้ไข
            </a>
            <button class="btn btn-danger btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#deleteModal"
              data-id="<?= $row['id'] ?>"
              data-name="<?= $row['name'] ?>"
              data-sex="<?= $row['sex'] ?>"
              data-phone="<?= $row['phone'] ?>"
              data-email="<?= $row['email'] ?>"
              data-birthday="<?= $row['birthday'] ?>">
              ลบ
            </button>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ===== ฟอร์ม ===== -->
<div class="card shadow-sm border-0">
  <div class="card-header bg-primary text-white fw-semibold">
    <i class="bi <?= $editData ? 'bi-pencil-square' : 'bi-person-plus' ?>"></i>
    <?= $editData ? 'แก้ไขผู้ใช้' : 'เพิ่มผู้ใช้ใหม่' ?>
  </div>

  <div class="card-body">
    <form method="post">
      <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">ชื่อ</label>
          <input type="text" name="name" class="form-control"
                 value="<?= $editData['name'] ?? '' ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">เพศ</label>
          <select name="sex" class="form-select">
            <option value="ชาย" <?= (isset($editData) && $editData['sex']=='ชาย')?'selected':'' ?>>ชาย</option>
            <option value="หญิง" <?= (isset($editData) && $editData['sex']=='หญิง')?'selected':'' ?>>หญิง</option>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">เบอร์โทร</label>
          <input type="text" name="phone" class="form-control"
                 value="<?= $editData['phone'] ?? '' ?>">
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Email</label>
          <input type="email" name="email" class="form-control"
                 value="<?= $editData['email'] ?? '' ?>">
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">วันเกิด</label>
          <input type="date" name="birthday" class="form-control"
                 value="<?= $editData['birthday'] ?? '' ?>">
        </div>
      </div>

      <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save"></i>
        <?= $editData ? 'อัปเดตข้อมูล' : 'บันทึกข้อมูล' ?>
      </button>

      <?php if ($editData) { ?>
        <a href="users.php" class="btn btn-outline-secondary ms-2">
          ยกเลิก
        </a>
      <?php } ?>
    </form>
  </div>
</div>


</div>

<!-- ===== Modal ลบ (แสดงข้อมูลครบ) ===== -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="fw-bold text-danger">คุณกำลังจะลบข้อมูลผู้ใช้ต่อไปนี้</p>
        <ul class="list-group">
          <li class="list-group-item"><strong>ชื่อ:</strong> <span id="d_name"></span></li>
          <li class="list-group-item"><strong>เพศ:</strong> <span id="d_sex"></span></li>
          <li class="list-group-item"><strong>เบอร์โทร:</strong> <span id="d_phone"></span></li>
          <li class="list-group-item"><strong>Email:</strong> <span id="d_email"></span></li>
          <li class="list-group-item"><strong>วันเกิด:</strong> <span id="d_birthday"></span></li>
        </ul>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">ยืนยันลบ</a>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
  const btn = event.relatedTarget;

  document.getElementById('d_name').innerText = btn.getAttribute('data-name');
  document.getElementById('d_sex').innerText = btn.getAttribute('data-sex');
  document.getElementById('d_phone').innerText = btn.getAttribute('data-phone');
  document.getElementById('d_email').innerText = btn.getAttribute('data-email');
  document.getElementById('d_birthday').innerText = btn.getAttribute('data-birthday');

  document.getElementById('confirmDeleteBtn').href =
    'users.php?delete_id=' + btn.getAttribute('data-id');
});
</script>

</body>
</html>
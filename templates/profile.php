<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'head.php'?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">โปรไฟล์ผู้ใช้</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>ชื่อ-นามสกุล:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($user['full_name']) ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>อีเมล:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($user['email']) ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>เพศ:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($user['gender']) ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>วันเกิด:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($user['birth_date']) ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>เบอร์โทรศัพท์:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($user['phone_number']) ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>สถานะ:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>วันที่สมัคร:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>


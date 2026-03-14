<?php
global $conn;

$reg_id = isset($_GET['reg_id']) ? intval($_GET['reg_id']) : 0;
$status = $_GET['status'] ?? '';
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

if ($reg_id && $status && $event_id) {
    $stmt = $conn->prepare("UPDATE registrations SET reg_status = ? WHERE reg_id = ?");
    $stmt->bind_param("si", $status, $reg_id);

    if ($stmt->execute()) {
        header("Location: /manage_registrations?id=" . $event_id);
        exit;
    }
}

echo "<script>window.history.back();</script>";
exit;

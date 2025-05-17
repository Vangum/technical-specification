<?php
require_once '../config/connect.php';

$full_name = $_POST['full_name'];
$department = $_POST['department'] ?? '';
$birth_date = $_POST['birth_date'];
$post = $_POST['post'];
$phone = $_POST['phone'];
$entry_time = $_POST['entry_time'];
$exit_time = $_POST['exit_time'];
$remark = $_POST['remark'] ?? null;

$doc_type = $_POST['doc_type'];

$sql = "INSERT INTO visitors (full_name, department, birth_date, post, phone, entry_time, exit_time, remark) VALUES (:full_name, :department, :birth_date, :post, :phone, :entry_time, :exit_time, :remark)";
$stmt = $pdo->prepare($sql);

try {
    $pdo->beginTransaction();

    $stmt->execute([
        ':full_name' => $full_name,
        ':department' => $department,
        ':birth_date' => $birth_date,
        ':post' => $post,
        ':phone' => $phone,
        ':entry_time' => $entry_time,
        ':exit_time' => $exit_time,
        ':remark' => $remark
    ]);

    $visitor_id = $pdo->lastInsertId();
    $doc_name = null;

    switch ($doc_type) {
        case 'passport':
            $doc_name = 'Паспорт';
            break;
        case 'license':
            $doc_name = 'Водительское удостоверение';
            break;
        case 'other':
            $doc_name = $_POST['other_name'] ?? 'Прочее';
            break;
    }

    $doc = [
        'visitor_id' => $visitor_id,
        'doc_type' => $doc_type,
        'doc_name' => $doc_name,
        'passport_series' => null,
        'passport_number' => null,
        'passport_issue_date' => null,
        'passport_issued_by' => null,
        'passport_unit_code' => null,
        'license_series_number' => null,
        'license_issue_date' => null,
        'license_region' => null,
        'license_issued_by' => null,
        'other_series_number' => null,
        'other_issue_date' => null,
        'other_issued_by' => null,
    ];

    switch ($doc_type) {
        case 'passport':
            $doc['passport_series'] = $_POST['passport_series'] ?? null;
            $doc['passport_number'] = $_POST['passport_number'] ?? null;
            $doc['passport_issue_date'] = $_POST['passport_issue_date'] ?? null;
            $doc['passport_issued_by'] = $_POST['passport_issued_by'] ?? null;
            $doc['passport_unit_code'] = $_POST['unit_code'] ?? null;
            break;
        case 'license':
            $doc['license_series_number'] = $_POST['license_number'] ?? null;
            $doc['license_issue_date'] = $_POST['license_issue_date'] ?? null;
            $doc['license_region'] = $_POST['region'] ?? null;
            $doc['license_issued_by'] = $_POST['license_issued_by'] ?? null;
            break;
        case 'other':
            $doc['other_series_number'] = $_POST['other_number'] ?? null;
            $doc['other_issue_date'] = $_POST['other_issue_date'] ?? null;
            $doc['other_issued_by'] = $_POST['other_issued_by'] ?? null;
            break;
        default:
            break;
    }

    $sqlDoc = "INSERT INTO documents (visitor_id, doc_type, doc_name, passport_series, passport_number, passport_issue_date, passport_issued_by, passport_unit_code, license_series_number, license_issue_date, license_region, license_issued_by, other_series_number, other_issue_date, other_issued_by) VALUES (:visitor_id, :doc_type, :doc_name, :passport_series, :passport_number, :passport_issue_date, :passport_issued_by, :passport_unit_code, :license_series_number, :license_issue_date, :license_region, :license_issued_by, :other_series_number, :other_issue_date, :other_issued_by) ";

    $stmt = $pdo->prepare($sqlDoc);
    $stmt->execute($doc);

    $pdo->commit();

    header("location: ../index.php");
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}

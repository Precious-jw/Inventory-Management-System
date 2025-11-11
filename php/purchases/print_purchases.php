<?php

session_start();
include("../../config/db_conn.php");
require_once '../../vendor/autoload.php';

// filepath: e:\wamp64\www\IMS\php\sales\print_sales.php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM purchases WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    // ...build your PDF for just this row...

    // Build HTML table
    $html = '<h2>All Purchases</h2>
    <table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Entered by</th>
                <th>Purchases Description</th>
                <th>Quantity</th>
                <th>Purchase Cost</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>';

    $num = 1;
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
            <td>' . $num++ . '</td>
            <td>' . htmlspecialchars($row['entered_by']) . '</td>
            <td>' . htmlspecialchars($row['descr']) . '</td>
            <td>' . $row['qty'] . '</td>
            <td>&#8358;' . number_format($row['amount']) . '</td>
            <td>' . date('d-M-Y, D H:i A', strtotime($row['date'])) . '</td>
        </tr>';
    }
    $html .= '</tbody></table>';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('purchase-table.pdf', 'I'); // 'I' for inline view, 'D' for download
} else {
    // ...Code to print all rows...
    $conditions = [];
    $params = [];
    $types = "";

    if (!empty($_GET['dateFrom'])) {
        $conditions[] = "date >= ?";
        $params[] = $_GET['dateFrom'];
        $types .= "s";
    }

    if (!empty($_GET['dateTo'])) {
        $conditions[] = "date < ? + INTERVAL 1 DAY";
        $params[] = $_GET['dateTo'];
        $types .= "s";
    }

    $sql = "SELECT *, purchases.id as purchases_id FROM purchases";
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Build HTML table
    $html = '<h2>All Purchases</h2>
    <table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Entered by</th>
                <th>Purchases Description</th>
                <th>Quantity</th>
                <th>Purchase Cost</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>';

    $num = 1;
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
            <td>' . $num++ . '</td>
            <td>' . htmlspecialchars($row['entered_by']) . '</td>
            <td>' . htmlspecialchars($row['descr']) . '</td>
            <td>' . $row['qty'] . '</td>
            <td>&#8358;' . number_format($row['amount']) . '</td>
            <td>' . date('d-M-Y, D H:i A', strtotime($row['date'])) . '</td>
        </tr>';
    }
    $html .= '</tbody></table>';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('purchase-table.pdf', 'I'); // 'I' for inline view, 'D' for download
}
?>
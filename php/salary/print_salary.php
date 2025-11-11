<?php

session_start();
include("../../config/db_conn.php");
require_once '../../vendor/autoload.php';

// filepath: e:\wamp64\www\IMS\php\salary\print_salary.php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM salary WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    // ...build your PDF for just this row...

    // Build HTML table
    $html = '<h2>All Paid Salaries</h2>
    <table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Entered by</th>
                <th>Name of Staff</th>
                <th>Amount</th>
                <th>For the month of</th>
                <th>Date Paid</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>';

    $num = 1;
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
            <td>' . $num++ . '</td>
            <td>' . htmlspecialchars($row['entered_by']) . '</td>
            <td>' . htmlspecialchars($row['staff_name']) . '</td>
            <td>&#8358;' . number_format($row['amount']) . '</td>
            <td>' . htmlspecialchars($row['month']) . '</td>
            <td>' . date('d-M-Y, D H:i A', strtotime($row['date'])) . '</td>
            <td>' . htmlspecialchars($row['remarks']) . '</td>
        </tr>';
    }
    $html .= '</tbody></table>';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('salary-table.pdf', 'I'); // 'I' for inline view, 'D' for download
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

    if (!empty($_GET['staff_name'])) {
        $conditions[] = "staff_name LIKE ?";
        $params[] = "%" . $_GET['staff_name']. "%";
        $types .= "s";
    }

    if (!empty($_GET['amount'])) {
        $conditions[] = "amount LIKE ?";
        $params[] = "%" . $_GET['amount']. "%";
        $types .= "i";
    }

    if (!empty($_GET['month'])) {
        $conditions[] = "month = ?";
        $params[] = $_GET['month'];
        $types .= "s";
    }

    if (!empty($_GET['remarks'])) {
        $conditions[] = "remarks LIKE ?";
        $params[] = "%" . $_GET['remarks']. "%";
        $types .= "s";
    }

    $sql = "SELECT *, salary.id as salary_id FROM salary";
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
    $html = '<h2>All Paid Salaries</h2>
    <table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Entered by</th>
                <th>Name of Staff</th>
                <th>Amount</th>
                <th>For the month of</th>
                <th>Date Paid</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>';

    $num = 1;
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
            <td>' . $num++ . '</td>
            <td>' . htmlspecialchars($row['entered_by']) . '</td>
            <td>' . htmlspecialchars($row['staff_name']) . '</td>
            <td>&#8358;' . number_format($row['amount']) . '</td>
            <td>' . htmlspecialchars($row['month']) . '</td>
            <td>' . date('d-M-Y, D H:i A', strtotime($row['date'])) . '</td>
            <td>' . htmlspecialchars($row['remarks']) . '</td>
        </tr>';
    }
    $html .= '</tbody></table>';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('salary-table.pdf', 'I'); // 'I' for inline view, 'D' for download
}
?>
<?php

session_start();
include("../../config/db_conn.php");
require_once '../../vendor/autoload.php';

// filepath: e:\wamp64\www\IMS\php\sales\print_sales.php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT sales.*, sales.id as sales_id, 
    GROUP_CONCAT(
        CONCAT(
            '<b style=\"color:#007bff\">', p.product_name, '</b> (Qty: ', si.quantity, ', Price: ₦', si.price, ')<br>'
        ) SEPARATOR '||'
    ) AS products_list
    FROM sales
    LEFT JOIN sale_items si ON sales.id = si.sale_id
    LEFT JOIN product p ON si.product_id = p.id  WHERE sales.id = ? GROUP BY sales.id ORDER BY sales.sale_date DESC"); 
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    // ...build your PDF for just this row...

    // Build HTML table
    $html = '<h2>All Sales</h2>
    <table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Customer Name</th>
                <th>Customer phone no.</th>
                <th>Products Purchased</th>
                <th>Discount</th>
                <th>Amount Paid</th>
                <th>Amount Remaining</th>
                <th>Payment method</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>';

    $num = 1;
    while ($row = $result->fetch_assoc()) {
        $products = explode('||', $row['products_list']);
        $products_list = '';
        foreach ($products as $i => $prod) {
            $products_list .= ($i + 1) . '. ' . $prod . '<br>';
        }

        $html .= '<tr>
            <td>' . date('d-M-Y, D H:i A', strtotime($row['sale_date'])) . '</td>
            <td>' . htmlspecialchars($row['customer_name']) . '</td>
            <td>' . htmlspecialchars($row['customer_phone']) . '</td>
            <td>' . $products_list . '</td>
            <td>&#8358;' . number_format($row['discount']) . '</td>
            <td>&#8358;' . number_format($row['paid']) . '</td>
            <td>&#8358;' . number_format($row['grand_total']) . '</td>
            <td>' . htmlspecialchars($row['payment_method']) . '</td>
            <td>' . htmlspecialchars($row['comments']) . '</td>
        </tr>';
    }
    $html .= '</tbody></table>';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('sales-table.pdf', 'I'); // 'I' for inline view, 'D' for download
} else {
    // ...Code to print all rows...

    // Build search conditions
    
    $conditions = [];
    $params = [];
    $types = "";
    if (!empty($_GET['dateFrom'])) {
        $conditions[] = "sales.sale_date >= ?";
        $params[] = $_GET['dateFrom'];
        $types .= "s";
    }
    if (!empty($_GET['dateTo'])) {
        $conditions[] = "sales.sale_date < ? + INTERVAL 1 DAY";
        $params[] = $_GET['dateTo'];
        $types .= "s";
    }
    if (!empty($_GET['customer_name'])) {
        $conditions[] = "sales.customer_name LIKE ?";
        $params[] = "%" . $_GET['customer_name'] . "%";
        $types .= "s";
    }
    if (!empty($_GET['product_name'])) {
        $conditions[] = "p.product_name LIKE ?";
        $params[] = "%" . $_GET['product_name'] . "%";
        $types .= "s";
    }
    if (!empty($_GET['payment'])) {
        $conditions[] = "sales.payment_method = ?";
        $params[] = $_GET['payment'];
        $types .= "s";
    }

    // Fetch sales data (copy your query logic here)
    $sql = "SELECT sales.*, sales.id as sales_id, 
        GROUP_CONCAT(
            CONCAT(
                '<b style=\"color:#007bff\">', p.product_name, '</b> (Qty: ', si.quantity, ', Price: ₦', si.price, ')<br>'
            ) SEPARATOR '||'
        ) AS products_list
        FROM sales
        LEFT JOIN sale_items si ON sales.id = si.sale_id
        LEFT JOIN product p ON si.product_id = p.id";

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " GROUP BY sales.id ORDER BY sales.sale_date DESC";

    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Build HTML table
    $html = '<h2>All Sales</h2>
    <table border="1" cellpadding="5" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Date</th>
                <th>Customer Name</th>
                <th>Customer phone no.</th>
                <th>Products Purchased</th>
                <th>Discount</th>
                <th>Amount Paid</th>
                <th>Amount Remaining</th>
                <th>Payment method</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>';

    $num = 1;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products = explode('||', $row['products_list']);
            $products_list = '';
            foreach ($products as $i => $prod) {
                $products_list .= ($i + 1) . '. ' . $prod . '<br>';
            }

            $html .= '<tr>
                <td>' . $num++ . '</td>
                <td>' . date('d-M-Y, D H:i A', strtotime($row['sale_date'])) . '</td>
                <td>' . htmlspecialchars($row['customer_name']) . '</td>
                <td>' . htmlspecialchars($row['customer_phone']) . '</td>
                <td>' . $products_list . '</td>
                <td>&#8358;' . number_format($row['discount']) . '</td>
                <td>&#8358;' . number_format($row['paid']) . '</td>
                <td>&#8358;' . number_format($row['grand_total']) . '</td>
                <td>' . htmlspecialchars($row['payment_method']) . '</td>
                <td>' . htmlspecialchars($row['comments']) . '</td>
            </tr>';
        }
    }
    $html .= '</tbody></table>';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $mpdf->Output('sales-table.pdf', 'I'); // 'I' for inline view, 'D' for download
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Sales</h1>
    </div>


        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col"><h6 class="m-0 mt-2">Sales List</h6></div>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_sales_modal">Add New</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Loader -->
                <div id="loader-container">
                    <div class="loader"></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-gray-900" id="dataTable">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Customer phone no.</th>
                                <th>List of Products</th>
                                <th>Qty</th>
                                <th>Total Price</th>
                                <th>Payment method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT *, sales.id AS sales_id from sales";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $num = 1;

                                    foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $num; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td><?= $row['customer_name']; ?></td>
                                        <td><?= $row['customer_phone']; ?></td>
                                        <td><?= $row['products']; ?></td>
                                        <td><?= $row['quantity']; ?></td>   
                                        <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                        <td><?= $row['payment_method']; ?></td>
                                        <td>
                                            <button name="edit_sale" class="btn btn-primary btn-sm" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteSales(<?= $row['sales_id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                        $num++;
                                    }
                                }
                                $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

<?php
include('includes/sales_modal.php');
?>

<script>
    // Get sales to update
    function updateSales(sales_id) {
        $("#edit_sale_id").val(sales_id);

        $.post("php/sales/get.php", {
            sales_id: sales_id
        }, function(data, status) {
            var id = JSON.parse(data); 
            $('#edit_product_name').val(id.products);
            $('#edit_price').val(id.total_price / id.quantity); 
            $('#edit_total').val(id.total_price);
            $('#edit_quantity').val(id.quantity);
            $('#edit_customer_name').val(id.customer_name); 
            $('#edit_customer_phone').val(id.customer_phone); 
            $('#update_select_payment').val(id.payment_method);
        })
        $("#update_sales_modal").modal("show"); //Show the modal
    }

    // Get product to update
    function deleteSales(sales_id) {
        $("#delete_sale_id").val(sales_id);

        $.post("php/sales/delete.php", {
            sales_id: sales_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_product_name').val(id.products); 
            $('#edit_total').val(id.total_price);
            $('#edit_quantity').val(id.quantity);
            $('#edit_customer_name').val(id.customer_name); 
            $('#edit_customer_phone').val(id.customer_phone); 
            $('#update_select_payment').val(id.payment_method);
        })
        $("#delete_sales_modal").modal("show"); //Show the modal
    }
</script>

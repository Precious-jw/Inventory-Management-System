<?php
include("config/db_conn.php");

if ($_SESSION['role'] == 0){
    redirect("http://localhost/ims/");
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Product Master</h1>
    </div>


    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 mt-2">Product List</h6>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#add_product_modal">Add New</button>
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
                            <th>No.</th>
                            <th>Product Name</th>
                            <th>Purchase Price</th>
                            <th>Sale Price</th>
                            <th>Available Quantity</th>
                            <th>Total Purchase Amount</th>
                            <th>Total Sale Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT *, product.id AS product_id from product";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $num = 1;

                                foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td><?= $num; ?></td>
                                    <td><?= $row['product_name']; ?></td>
                                    <td>&#8358;<?= number_format($row['purchase_price']); ?></td>
                                    <td>&#8358;<?= number_format($row['sale_price']); ?></td>
                                    <td><?= $row['product_qty']; ?></td>
                                    <td>&#8358;<?= number_format($row['product_qty']*$row['purchase_price']); ?></td>
                                    <td>&#8358;<?= number_format($row['product_qty']*$row['sale_price']); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="updateProduct(<?= $row['product_id']; ?>)">Update</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteProduct(<?= $row['product_id']; ?>)">Delete</button>
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
include('includes/product_modal.php');
?>


<script>
    /*Show modal
    $(function() {
        $('.add-btn').click(function(e) {
            e.preventDefault();
            $('#add_product_modal').modal('show');
        });
    });*/

    // Get product to update
    function updateProduct(product_id) {
        $("#edit_product_id").val(product_id);

        $.post("php/product/get.php", {
            product_id: product_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_product').val(id.product_name);
            $('#edit_purchase_price').val(id.purchase_price);
            $('#edit_sale_price').val(id.sale_price);
            $('#edit_qty').val(id.product_qty);
        })
        $("#update_product_modal").modal("show"); //Show the modal
    }

    // Get product to delete
    function deleteProduct(product_id) {
        $("#delete_product_id").val(product_id);

        $.post("php/product/delete.php", {
            product_id: product_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_product').val(id.product_name);
            $('#edit_purchase_price').val(id.purchase_price);
            $('#edit_sale_price').val(id.sale_price);
        })
        $("#delete_product_modal").modal("show"); //Show the modal
    }
</script>
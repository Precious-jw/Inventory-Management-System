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

    <div class="card shadow mb-4"> <!--begin::Container-->
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="m-0 mt-2">Search Product</h5>
                </div>
            </div>
        </div>
        <div class="card mb-4 col-12">

            <form id="SearchExpensesForm" method="post"> <!--begin::Body-->
                <div class="card-body row">
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Product Name</b></label> 
                        <input type="text" id="product_name" name="product_name" value="<?= isset($_POST['product_name']) ? $_REQUEST['product_name'] : '' ?>" class="form-control">
                    </div>

                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Product Code</b></label> 
                        <input type="text" id="product_code" name="product_code" value="<?= isset($_POST['product_code']) ? $_REQUEST['product_code'] : '' ?>" class="form-control">
                    </div>

                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Company Name</b></label> 
                        <input type="text" id="company_name" name="company_name" value="<?= isset($_POST['company_name']) ? $_REQUEST['company_name'] : '' ?>" class="form-control">
                    </div>

                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Status</b></label> 
                        <select id="status" name="status" class="form-control">
                            <option value="">Select Status</option>
                            <option <?= isset($_POST['status']) ? ($_POST['status'] == "In Stock" ? "selected" : '') : ''?> value="In Stock">In Stock</option>
                            <option <?= isset($_POST['status']) ? ($_POST['status'] == "Low Stock" ? "selected" : '') : ''?> value="Low Stock">Low Stock</option>
                            <option <?= isset($_POST['status']) ? ($_POST['status'] == "Out of Stock" ? "selected" : '') : ''?> value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                    <div class="mt-2 form-group col-md-3"> 
                        <label><b></b></label> <br>
                        <button type="submit" class="btn btn-primary" name="search">Search</button> 
                        <a href="<?= base_url."product_master" ?>" class="btn btn-success">Reset</a> 
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
            </form> <!--end::Form-->
        </div>
    </div> <!--end::App Content-->

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
                            <th>Product Code</th>
                            <th>Purchase Price</th>
                            <th>Wholesale Price</th>
                            <th>Retail Price</th>
                            <th>Company</th>
                            <th>Available Quantity</th>
                            <th>Low Stock Limit</th>
                            <th>Total Purchase Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_POST['search'])) {
                                $conditions = [];
                                $params = [];
                                $types = "";

                                if (!empty($_POST['product_name'])) {
                                    $conditions[] = "product_name LIKE ?";
                                    $params[] = "%" . $_POST['product_name']. "%";
                                    $types .= "s";
                                }

                                if (!empty($_POST['product_code'])) {
                                    $conditions[] = "product_code LIKE ?";
                                    $params[] = "%" . $_POST['product_code']. "%";
                                    $types .= "s";
                                }

                                if (!empty($_POST['company_name'])) {
                                    $conditions[] = "company LIKE ?";
                                    $params[] = "%" . $_POST['company_name']. "%";
                                    $types .= "s";
                                }

                                $sql = "SELECT *, product.id as product_id FROM product";
                                if (!empty($conditions)) {
                                    $sql .= " WHERE " . implode(" AND ", $conditions);
                                }

                                $stmt = $conn->prepare($sql);
                                if (!empty($params)) {
                                    $stmt->bind_param($types, ...$params);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else {
                                $stmt = $conn->prepare("SELECT *, product.id as product_id FROM product");
                                $stmt->execute();
                                $result = $stmt->get_result();
                            }
                        ?>

                        <?php
                            if ($result->num_rows > 0) {
                                $num = 1;

                                foreach ($result as $row) {

                                if($row['product_qty'] > $row['threshold']){
                                    $availability = "In Stock";
                                } else if ($row['product_qty'] > 0 && $row['product_qty'] < $row['threshold']){
                                    $availability = "Low Stock";
                                } else {
                                    $availability = "Out of Stock";
                                };

                                // Filter by selected status
                                if (!empty($_POST['status']) && $_POST['status'] !== $availability) {
                                    continue;
                                }

                                $statusColor = [
                                    "In Stock" => "success text-white",
                                    "Low Stock" => "warning text-black",
                                    "Out of Stock" => "danger text-white"
                                ];
                        ?>
                                <tr>
                                    <td><?= $num; ?></td>
                                    <td><?= $row['product_name']; ?></td>
                                    <td><?= $row['product_code']; ?></td>
                                    <td>&#8358;<?= number_format($row['purchase_price']); ?></td>
                                    <td>&#8358;<?= number_format($row['sale_price']); ?></td>
                                    <td>&#8358;<?= number_format($row['retail_price']); ?></td>
                                    <td><?= $row['company']; ?></td>
                                    <td><?= $row['product_qty']; ?></td>
                                    <td><?= $row['threshold']; ?></td>
                                    <td>&#8358;<?= number_format($row['product_qty']*$row['purchase_price']); ?></td>
                                    <td><span class="badge bg-<?= $statusColor[$availability]; ?> fs-6 px-3 py-2"><?= $availability; ?></span></td>
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
            $('#edit_product_code').val(id.product_code);
            $('#edit_purchase_price').val(id.purchase_price);
            $('#edit_sale_price').val(id.sale_price);
            $('#edit_retail_price').val(id.retail_price);
            $('#edit_company').val(id.company);
            $('#edit_qty').val(id.product_qty);
            $('#edit_threshold').val(id.threshold);
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
        })
        $("#delete_product_modal").modal("show"); //Show the modal
    }
</script>
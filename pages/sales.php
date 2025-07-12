
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Sales</h1>
    </div>

        <div class="card shadow mb-4"> <!--begin::Container-->
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h6 class="m-0 mt-2">Search By date</h6>
                    </div>
                </div>
            </div>
            <div class="col-12">

                <form id="SearchSalesForm" method="post"> <!--begin::Body-->
                    <div class="card-body row">
                        <div class="mb-3 form-group col-md-3"> 
                            <label><b>Date From</b></label> 
                            <input type="Date" id="dateFrom" name="dateFrom" value="<?= isset($_POST['dateFrom']) ? $_REQUEST['dateFrom'] : '' ?>" class="form-control">
                        </div>
                        <div class="mb-3 form-group col-md-3"> 
                            <label><b>Date To</b></label> 
                            <input type="Date" id="dateTo" name="dateTo" value="<?= isset($_POST['dateTo']) ? $_REQUEST['dateTo'] : '' ?>" class="form-control">
                        </div>
                        <div class="mt-2 form-group col-md-6"> 
                            <label><b></b></label> <br>
                            <button type="submit" class="btn btn-primary" name="search">Search</button> 
                            <a href="<?= base_url."sales" ?>" class="btn btn-success">Reset</a> 
                        </div>
                    </div> <!--end::Body--> <!--begin::Footer-->
                </form> <!--end::Form-->
            </div>
        </div> <!--end::App Content-->

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
                                <th>Discount</th>
                                <th>Total Price</th>
                                <th>Payment method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(ISSET($_POST['search'])){
                                    if(!empty($_POST['dateFrom']) && !empty($_POST['dateTo'])){
                                        $dateFrom = $_POST['dateFrom'];
                                        $dateTo = $_POST['dateTo'];
                                        $stmt = $conn->prepare("SELECT *, sales.id as sales_id from sales WHERE date >='$dateFrom' AND date < '$dateTo' + INTERVAL 1 DAY");
                                        $stmt->execute();

                                        $result = $stmt->get_result();
                                        
                                        if ($result->num_rows > 0) {
                                            $num = 1;

                                            foreach ($result as $row) {
                                ?>
                                        <tr>
                                            <td><?= $num; ?></td>
                                            <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_phone']; ?></td>
                                            <td><?= $row['products']; ?></td>
                                            <td><?= $row['quantity']; ?></td>   
                                            <td>&#8358;<?= number_format($row['discount']); ?></td>   
                                            <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                            <td><?= $row['payment_method']; ?></td>
                                            <td>
                                                <button name="edit_sale" style="width: 80%" class="btn btn-primary btn-sm m-1" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button> <br>
                                                <button class="btn btn-danger btn-sm" style="width: 100%" onclick="deleteSales(<?= $row['sales_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                            $num++;
                                        }
                                    }
                                } else if(!empty($_POST['dateFrom'])){
                                        $dateFrom = $_POST['dateFrom'];
                                        $stmt = $conn->prepare("SELECT *, sales.id as sales_id from sales WHERE date >='$dateFrom'");
                                        $stmt->execute();

                                        $result = $stmt->get_result();
                                        
                                        if ($result->num_rows > 0) {
                                            $num = 1;

                                            foreach ($result as $row) {
                                ?>
                                        <tr>
                                            <td><?= $num; ?></td>
                                            <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_phone']; ?></td>
                                            <td><?= $row['products']; ?></td>
                                            <td><?= $row['quantity']; ?></td>   
                                            <td>&#8358;<?= number_format($row['discount']); ?></td>   
                                            <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                            <td><?= $row['payment_method']; ?></td>
                                            <td>
                                                <button name="edit_sale" style="width: 80%" class="btn btn-primary btn-sm m-1" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button> <br>
                                                <button class="btn btn-danger btn-sm" style="width: 100%" onclick="deleteSales(<?= $row['sales_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                            $num++;
                                        }
                                    }
                                } else if(!empty($_POST['dateTo'])){
                                    $dateTo = $_POST['dateTo'];
                                    $stmt = $conn->prepare("SELECT *, sales.id as sales_id from sales WHERE date < '$dateTo' + INTERVAL 1 DAY");
                                    $stmt->execute();

                                    $result = $stmt->get_result();
                                    
                                    if ($result->num_rows > 0) {
                                        $num = 1;

                                        foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $num; ?></td>
                                            <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_phone']; ?></td>
                                            <td><?= $row['products']; ?></td>
                                            <td><?= $row['quantity']; ?></td>   
                                            <td>&#8358;<?= number_format($row['discount']); ?></td>   
                                            <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                            <td><?= $row['payment_method']; ?></td>
                                            <td>
                                                <button name="edit_sale" style="width: 80%" class="btn btn-primary btn-sm m-1" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button> <br>
                                                <button class="btn btn-danger btn-sm" style="width: 100%" onclick="deleteSales(<?= $row['sales_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                            $num++;
                                        }
                                    }
                                } else {
                                    $sql = "SELECT *, sales.id as sales_id from sales";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $num = 1;

                                        foreach ($result as $row) {
                            ?>
                                    <tr>
                                        <td><?= $num; ?></td>
                                            <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_phone']; ?></td>
                                            <td><?= $row['products']; ?></td>
                                            <td><?= $row['quantity']; ?></td>   
                                            <td>&#8358;<?= number_format($row['discount']); ?></td>   
                                            <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                            <td><?= $row['payment_method']; ?></td>
                                            <td>
                                                <button name="edit_sale" style="width: 80%" class="btn btn-primary btn-sm m-1" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button> <br>
                                                <button class="btn btn-danger btn-sm" style="width: 100%" onclick="deleteSales(<?= $row['sales_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                            $num++;
                                        }
                                    }
                                } 
                            } else {

                                $sql = "SELECT *, sales.id as sales_id from sales";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $num = 1;

                                    foreach ($result as $row) {
                        ?>
                                <tr>
                                        <td><?= $num; ?></td>
                                            <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_phone']; ?></td>
                                            <td><?= $row['products']; ?></td>
                                            <td><?= $row['quantity']; ?></td>   
                                            <td>&#8358;<?= number_format($row['discount']); ?></td>   
                                            <td>&#8358;<?= number_format($row['total_price']); ?></td>
                                            <td><?= $row['payment_method']; ?></td>
                                            <td>
                                                <button name="edit_sale" style="width: 80%" class="btn btn-primary btn-sm m-1" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button> <br>
                                                <button class="btn btn-danger btn-sm" style="width: 100%" onclick="deleteSales(<?= $row['sales_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                <?php
                                            $num++;
                                        }
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
            $('#edit_price').val(id.purchase_price); 
            $('#edit_total').val(id.total_price);
            $('#edit_quantity').val(id.quantity);
            $('#edit_customer_name').val(id.customer_name); 
            $('#edit_customer_phone').val(id.customer_phone); 
            $('#edit_discount').val(id.discount); 
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

<?php
include("config/db_conn.php");

if ($_SESSION['role'] != 2 && $_SESSION['role'] != 1) {
    redirect(base_url);
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Purchases</h1>
    </div>

    <div class="card shadow mb-4"> <!--begin::Container-->
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 mt-2">Search By date</h6>
                </div>
            </div>
        </div>
        <div class="card mb-4 col-12">

            <form id="SearchPurchasesForm" method="post"> <!--begin::Body-->
                <div class="card-body row">
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Date From</b></label> 
                        <input type="Date" id="dateFrom" name="dateFrom" value="<?= isset($_POST['dateFrom']) ? $_REQUEST['dateFrom'] : '' ?>" class="form-control">
                    </div>
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Date To</b></label> 
                        <input type="Date" id="dateTo" name="dateTo" value="<?= isset($_POST['dateTo']) ? $_REQUEST['dateTo'] : '' ?>" class="form-control">
                    </div>
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Description</b></label> 
                        <input type="text" id="search_description" name="search_description" value="<?= isset($_POST['search_description']) ? $_REQUEST['search_description'] : '' ?>" class="form-control">
                    </div>
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Amount</b></label> 
                        <input type="number" id="search_amount" name="search_amount" value="<?= isset($_POST['search_amount']) ? $_REQUEST['search_amount'] : '' ?>" class="form-control">
                    </div>
                    <div class="mt-2 form-group col-md-6"> 
                        <label><b></b></label> <br>
                        <button type="submit" class="btn btn-primary" name="search">Search</button> 
                        <a href="<?= base_url."purchases" ?>" class="btn btn-success">Reset</a> 
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
            </form> <!--end::Form-->
        </div>
    </div> <!--end::App Content-->

    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 mt-2">All Purchases</h6>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#add_purchase_modal">Add New</button>
                    <a href="php/purchases/print_purchases.php?dateFrom=<?= isset($_POST['dateFrom']) ? $_REQUEST['dateFrom'] : '' ?>&dateTo=<?= isset($_POST['dateTo']) ? $_REQUEST['dateTo'] : '' ?>" target="_blank" class="btn btn-secondary btn-sm add-btn">Print PDF</a>
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
                            <th>Entered by</th>
                            <th>Purchase Description</th>
                            <th>Quantity</th>
                            <th>Purchase Cost</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_POST['search'])) {
                                $conditions = [];
                                $params = [];
                                $types = "";

                                if (!empty($_POST['dateFrom'])) {
                                    $conditions[] = "date >= ?";
                                    $params[] = $_POST['dateFrom'];
                                    $types .= "s";
                                }

                                if (!empty($_POST['dateTo'])) {
                                    $conditions[] = "date < ? + INTERVAL 1 DAY";
                                    $params[] = $_POST['dateTo'];
                                    $types .= "s";
                                }

                                if (!empty($_POST['search_description'])) {
                                    $conditions[] = "descr LIKE ?";
                                    $params[] = "%" . $_POST['search_description']. "%";
                                    $types .= "s";
                                }

                                if (!empty($_POST['search_amount'])) {
                                    $conditions[] = "CAST(amount AS CHAR) LIKE ?";
                                    $params[] = "%" . $_POST['search_amount'] . "%";
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
                            } else {
                                $stmt = $conn->prepare("SELECT *, purchases.id as purchases_id FROM purchases");
                                $stmt->execute();
                                $result = $stmt->get_result();
                            }
                        ?>

                        <?php if ($result->num_rows > 0): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($result as $row): ?>
                                <tr>
                                    <td><?= $num++; ?></td>
                                    <td><?= $row['entered_by']; ?></td>
                                    <td><?= $row['descr']; ?></td>
                                    <td><?= $row['qty']; ?></td>
                                    <td>&#8358;<?= number_format($row['amount'], 2); ?></td>
                                    <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="updatePurchases(<?= $row['purchases_id']; ?>)">Update</button>
                                        <a href="php/purchases/print_purchases.php?id=<?= $row['purchases_id']; ?>" target="_blank" class="btn btn-secondary btn-sm m-1">Print PDF</a> <br>
                                        <button class="btn btn-danger btn-sm" onclick="deletePurchases(<?= $row['purchases_id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php $stmt->close(); ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

<?php
include('includes/purchases_modal.php');
?>


<script>
    /*Show modal
    $(function() {
        $('.add-btn').click(function(e) {
            e.preventDefault();
            $('#add_product_modal').modal('show');
        });
    });*/

    // Get purchase to update
    function updatePurchases(purchase_id) {
        $("#edit_purchases_id").val(purchase_id);

        $.post("php/purchases/get.php", {
            purchases_id: purchase_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_description').val(id.descr);
            $('#edit_quantity').val(id.qty);
            $('#edit_amount').val(id.amount);
        })
        $("#update_purchases_modal").modal("show"); //Show the modal
    }

    // Get product to delete
    function deletePurchases(purchases_id) {
        $("#delete_purchase_id").val(purchases_id);

        $.post("php/purchases/delete.php", {
            purchases_id: purchases_id
        }, function(data, status) {
            var id = JSON.parse(data);
        })
        $("#delete_purchases_modal").modal("show"); //Show the modal
    }
</script>
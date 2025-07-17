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
        <h1 class="h3 mb-0 text-gray-900">Expenses</h1>
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

            <form id="SearchExpensesForm" method="post"> <!--begin::Body-->
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
                        <a href="<?= base_url."expenses" ?>" class="btn btn-success">Reset</a> 
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
            </form> <!--end::Form-->
        </div>
    </div> <!--end::App Content-->

    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 mt-2">All Expenses</h6>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#add_expense_modal">Add New</button>
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
                            <th>Expenses Description</th>
                            <th>Amount</th>
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

                                $sql = "SELECT *, expenses.id as expenses_id FROM expenses";
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
                                $stmt = $conn->prepare("SELECT *, expenses.id as expenses_id FROM expenses");
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
                                    <td>&#8358;<?= number_format($row['amount']); ?></td>
                                    <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="updateExpenses(<?= $row['expenses_id']; ?>)">Update</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteExpenses(<?= $row['expenses_id']; ?>)">Delete</button>
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
include('includes/expenses_modal.php');
?>


<script>
    /*Show modal
    $(function() {
        $('.add-btn').click(function(e) {
            e.preventDefault();
            $('#add_product_modal').modal('show');
        });
    });*/

    // Get expense to update
    function updateExpenses(expense_id) {
        $("#edit_expenses_id").val(expense_id);

        $.post("php/expenses/get.php", {
            expenses_id: expense_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_description').val(id.descr);
            $('#edit_amount').val(id.amount);
        })
        $("#update_expenses_modal").modal("show"); //Show the modal
    }

    // Get product to delete
    function deleteExpenses(expense_id) {
        $("#delete_expense_id").val(expense_id);

        $.post("php/expenses/delete.php", {
            expenses_id: expense_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_description').val(id.descr);
            $('#edit_amount').val(id.amount);
        })
        $("#delete_expenses_modal").modal("show"); //Show the modal
    }
</script>
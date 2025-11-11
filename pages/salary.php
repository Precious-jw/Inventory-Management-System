<?php
include("config/db_conn.php");

if ($_SESSION['role'] != 2){
    redirect(base_url);
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Pay Salary</h1>
    </div>

    <div class="card shadow mb-4"> <!--begin::Container-->
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 mt-2">Search for Paid Salary</h6>
                </div>
            </div>
        </div>
        <div class="card mb-4 col-12">

            <form id="SearchSalaryForm" method="post"> <!--begin::Body-->
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
                        <label><b>Name of Staff</b></label> 
                        <input type="text" id="staff_name_search" name="staff_name_search" value="<?= isset($_POST['staff_name_search']) ? $_REQUEST['staff_name_search'] : '' ?>" class="form-control">
                    </div>
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Amount</b></label> 
                        <input type="number" id="amount_search" name="amount_search" value="<?= isset($_POST['amount_search']) ? $_REQUEST['amount_search'] : '' ?>" class="form-control">
                    </div>
                    <div class="mb-3 form-group col-md-3"> 
                            <label><b>Month</b></label> 
                            <select id="month_search" name="month_search" class="form-control">
                                <option value="">Select Month</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "January" ? "selected" : '') : ''?> value="January">January</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "February" ? "selected" : '') : ''?> value="February">February</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "March" ? "selected" : '') : ''?> value="March">March</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "April" ? "selected" : '') : ''?> value="April">April</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "May" ? "selected" : '') : ''?> value="May">May</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "June" ? "selected" : '') : ''?> value="June">June</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "July" ? "selected" : '') : ''?> value="July">July</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "August" ? "selected" : '') : ''?> value="August">August</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "September" ? "selected" : '') : ''?> value="September">September</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "October" ? "selected" : '') : ''?> value="October">October</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "November" ? "selected" : '') : ''?> value="November">November</option>
                                <option <?= isset($_POST['month_search']) ? ($_POST['month_search'] == "December" ? "selected" : '') : ''?> value="December">December</option>
                            </select>
                        </div>
                    <div class="mb-3 form-group col-md-3"> 
                        <label><b>Remarks</b></label> 
                        <input type="text" id="remarks_search" name="remarks_search" value="<?= isset($_POST['remarks_search']) ? $_REQUEST['remarks_search'] : '' ?>" class="form-control">
                    </div>
                    <div class="mt-2 form-group col-md-6"> 
                        <label><b></b></label> <br>
                        <button type="submit" class="btn btn-primary" name="search">Search</button> 
                        <a href="<?= base_url."salary" ?>" class="btn btn-success">Reset</a> 
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
            </form> <!--end::Form-->
        </div>
    </div> <!--end::App Content-->

    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 mt-2">All Paid Salaries</h6>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#add_salary_modal">Add New</button>
                    <a href="php/salary/print_salary.php?dateFrom=<?= isset($_POST['dateFrom']) ? $_REQUEST['dateFrom'] : '' ?>&dateTo=<?= isset($_POST['dateTo']) ? $_REQUEST['dateTo'] : '' ?>&staff_name=<?= isset($_POST['staff_name']) ? $_REQUEST['staff_name'] : '' ?>&amount=<?= isset($_POST['amount']) ? $_REQUEST['amount'] : '' ?>&month=<?= isset($_POST['month']) ? $_REQUEST['month'] : '' ?>&remarks=<?= isset($_POST['remarks']) ? $_REQUEST['remarks'] : '' ?>" class="btn btn-secondary btn-sm add-btn" target="_blank">Print PDF</a>
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
                            <th>Name of Staff</th>
                            <th>Amount</th>
                            <th>For the month of</th>
                            <th>Date Paid</th>
                            <th>Remarks</th>
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

                                if (!empty($_POST['staff_name_search'])) {
                                    $conditions[] = "staff_name LIKE ?";
                                    $params[] = "%" . $_POST['staff_name_search']. "%";
                                    $types .= "s";
                                }

                                if (!empty($_POST['amount_search'])) {
                                    $conditions[] = "amount LIKE ?";
                                    $params[] = "%" . $_POST['amount_search']. "%";
                                    $types .= "s";
                                }

                                if (!empty($_POST['month_search'])) {
                                    $conditions[] = "month = ?";
                                    $params[] = $_POST['month_search'];
                                    $types .= "s";
                                }

                                if (!empty($_POST['remarks_search'])) {
                                    $conditions[] = "remarks LIKE ?";
                                    $params[] = "%" . $_POST['remarks_search']. "%";
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
                            } else {
                                $stmt = $conn->prepare("SELECT *, salary.id as salary_id FROM salary");
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
                                    <td><?= $row['staff_name']; ?></td>
                                    <td>&#8358;<?= number_format($row['amount'], 2); ?></td>
                                    <td><?= $row['month']; ?></td>
                                    <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                    <td><?= $row['remarks']; ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm m-1" onclick="updateSalary(<?= $row['salary_id']; ?>)">Update</button>
                                        <a href="php/salary/print_salary.php?id=<?= $row['salary_id']; ?>" target="_blank" class="btn btn-secondary btn-sm m-1">Print PDF</a>
                                        <button class="btn btn-danger btn-sm" onclick="deleteSalary(<?= $row['salary_id']; ?>)">Delete</button>
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
include('includes/salary_modal.php');
?>


<script>
    /*Show modal
    $(function() {
        $('.add-btn').click(function(e) {
            e.preventDefault();
            $('#add_product_modal').modal('show');
        });
    });*/

    // Get salary to update
    function updateSalary(salary_id) {
        $("#edit_salary_id").val(salary_id);

        $.post("php/salary/get.php", {
            salary_id: salary_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_staff_name').val(id.staff_name);
            $('#edit_amount').val(id.amount);
            $('#edit_month').val(id.month);
            $('#edit_remarks').val(id.remarks);
        })
        $("#update_salary_modal").modal("show"); //Show the modal
    }

    // Get product to delete
    function deleteSalary(salary_id) {
        $("#delete_salary_id").val(salary_id);

        $.post("php/salary/delete.php", {
            salary_id: salary_id
        }, function(data, status) {
            var id = JSON.parse(data);
        })
        $("#delete_salary_modal").modal("show"); //Show the modal
    }

</script>


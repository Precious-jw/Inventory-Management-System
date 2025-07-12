<?php
include("config/db_conn.php");

if ($_SESSION['role'] != 2){
    redirect("http://localhost/bootstrap/");
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Manage Users</h1>
    </div>


        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col"><h6 class="m-0 mt-2">Users List</h6></div>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_user_modal">Add New</button>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone no.</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT *, users.id AS users_id from users";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $num = 1;
                                    $role = '';
                                    $pass = '';

                                    foreach ($result as $row) {
                                        if($row['role'] == 2){$pass = '';}else{$pass = $row['pass'];}
                                        if($row['role'] == 0){$role = 'User';}elseif($row['role'] == 1){$role = 'Assistant Admin';}else{$role = 'Admin';}
                            ?>
                                    <tr>
                                        <td><?= $num; ?></td>
                                        <td><?= date('d-M-Y, D H:i A', strtotime($row['date'])); ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['phone']; ?></td>
                                        <td><?= $row['username']; ?></td>   
                                        <td><?= $pass; ?></td>
                                        <td><?= $role; ?></td>
                                        <td>
                                            <button name="edit_sale" class="btn btn-primary btn-sm" onclick="updateUser(<?= $row['users_id']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $row['users_id']; ?>)">Delete</button>
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
include('includes/user_modal.php');
?>

<script>
    // Get user to update
    function updateUser(user_id) {
        $("#edit_user_id").val(user_id);

        $.post("php/users/get.php", {
            user_id: user_id
        }, function(data, status) {
            var id = JSON.parse(data); 
            $('#edit_name').val(id.name);
            $('#edit_email').val(id.email);
            $('#edit_phone').val(id.phone);
            $('#edit_username').val(id.username); 
            $('#edit_role').val(id.role);
            if (id.role == 2){
                $('#edit_password').val(""); 
            } else {
                $('#edit_password').val(id.pass); 
            }
        })
        $("#update_user_modal").modal("show"); //Show the modal
    }

    // Get user to delete
    function deleteUser(user_id) {
        $("#delete_user_id").val(user_id);

        $.post("php/users/delete.php", {
            user_id: user_id
        }, function(data, status) {
            var id = JSON.parse(data);
            $('#edit_name').val(id.name);
            $('#edit_email').val(id.email);
            $('#edit_phone').val(id.phone);
            $('#edit_username').val(id.username); 
            $('#edit_password').val(id.pass); 
            $('#edit_role').val(id.role);
        })
        $("#delete_user_modal").modal("show"); //Show the modal
    }
</script>

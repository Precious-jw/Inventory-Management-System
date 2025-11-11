<!-- Add User Modal -->
<div class="modal fade" id="add_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Add User</h5>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-sm" id="addRow">Add Row</button>
                    </div>
                </div>
            </div>
            <form id="userForm" action="saveuser">
                <div class="modal-body">
                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone no.</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rowContainer">
                                <tr>
                                    <input type="hidden" class="form-control text-gray-900" name="business_name[]" id="business_name" value="<?= $_SESSION["business_name"]; ?>">
                                    <td><input type="text" class="form-control text-gray-900" name="name[]" id="name" placeholder="Enter Name"></td>
                                    <td><input type="email" class="form-control text-gray-900" name="email[]" id="email" placeholder="Enter Email"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="phone[]" id="phone" placeholder="Enter Phone Number"></td>
                                    <td><input type="text" class="form-control text-gray-900" name="username[]" id="username" placeholder="Enter Username"></td>
                                    <td><input type="text" class="form-control text-gray-900" name="password[]" id="password" placeholder="Enter Password"></td>
                                    <td><select id="role" name="role[]" class="form-control">
                                            <option value="">Select Role</option>
                                            <option value="0">User</option>
                                            <option value="1">Assistant Admin</option>
                                            <option value="2">Admin</option>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit[]" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Product Modal -->
<div class="modal fade" id="update_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Edit Product</h5>
            </div>
            <form id="UpdateUserForm">
                <div class="modal-body">
                        <input type="hidden" name="update_user_id" id="edit_user_id">
                    <div class="row mt-2">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Name</label>
                            <input type="text" class="form-control text-gray-900" name="update_name" id="edit_name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Email</label>
                            <input type="email" class="form-control text-gray-900" name="update_email" id="edit_email">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Phone no.</label>
                            <input type="number" class="form-control text-gray-900" name="update_phone" id="edit_phone">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Username</label>
                            <input type="text" class="form-control text-gray-900" name="update_username" id="edit_username">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Password</label>
                            <input type="text" class="form-control text-gray-900" name="update_password" id="edit_password">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Role</label>
                            <select id="edit_role" name="update_role" class="form-control">
                                <option value="">Select Role</option>
                                <option value="0">User</option>
                                <option value="1">Assistant Admin</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete User Modal -->
<div class="modal" tabindex="-1" id="delete_user_modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-red">Warning</h3>
        <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>
      </div>
        <form id="deleteUserForm">
        <div class="modal-body">
        <input type="hidden" name="delete_user_id" id="delete_user_id">
        <p><strong>Are you sure you want to delete this user?</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addRow = document.getElementById("addRow");
        const rowContainer = document.getElementById("rowContainer");

        addRow.addEventListener("click", function() {
            const newRow = document.createElement("tr");

            const nameCell = document.createElement("td");
            nameCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="name[]" id="name" placeholder="Enter Name">';
            newRow.appendChild(nameCell);

            const emailCell = document.createElement("td");
            emailCell.innerHTML = '<input type="email" class="form-control text-gray-900" name="email[]" id="email" placeholder="Enter Email">';
            newRow.appendChild(emailCell);

            const phoneCell = document.createElement("td");
            phoneCell.innerHTML = '<input type="number" class="form-control text-gray-900" name="phone[]" id="phone" placeholder="Enter Phone Number">';
            newRow.appendChild(phoneCell);

            const usernameCell = document.createElement("td");
            usernameCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="username[]" id="username" placeholder="Enter Username">';
            newRow.appendChild(usernameCell);

            const passwordCell = document.createElement("td");
            passwordCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="password[]" id="password" placeholder="Enter Password">';
            newRow.appendChild(passwordCell);

            const roleCell = document.createElement("td");
            roleCell.innerHTML = '<select id="role" name="role[]" class="form-control"><option value="">Select Role</option><option value="0">User</option><option value="1">Assistant Admin</option><option value="2">Admin</option></select>';
            newRow.appendChild(roleCell);

            const actionCell = document.createElement("td");
            actionCell.innerHTML = '<button type="button" class="btn btn-sm btn-danger removeRow">Remove</button>';
            newRow.appendChild(actionCell);

            rowContainer.appendChild(newRow);
        });

        rowContainer.addEventListener("mouseup", function(event) {
            if (event.target.classList.contains("removeRow")) {
                event.target.closest("tr").remove();
            }
        })
    });
</script>
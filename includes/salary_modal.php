<!-- Add Expense Modal -->
<div class="modal fade" id="add_salary_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Pay Salary</h5>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-sm" id="addRow">Add Row</button>
                    </div>
                </div>
            </div>
            <form id="salaryForm" action="saveSalary">
                <div class="modal-body">
                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Amount (&#8358;)</th>
                                    <th>Month</th>
                                    <th>Remarks (optional)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rowContainer">
                                <tr>
                                    <td><input type="text" class="form-control text-gray-900" name="staff_name" id="staff-name" placeholder="Enter Staff Name"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="amount" id="amounts" placeholder="Enter Salary Amount" step="any"></td>
                                    <td>
                                        <select class="form-control" name="month" id="month">
                                            <option value="">Select Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </td>
                                    <td><textarea class="form-control text-gray-900" name="remarks" id="remark" placeholder="Enter Remarks"></textarea></td>
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


<!-- Update Expenses Modal -->
<div class="modal fade" id="update_salary_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Edit Salary</h5>
            </div>
            <form id="UpdateSalaryForm">
                <div class="modal-body">
                        <input type="hidden" name="update_salary_id" id="edit_salary_id">
                    <div class="row mt-2">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-gray-900">Staff Name</label>
                            <input type="text" class="form-control text-gray-900" name="update_staff_name" id="edit_staff_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-gray-900">Amount</label>
                            <input type="number" class="form-control text-gray-900" name="update_amount" id="edit_amount" step="any">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-gray-900">Month</label>
                            <select class="form-control" name="update_month" id="edit_month">
                                <option value="">Select Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-gray-900">Remarks</label>
                            <textarea class="form-control text-gray-900" name="update_remarks" id="edit_remarks" placeholder="Enter Remarks"></textarea>
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


<!-- Delete Salary Modal -->
<div class="modal" tabindex="-1" id="delete_salary_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-red">Warning</h3>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>
            </div>
            <form id="deleteSalaryForm">
            <div class="modal-body">
                <input type="hidden" name="delete_salary_id" id="delete_salary_id">
                <p><strong>Are you sure you want to delete this salary record?</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-danger">Yes</button>
            </div>
            </form>
        </div>
    </div>
</div>

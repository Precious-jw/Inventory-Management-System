<!-- Add Purchase Modal -->
<div class="modal fade" id="add_purchase_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Add Purchase</h5>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-sm" id="addRow">Add Row</button>
                    </div>
                </div>
            </div>
            <form id="purchasesForm" action="savePurchases">
                <div class="modal-body">
                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Amount (&#8358;)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rowContainer">
                                <tr>
                                    <td><input type="text" class="form-control text-gray-900" name="description" id="description" placeholder="Enter Purchase Description"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="quantity" id="quantity" placeholder="Enter Purchase Quantity" step="any"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="amount" id="amount" placeholder="Enter Purchase Amount" step="any"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Purchase Modal -->
<div class="modal fade" id="update_purchases_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Edit Purchase</h5>
            </div>
            <form id="UpdatePurchasesForm">
                <div class="modal-body">
                        <input type="hidden" name="update_purchases_id" id="edit_purchases_id">
                    <div class="row mt-2">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Description</label>
                            <input type="text" class="form-control text-gray-900" name="update_description" id="edit_description">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Quantity</label>
                            <input type="number" class="form-control text-gray-900" name="update_quantity" id="edit_quantity" step="any">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-gray-900">Amount</label>
                            <input type="number" class="form-control text-gray-900" name="update_amount" id="edit_amount" step="any">
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


<!-- Delete Purchase Modal -->
<div class="modal" tabindex="-1" id="delete_purchases_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-red">Warning</h3>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>
            </div>
            <form id="deletePurchaseForm">
            <div class="modal-body">
                <input type="hidden" name="delete_purchase_id" id="delete_purchase_id">
                <p><strong>Are you sure you want to delete this purchase?</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-danger">Yes</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addRow = document.getElementById("addRow");
        const rowContainer = document.getElementById("rowContainer");

        addRow.addEventListener("click", function() {
            const newRow = document.createElement("tr");

            const expenseCell = document.createElement("td");
            expenseCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="description" id="description" placeholder="Enter Purchase Description">';
            newRow.appendChild(expenseCell);

            const quantityCell = document.createElement("td");
            quantityCell.innerHTML = '<input type="number" class="form-control text-gray-900" name="quantity" id="quantity" placeholder="Enter Purchase Quantity" step="any">';
            newRow.appendChild(quantityCell);

            const amountCell = document.createElement("td");
            amountCell.innerHTML = '<input type="number" class="form-control text-gray-900" name="amount" id="amount" placeholder="Enter Purchase Amount" step="any">';
            newRow.appendChild(amountCell);

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
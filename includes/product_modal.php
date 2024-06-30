<!-- Add Product Modal -->
<div class="modal fade" id="add_product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Add Product</h5>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-sm" id="addRow">Add Row</button>
                    </div>
                </div>
            </div>
            <form id="productForm" action="saveProduct">
                <div class="modal-body">
                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Purchase Price</th>
                                    <th>Sale Price</th>
                                    <th>Product Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rowContainer">
                                <tr>
                                    <td><input type="text" class="form-control text-gray-900" name="product[]" id="product" placeholder="Enter Product Name"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="purchase_price[]" id="purchase_price" placeholder="Enter Purchase Price"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="sale_price[]" id="sale_price" placeholder="Enter Sale Price"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="quantity[]" id="quantity" placeholder="Enter Quantity"></td>
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
<div class="modal fade" id="update_product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Edit Product</h5>
            </div>
            <form id="UpdateProductForm">
                <div class="modal-body">
                        <input type="hidden" name="update_product_id" id="edit_product_id">
                    <div class="row mt-2">
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-gray-900">Product Name</label>
                            <input type="text" class="form-control text-gray-900" name="update_product" id="edit_product">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-gray-900">Purchase Price</label>
                            <input type="number" class="form-control text-gray-900" name="update_purchase_price" id="edit_purchase_price">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-gray-900">Sale Price</label>
                            <input type="number" class="form-control text-gray-900" name="update_sale_price" id="edit_sale_price">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label text-gray-900">Quantity</label>
                            <input type="number" class="form-control text-gray-900" name="update_qty" id="edit_qty">
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


<!-- Delete Product Modal -->
<div class="modal" tabindex="-1" id="delete_product_modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title text-red">Warning</h3>
        <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>
      </div>
        <form id="deleteProductForm">
        <div class="modal-body">
        <input type="hidden" name="delete_product_id" id="delete_product_id">
        <p><strong>Are you sure you want to delete this product?</strong></p>
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

            const productNameCell = document.createElement("td");
            productNameCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="product[]" id="product" placeholder="Enter Product Name">';
            newRow.appendChild(productNameCell);

            const purchasePriceCell = document.createElement("td");
            purchasePriceCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="purchase_price[]" id="purchase_price" placeholder="Enter Purchase Price">';
            newRow.appendChild(purchasePriceCell);

            const salePriceCell = document.createElement("td");
            salePriceCell.innerHTML = '<input type="text" class="form-control text-gray-900" name="sale_price[]" id="sale_price" placeholder="Enter sale Price">';
            newRow.appendChild(salePriceCell);

            const quantityCell = document.createElement("td");
            quantityCell.innerHTML = '<input type="number" class="form-control text-gray-900" name="quantity[]" id="quantity" placeholder="Enter Quantity">';
            newRow.appendChild(quantityCell);

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
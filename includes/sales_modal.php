<!-- Add Sale Modal -->
<div class="modal fade" id="add_sales_modal" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Add new Sales</h5>
      </div>
      <form id="saleForm" action="">
        <div class="modal-body">
          <div class="container-fluid">

            <!-- 🛒 Product Selection Section -->
            <div class="table-responsive mb-4">
              <table class="table table-bordered" id="productsTable">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Product Name</th>
                    <th>Price (₦)</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="productRows">
                  <tr>
                    <td>
                      <select class="form-control select_product">
                        <option value="">Search Product</option>
                        <?php
                        $sql = "SELECT *, product.id AS product_id FROM product";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                          foreach ($result as $row) {
                            echo '<option data-wholesale="'.$row['sale_price'].'" data-qty="'.$row['product_qty'].'" data-retail="'.$row['retail_price'].'" value="' . $row['product_id'] . '">' . $row['product_name'] . '</option>';
                          }
                        }
                        $stmt->close();
                        ?>
                      </select>
                    </td>
                    <td><input type="text" readonly class="form-control product_name"></td>
                    <td>
                      <select class="form-control purchase_price">
                        <option value="">Select Price</option>
                      </select>
                    </td>
                    <td><input type="number" class="form-control quantity" step="any"></td>
                    <td><input type="number" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                  </tr>
                </tbody>
              </table>
              <button type="button" id="addProductRow" class="btn btn-primary">Add Product</button>
            </div>

            <!-- 👤 Customer Info Section -->
            <div class="row g-3 mb-4">
              <div class="col-md-2">
                <label for="total" class="form-label text-black">Total</label>
                <input type="number" readonly class="form-control text-gray-900" name="total" id="total" value="" step="any">
              </div>

              <div class="col-md-4">
                <label for="customer_name" class="form-label text-black">Customer Name <strong style="color:red">*</strong></label>
                <input type="text" class="form-control text-gray-900" name="customer_name" id="customer-name">
              </div>

              <div class="col-md-4">
                <label for="customer_phone" class="form-label text-black">Customer Phone Number</label>
                <input type="number" class="form-control text-gray-900" name="customer_phone" id="customer_phone">
              </div>

              <div class="col-md-2">
                <label for="select_payment" class="form-label text-black">Payment Method <strong style="color:red">*</strong></label>
                <select id="select_payment" name="payment" class="form-control text-gray-900">
                  <option value="">Select Method</option>
                  <option value="Cash">Cash</option>
                  <option value="Transfer">Transfer</option>
                  <option value="POS">POS</option>
                </select>
              </div>
            </div>

            <!-- 💵 Payment Summary -->
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <label for="discount" class="form-label text-black">Discount Amount (₦)</label>
                <input type="number" class="form-control text-gray-900" name="discount" id="discount" value="" step="any">
              </div>

              <div class="col-md-4">
                <label for="paid" class="form-label text-black">Amount Paid (₦) <strong style="color:red">*</strong></label>
                <input type="number" class="form-control text-gray-900" name="paid" id="paid" value="" step="any">
              </div>

              <div class="col-md-4">
                <label for="grand_total" class="form-label text-black">Remaining Amount</label>
                <input type="number" readonly class="form-control text-gray-900" name="grand_total" id="grand_total" value="" step="any">
              </div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-12">
                <label for="comments" class="form-label text-black">Comments (Optional)</label>
                <textarea class="form-control text-gray-900" name="comments" id="comments"></textarea>
              </div>
            </div>

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

<!-- Update Sales Modal -->
<div class="modal fade" id="update_sales_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Edit Sale</h5>
      </div>
      <form id="UpdateSaleForm">
        <div class="modal-body">
          <input type="hidden" name="update_sale_id" id="edit_sale_id">

          <!-- 🛒 Product Section -->
          <div class="table-responsive mb-4">
            <table class="table table-bordered" id="editProductsTable">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Product Name</th>
                  <th>Price (₦)</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="editProductRows">
                <!-- JS will populate rows here -->
              </tbody>
            </table>
            <button type="button" id="addEditProductRow" class="btn btn-primary">Add Product</button>
          </div>

          <!-- 👤 Customer Info Section -->
          <div class="row g-3 mb-4">
            <div class="col-md-2">
              <label for="edit_product_total" class="form-label text-black">Total</label>
              <input type="number" readonly class="form-control text-gray-900" name="update_product_total" id="edit_product_total" value="" step="any">
            </div>
            <div class="col-md-4">
              <label for="edit_customer_name" class="form-label text-black">Customer Name <strong style="color:red">*</strong></label>
              <input type="text" class="form-control text-gray-900" name="update_customer_name" id="edit_customer_name">
            </div>
            <div class="col-md-4">
              <label for="edit_customer_phone" class="form-label text-black">Customer Phone Number</label>
              <input type="number" class="form-control text-gray-900" name="update_customer_phone" id="edit_customer_phone">
            </div>
            <div class="col-md-2">
              <label for="edit_select_payment" class="form-label text-black">Payment Method <strong style="color:red">*</strong></label>
              <select id="edit_select_payment" name="update_payment" class="form-control text-gray-900">
                <option value="">Select Method</option>
                <option value="Cash">Cash</option>
                <option value="Transfer">Transfer</option>
                <option value="POS">POS</option>
              </select>
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <label for="edit_discount" class="form-label text-black">Discount Amount (₦)</label>
              <input type="number" class="form-control text-gray-900" name="update_discount" id="edit_discount" value="" step="any">
            </div>
            <div class="col-md-4">
              <label for="edit_paid" class="form-label text-black">Amount Paid (₦) <strong style="color:red">*</strong></label>
              <input type="number" class="form-control text-gray-900" name="update_paid" id="edit_paid" value="" step="any">
            </div>
            <div class="col-md-4">
              <label for="edit_total" class="form-label text-black">Amount Remaining</label>
              <input type="number" readonly class="form-control text-gray-900" name="update_total" id="edit_total" placeholder="₦00.00" step="any">
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-12">
              <label for="edit_comments" class="form-label text-black">Comments (Optional)</label>
              <textarea class="form-control text-gray-900" name="update_comments" id="edit_comments"></textarea>
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


<!-- Delete Sales Modal -->
<div class="modal" tabindex="-1" id="delete_sales_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-danger">Warning</h3>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form id="deleteSaleForm">
              <div class="modal-body">
                  <input type="hidden" name="delete_sale_id" id="delete_sale_id">
                  <p><strong>Are you sure you want to delete this Sales Record?</strong></p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="submit" class="btn btn-danger">Yes</button>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- Return Sales Modal -->
<div class="modal" tabindex="-1" id="return_sales_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-danger">Warning</h3>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <form id="returnSaleForm">
              <div class="modal-body">
                  <input type="hidden" name="return_sale_id" id="return_sale_id">
                  <p><strong>Are you sure you want to return this Sales Record?</strong></p>
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
  var productOptions = [
  <?php
    $sql = "SELECT *, product.id AS product_id FROM product";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        foreach ($result as $row) {
            echo "{value: '{$row['product_id']}', text: '".addslashes($row['product_name'])."', wholesale: '{$row['sale_price']}', retail: '{$row['retail_price']}'},";
        }
    }
    $stmt->close();
  ?>
  ];
</script>

<script>
    $(document).ready(function() {
      /***************
       * Add Sales Section
       ***************/
      // Initialize Select2 for the first row in Add Sales Modal
      $('#productRows .select_product').select2({
          dropdownParent: $('#add_sales_modal'),
          width: '100%',
          minimumResultsForSearch: 5 // Show search if more than 5 items
      });

      // For dynamically added rows in Add Sales Modal
      $('#addProductRow').click(function() {
        var productSelect = '<select class="form-control select_product"><option value="">Search Product</option>';
        productOptions.forEach(function(opt) {
            productSelect += `<option value="${opt.value}" data-wholesale="${opt.wholesale}" data-retail="${opt.retail}" data-qty="100">${opt.text}</option>`;
        });
        productSelect += '</select>';

        var priceSelect = '<select class="form-control purchase_price"><option value="">Select Price</option></select>';

        var newRow = $(`<tr>
            <td>${productSelect}</td>
            <td><input type="text" readonly class="form-control product_name"></td>
            <td>${priceSelect}</td>
            <td><input type="number" class="form-control quantity" min="1"></td>
            <td><input type="number" class="form-control total" readonly></td>
            <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
        </tr>`);
        $('#productRows').append(newRow);

        // Remove Select2 container and reset select
        newRow.find('.select2-container').remove();
        newRow.find('.select_product').removeAttr('data-select2-id').removeAttr('aria-hidden').show();

        // Reset values in the cloned row
        newRow.find('input, select').val('');
        newRow.find('.purchase_price').empty().append('<option value="">Select Price</option>');
        newRow.find('.quantity').prop('disabled', false);

        // Append the cleaned row
        $('#productRows').append(newRow);

        // Re-initialize Select2 on the new select
        newRow.find('.select_product').select2({
            dropdownParent: $('#add_sales_modal'),
            width: '100%',
            minimumResultsForSearch: 5
        });
      });

      // Remove product row
      $('#productRows').on('click', '.removeRow', function() {
          if ($('#productRows tr').length > 1) {
              $(this).closest('tr').remove();
              updateGrandTotal();
              cal_final_total();
          }
      });

      // Product selection logic for each row
      $('#productRows').on('change', '.select_product', function() {
        var selected = $(this).find('option:selected');
        var wholesale = selected.data('wholesale');
        var retail = selected.data('retail');
        var name = selected.text();
        var selectedQty = selected.data('qty');
        var row = $(this).closest('tr');
        if (selected && selectedQty < 1) {
            alert('This product is out of stock!');
            row.find('.quantity').val('');
            row.find('.quantity').prop('disabled', true);
        } else {
            row.find('.quantity').prop('disabled', false);
        }
        row.find('.product_name').val(name);
        row.find('.purchase_price').empty()
            .append('<option value="">Select Price</option>')
            .append('<option value="' + wholesale + '">Wholesale Price (₦' + wholesale + ')</option>')
            .append('<option value="' + retail + '">Retail Price (₦' + retail + ')</option>');
        row.find('.quantity').val('');
        row.find('.total').val('');
        updateGrandTotal();
        cal_final_total();
    });

      // When price or quantity changes, update row total and grand total
      $('#productRows').on('keyup change', '.purchase_price, .quantity', function() {
          var row = $(this).closest('tr');
          var price = parseFloat(row.find('.purchase_price').val()) || 0;
          var qty = parseFloat(row.find('.quantity').val()) || 0;
          row.find('.total').val(price * qty);
          updateGrandTotal();
          cal_final_total();
      });

      // Calculate grand total for all products
      function updateGrandTotal() {
          var grandTotal = 0;
          $('#productRows .total').each(function() {
              grandTotal += parseFloat($(this).val()) || 0;
          });
          $('#total').val(grandTotal);
      }

      // Calculate amount remaining
      function cal_final_total() {
          var total = parseFloat($('#total').val()) || 0;
          var discount = parseFloat($('#discount').val()) || 0;
          var paid = parseFloat($('#paid').val()) || 0;
          var final_total = total - discount - paid;
          $('#grand_total').val(final_total);
      }

      $('#discount, #paid').on('keyup change', function() {
          cal_final_total();
      });

    });


    
</script>
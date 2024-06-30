<!-- Add Product Modal -->
<div class="modal fade" id="add_sales_modal" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-gray-900" id="exampleModalLabel">Add new Sales</h5>
                <!-- <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-sm" id="addRow">Add Row</button>
                    </div>
                </div> -->
            </div>
            <form id="saleForm" action="">
                <div class="modal-body">
                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Select Product</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rowContainer">
                                <tr>
                                    <td><select id="select_product" class="form-control text-gray-900" id="product" placeholder="Select Product">
                                            <option value="">Select Product</option>
                                            <?php
                                            $sql = "SELECT *, product.id AS product_id from product";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $num = 1;

                                                foreach ($result as $row) {
                                            ?>
                                                <option id="option" value="<?= $row['sale_price'] ?>"><?= $row['product_name']; ?></option>
                                            <?php
                                                    $num++;
                                                }
                                            }
                                            $stmt->close();
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="text" readonly class="form-control text-gray-900" name="product[]" id="product_name" value=""></td>
                                    <td><input type="number" readonly class="form-control text-gray-900" name="purchase_price[]" id="purchase_price" value="&#8358;00.00"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="quantity[]" id="quantity" placeholder="Enter Quantity"></td>
                                    <td><input type="text" readonly class="form-control text-gray-900" name="total[]" id="total" value="&#8358;00.00"></td>
                                    <td><select id="select_payment" name="payment[]" class="form-control">
                                            <option value="">Select Method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="POS">POS</option>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Phone Number</th>
                                    <th>Total Amount of all Items</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td><input type="text" class="form-control text-gray-900" name="customer_name[]" id="customer_name" placeholder="Enter Customer Name"></td>
                                <td><input type="number" class="form-control text-gray-900" name="customer_phone[]" id="customer_phone" placeholder="Enter Customer Phone No."></td>
                                <td><input type="number" readonly class="form-control text-gray-900" name="grand_total[]" id="grand_total" placeholder="&#8358;00.00"></td>
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
                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Select Product</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody id="rowContainer">
                                <tr>
                                    <td><select name="update_select_product" class="form-control text-gray-900" id="edit_select_product" placeholder="Select Product">
                                            <option value="">Select Product</option>
                                            <?php
                                            $sql = "SELECT *, product.id AS product_id from product";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $num = 1;

                                                foreach ($result as $row) {
                                            ?>
                                                <option id="option" value="<?= $row['sale_price'] ?>"><?= $row['product_name']; ?></option>
                                            <?php
                                                    $num++;
                                                }
                                            }
                                            $stmt->close();
                                            ?>
                                        </select>
                                    </td>
                                    <td><input type="text" readonly class="form-control text-gray-900" name="update_product" id="edit_product_name" value=""></td>
                                    <td><input type="number" readonly class="form-control text-gray-900" name="update_price" id="edit_price" value="&#8358;00.00"></td>
                                    <td><input type="number" class="form-control text-gray-900" name="update_quantity" id="edit_quantity" placeholder="Enter Quantity"></td>
                                    <td><select id="update_select_payment" name="update_payment" class="form-control">
                                            <option value="">Select Method</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="POS">POS</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="container table-responsive">
                        <table class="table table-bordered text-gray-900 mt-2">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Phone Number</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td><input type="text" class="form-control text-gray-900" name="update_customer_name" id="edit_customer_name" placeholder="Enter Customer Name"></td>
                                <td><input type="number" class="form-control text-gray-900" name="update_customer_phone" id="edit_customer_phone" placeholder="Enter Customer Phone No."></td>
                                <td><input type="number" readonly class="form-control text-gray-900" name="update_total" id="edit_total" placeholder="&#8358;00.00"></td>
                            </tbody>
                        </table>
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
<div class="modal" tabindex="-1" id="delete_sales_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-red">Warning</h3>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>
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
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#select_product').selectize({
            sortField: 'text'
        });
        $('#edit_select_product').selectize({
            sortField: 'text'
        });

        function cal_total() {
            var price = $('#purchase_price').val();
            var quantity = $('#quantity').val();
            var total = $('#total').val(price * quantity);
        }
        function edit_total(){
            var editPrice = $('#edit_price').val();
            var editQuantity = $('#edit_quantity').val();
            var editTotal = $('#edit_total').val(editPrice * editQuantity);
        }

        function cal_final_total() {
            var total = $('#total').val();
            var final_total = $('#grand_total').val(total);
            var grand_total = grand_total + final_total;
        }

        $('#quantity').keyup(function() {
            cal_total();
            cal_final_total();
        });
        $('#edit_quantity').keyup(function() {
            edit_total();
        });

    });

    // add the following onChange script
    $(document).ready(function() {
        $('#select_product').change(function() {
            var price = $(this);
            var purchase_price = $('#purchase_price').val(price.val());
            var name = $("#product_name").val(this.options[this.selectedIndex].text);
            var quantity = $('#quantity').val(0);
            var total = $('#total').val("00.00");
            var final_total = $('#grand_total').val("00.00");
        })
        $('#edit_select_product').change(function() {
            var price = $(this);
            var edit_price = $('#edit_price').val(price.val());
            var name = $("#edit_product_name").val(this.options[this.selectedIndex].text);
            var quantity = $('#edit_quantity').val(0);
            var total = $('#edit_total').val("00.00");
            var final_total = $('#grand_total').val("00.00");
        })

    });
</script>
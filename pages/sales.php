
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Sales</h1>
    </div>

        <div class="card shadow mb-4"> <!--begin::Container-->
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h6 class="m-0 mt-2">Search By date</h6>
                    </div>
                </div>
            </div>
            <div class="col-12">

                <form id="SearchSalesForm" method="post"> <!--begin::Body-->
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
                            <label><b>Customer Name</b></label> 
                            <input type="text" id="customer_name_search" name="customer_name_search" value="<?= isset($_POST['customer_name_search']) ? $_REQUEST['customer_name_search'] : '' ?>" class="form-control">
                        </div>
                        <div class="mb-3 form-group col-md-3"> 
                            <label><b>Product Name</b></label> 
                            <input type="text" id="product_name_search" name="product_name_search" value="<?= isset($_POST['product_name_search']) ? $_REQUEST['product_name_search'] : '' ?>" class="form-control">
                        </div>
                        <div class="mb-3 form-group col-md-3"> 
                            <label><b>Payment Method</b></label> 
                            <select id="payment_search" name="payment_search" class="form-control">
                                <option value="">Select Payment method</option>
                                <option <?= isset($_POST['payment_search']) ? ($_POST['payment_search'] == "Cash" ? "selected" : '') : ''?> value="Cash">Cash</option>
                                <option <?= isset($_POST['payment_search']) ? ($_POST['payment_search'] == "Transfer" ? "selected" : '') : ''?> value="Transfer">Transfer</option>
                                <option <?= isset($_POST['payment_search']) ? ($_POST['payment_search'] == "POS" ? "selected" : '') : ''?> value="POS">POS</option>
                            </select>
                        </div>
                        <div class="mt-2 form-group col-md-3"> 
                            <label><b></b></label> <br>
                            <button type="submit" class="btn btn-primary" name="search">Search</button> 
                            <a href="<?= base_url."sales" ?>" class="btn btn-success">Reset</a> 
                        </div>
                    </div> <!--end::Body--> <!--begin::Footer-->
                </form> <!--end::Form-->
            </div>
        </div> <!--end::App Content-->

        <div class="card shadow">
            <div class="card-header">
                <div class="row">
                    <div class="col"><h6 class="m-0 mt-2">Sales List</h6></div>
                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add_sales_modal">Add New</button>
                        <a href="php/sales/print_sales.php?dateFrom=<?= isset($_POST['dateFrom']) ? $_POST['dateFrom'] : '' ?>&dateTo=<?= isset($_POST['dateTo']) ? $_POST['dateTo'] : '' ?>&customer_name=<?= isset($_POST['customer_name']) ? $_POST['customer_name'] : '' ?>&product_name=<?= isset($_POST['product_name']) ? $_POST['product_name'] : '' ?>&payment=<?= isset($_POST['payment']) ? $_POST['payment'] : ''?>" target="_blank" class="btn btn-secondary btn-sm add-btn">Print PDF</a>
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
                                <th>Customer Name</th>
                                <th>Customer phone no.</th>
                                <th>Products Purchased</th>
                                <th>Discount</th>
                                <th>Amount Paid</th>
                                <th>Amount Remaining</th>
                                <th>Payment method</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Build search conditions
                                $conditions = [];
                                $params = [];
                                $types = "";

                                if (!empty($_POST['dateFrom'])) {
                                    $conditions[] = "sales.sale_date >= ?";
                                    $params[] = $_POST['dateFrom'];
                                    $types .= "s";
                                }
                                if (!empty($_POST['dateTo'])) {
                                    $conditions[] = "sales.sale_date < ? + INTERVAL 1 DAY";
                                    $params[] = $_POST['dateTo'];
                                    $types .= "s";
                                }
                                if (!empty($_POST['customer_name'])) {
                                    $conditions[] = "sales.customer_name LIKE ?";
                                    $params[] = "%" . $_POST['customer_name'] . "%";
                                    $types .= "s";
                                }
                                if (!empty($_POST['product_name'])) {
                                    $conditions[] = "p.product_name LIKE ?";
                                    $params[] = "%" . $_POST['product_name'] . "%";
                                    $types .= "s";
                                }
                                if (!empty($_POST['payment'])) {
                                    $conditions[] = "sales.payment_method = ?";
                                    $params[] = $_POST['payment'];
                                    $types .= "s";
                                }

                                $sql = "SELECT sales.*, sales.id as sales_id, 
                                    GROUP_CONCAT(
                                        CONCAT(
                                            '<b style=\"color:#007bff\">', p.product_name, '</b> (Qty: ', si.quantity, ', Price: ₦', si.price, ')<br>'
                                        ) SEPARATOR '||'
                                    ) AS products_list
                                    FROM sales
                                    LEFT JOIN sale_items si ON sales.id = si.sale_id
                                    LEFT JOIN product p ON si.product_id = p.id";

                                if (!empty($conditions)) {
                                    $sql .= " WHERE " . implode(" AND ", $conditions);
                                }
                                $sql .= " GROUP BY sales.id ORDER BY sales.sale_date DESC";

                                $stmt = $conn->prepare($sql);
                                if (!empty($params)) {
                                    $stmt->bind_param($types, ...$params);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();
                        ?>

                        <?php
                            if ($result->num_rows > 0) {
                                $num = 1;
                                foreach ($result as $row) {
                        ?>
                                    <tr>
                                        <td><?= $num; ?></td>
                                        <td><?= date('d-M-Y, D H:i A', strtotime($row['sale_date'])); ?></td>
                                        <td><?= $row['customer_name']; ?></td>
                                        <td><?= $row['customer_phone']; ?></td>
                                        <td><?php
                                                $products = explode('||', $row['products_list']);
                                                foreach ($products as $i => $prod) {
                                                    echo ($i + 1) . '. ' . $prod . '<br>';
                                                }
                                            ?>
                                        </td>
                                        <td>&#8358;<?= number_format($row['discount'], 2); ?></td>
                                        <td>&#8358;<?= number_format($row['paid'], 2); ?></td>
                                        <td>&#8358;<?= number_format($row['grand_total'], 2); ?></td>
                                        <td><?= $row['payment_method']; ?></td>
                                        <td><?= $row['comments']; ?></td>
                                        <td>
                                            <button name="edit_sale" style="width: 80%" class="btn btn-primary btn-sm m-1" onclick="updateSales(<?= $row['sales_id']; ?>)">Edit</button>
                                            <a href="php/sales/print_sales.php?id=<?= $row['sales_id']; ?>" target="_blank" class="btn btn-secondary btn-sm m-1">Print PDF</a> <br>
                                            <?php if(isset($_SESSION["role"]) && $_SESSION["role"] == 2){
                                                echo '<button class="btn btn-danger btn-sm" style="width: 100%; margin-bottom: 5px" onclick="deleteSales(' . $row['sales_id'] . ')">Delete</button>';
                                                echo '<button class="btn btn-warning btn-sm" style="width: 100%" onclick="returnSales(' . $row['sales_id'] . ')">Return Sales</button>';
                                            } ?>
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
include('includes/sales_modal.php');
?>

<script>
    
    // Helper to build product select options
    function buildProductSelect(selectedId) {
        var html = '<select class="form-control select_product">';
        html += '<option value="">Search Product</option>';
        productOptions.forEach(function(opt) {
            var selected = (opt.value == selectedId) ? 'selected' : '';
            html += `<option value="${opt.value}" data-wholesale="${opt.wholesale}" data-retail="${opt.retail}" ${selected}>${opt.text}</option>`;
        });
        html += '</select>';
        return html;
    }

    // Helper to build price select options
    function buildPriceSelect(wholesale, retail, selectedPrice) {
        var html = '<select class="form-control purchase_price">';
        html += '<option value="">Select Price</option>';
        html += `<option value="${wholesale}" ${selectedPrice == wholesale ? 'selected' : ''}>Wholesale Price (₦${wholesale})</option>`;
        html += `<option value="${retail}" ${selectedPrice == retail ? 'selected' : ''}>Retail Price (₦${retail})</option>`;
        html += '</select>';
        return html;
    }

    // Populate edit modal with sale data
    function updateSales(sales_id) {
        $("#edit_sale_id").val(sales_id);

        $.post("php/sales/get.php", { sales_id: sales_id }, function(data, status) {
            var sale = JSON.parse(data);

            // Customer/payment fields
            $('#edit_customer_name').val(sale.customer_name);
            $('#edit_customer_phone').val(sale.customer_phone);
            $('#edit_select_payment').val(sale.payment_method);
            $('#edit_discount').val(sale.discount);
            $('#edit_paid').val(sale.paid);
            $('#edit_total').val(sale.total_price);
            $('#edit_comments').val(sale.comments);

            // Product rows
            $('#editProductRows').empty();
            sale.items.forEach(function(item) {
                var wholesale = '';
                var retail = '';
                // Find wholesale/retail from productOptions
                productOptions.forEach(function(opt) {
                    if (opt.value == item.product_id) {
                        wholesale = opt.wholesale;
                        retail = opt.retail;
                    }
                });
                var productSelect = buildProductSelect(item.product_id);
                var priceSelect = buildPriceSelect(wholesale, retail, item.price);

                var row = $(`<tr>
                    <td>${productSelect}</td>
                    <td><input type="text" readonly class="form-control product_name" value="${item.product_name}"></td>
                    <td>${priceSelect}</td>
                    <td><input type="number" class="form-control quantity" value="${item.quantity}" step="any"></td>
                    <td><input type="number" class="form-control total" value="${item.total}" readonly></td>
                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                </tr>`);

                $('#editProductRows').append(row);

                // **Set the price select value to the saved price**
                row.find('.purchase_price').val(item.price);

                // **Initialize Select2 for this row's product select**
                row.find('.select_product').select2({
                    dropdownParent: $('#update_sales_modal'),
                    width: '100%',
                    minimumResultsForSearch: 5
                });
            });

            $("#update_sales_modal").modal("show");
            updateEditGrandTotal();
            cal_edit_final_total();
        });
    }

    // For dynamically added rows in Update Sales Modal
    $('#addEditProductRow').click(function() {
        var productSelect = buildProductSelect('');
        var priceSelect = buildPriceSelect('', '', '');
        var newRow = $(`<tr>
            <td>${productSelect}</td>
            <td><input type="text" readonly class="form-control product_name"></td>
            <td>${priceSelect}</td>
            <td><input type="number" class="form-control quantity" step="any"></td>
            <td><input type="number" class="form-control total" readonly></td>
            <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
        </tr>`);
        $('#editProductRows').append(newRow);

        // **Initialize Select2 for the new row**
        newRow.find('.select_product').select2({
            dropdownParent: $('#update_sales_modal'),
            width: '100%',
            minimumResultsForSearch: 5
        });
    });

    // Remove product row in edit modal
    $('#editProductRows').on('click', '.removeRow', function() {
        if ($('#editProductRows tr').length > 1) {
            $(this).closest('tr').remove();
            updateEditGrandTotal();
            cal_edit_final_total();
        }
    });

    // Product selection logic for each row in edit modal
    $('#editProductRows').on('change', '.select_product', function() {
        var selected = $(this).find('option:selected');
        var wholesale = selected.data('wholesale');
        var retail = selected.data('retail');
        var name = selected.text();
        var selectedQty = selected.data('qty');
        var row = $(this).closest('tr');

        // Get previously selected price if any
        var prevPrice = row.find('.purchase_price').val();

        if (selected && selectedQty < 1) {
            alert('This product is out of stock!');
            row.find('.quantity').val('');
            row.find('.quantity').prop('disabled', true);
        } else {
            row.find('.quantity').prop('disabled', false);
        }
        row.find('.product_name').val(name);

        // Build price select with previous price selected if it matches
        var priceSelectHtml = buildPriceSelect(wholesale, retail, prevPrice);
        row.find('.purchase_price').replaceWith(priceSelectHtml);

            // Set the selected price if it exists
            row.find('.purchase_price').val(prevPrice);

            row.find('.quantity').val('');
            row.find('.total').val('');
            updateEditGrandTotal();
            cal_edit_final_total();
    });

    // When price or quantity changes, update row total and grand total in edit modal
    $('#editProductRows').on('keyup change', '.purchase_price, .quantity', function() {
        var row = $(this).closest('tr');
        var price = parseFloat(row.find('.purchase_price').val()) || 0;
        var qty = parseFloat(row.find('.quantity').val()) || 0;
        row.find('.total').val(price * qty);
        updateEditGrandTotal();
        cal_edit_final_total();
    });

    // Calculate grand total for all products in edit modal
    function updateEditGrandTotal() {
        var grandTotal = 0;
        $('#editProductRows .total').each(function() {
            grandTotal += parseFloat($(this).val()) || 0;
        });
        $('#edit_product_total').val(grandTotal);
    }

    // Calculate amount remaining in edit modal
    function cal_edit_final_total() {
        var total = parseFloat($('#edit_product_total').val()) || 0;
        var discount = parseFloat($('#edit_discount').val()) || 0;
        var paid = parseFloat($('#edit_paid').val()) || 0;
        var final_total = total - discount - paid;
        $('#edit_total').val(final_total);
    }

    $('#edit_discount, #edit_paid').on('keyup change', function() {
        cal_edit_final_total();
    });

    // Get product to delete
    function deleteSales(sales_id) {
        $("#delete_sale_id").val(sales_id);

        $.post("php/sales/delete.php", {
            sales_id: sales_id
        }, function(data, status) {
            var id = JSON.parse(data);
        })
        $("#delete_sales_modal").modal("show"); //Show the modal
    }

    function returnSales(sales_id) {
        $("#return_sale_id").val(sales_id);

        $.post("php/sales/return.php", {
            sales_id: sales_id
        }, function(data, status) {
            var id = JSON.parse(data);
        })
        $("#return_sales_modal").modal("show"); //Show the modal
    }
</script>

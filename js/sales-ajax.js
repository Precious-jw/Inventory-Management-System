$(document).ready(function(){
    //Add Sales
    $("#saleForm").submit(function(event){
        event.preventDefault();

        // Collect products
        var products = [];
        $('#productRows tr').each(function() {
            products.push({
                product_id: $(this).find('.select_product').val(),
                product_name: $(this).find('.product_name').val(),
                price: $(this).find('.purchase_price').val(),
                quantity: $(this).find('.quantity').val(),
                total: $(this).find('.total').val()
            });
        });

        // Collect other fields
        var saleData = {
            customer_name: $("#customer-name").val(),
            customer_phone: $("#customer_phone").val(),
            payment: $("#select_payment").val(),
            paid: $("#paid").val(),
            discount: $("#discount").val(),
            grand_total: $("#grand_total").val(),
            comments: $("#comments").val(),
            products: products
        };

        //Check if the input fields are empty
        // Validation
        if (
            !saleData.customer_name ||
            !saleData.payment ||
            !saleData.paid ||
            saleData.paid < 0 ||
            saleData.products.length === 0 || 
            saleData.products.some(p => !p.product_id || !p.price || !p.quantity || p.quantity <= 0)
        ) {
            errorMessage("Please fill all required fields and add at least one valid product.");
            return;
        } else if(saleData.grand_total < 0){
            errorMessage("Discount and Amount Paid cannot be more than the total price of the products.");
            return;
        } else {
            //Send the date to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/sales/add.php",
                data: JSON.stringify(saleData),
                contentType: "application/json",
                success: function(response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                    } catch (e) {
                        errorMessage("Unexpected server response.");
                        return;
                    }
                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#add_sales_modal").modal("hide"); //Hide the modal
                        $("#saleForm")[0].reset(); //Reset the form after submission
                        $("#loader-container").show(); //Show the loader

                        //Reload the current page
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else if(jsonResponse.status_code === "error") {
                        $("#loader-container").hide(); //Hide the loader if there's an error
                    }
                }, 
                error: function(xhr, status, error){
                    var errorMessage = "An error occurred while adding the sale.";
                    if(xhr.responseText){
                        errorMessage = JSON.parse(xhr.responseText).status;
                    }
                    errorMessage(errorMessage);
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            })
        }
            
    });

    //Update Sales
    $("#UpdateSaleForm").submit(function(event){
        event.preventDefault();

        var products = [];
        $('#editProductRows tr').each(function() {
            products.push({
                product_id: $(this).find('.select_product').val(),
                product_name: $(this).find('.product_name').val(),
                price: $(this).find('.purchase_price').val(),
                quantity: $(this).find('.quantity').val(),
                total: $(this).find('.total').val()
            });
        });

        var saleData = {
            update_sale_id: $("#edit_sale_id").val(),
            customer_name: $("#edit_customer_name").val(),
            customer_phone: $("#edit_customer_phone").val(),
            payment: $("#edit_select_payment").val(),
            paid: $("#edit_paid").val(),
            discount: $("#edit_discount").val(),
            total: $("#edit_total").val(),
            comments: $("#edit_comments").val(),
            products: products
        };

        if (
            !saleData.customer_name ||
            !saleData.payment ||
            !saleData.paid ||
            saleData.paid < 0 ||
            saleData.products.length === 0 || 
            saleData.products.some(p => !p.product_id || !p.price || !p.quantity || p.quantity <= 0)
        ) {
            errorMessage("Please fill all required fields and add at least one valid product.");
            return;
        } else if(saleData.grand_total < 0){
            errorMessage("Discount and Amount Paid cannot be more than the total price of the products.");
            return;
        } else {
            $.ajax({
                type: "POST",
                url: "php/sales/update.php",
                data: JSON.stringify(saleData),
                contentType: "application/json",
                success: function(response) {
                    try {
                        console.log(response);
                        var jsonResponse = JSON.parse(response);
                    } catch (e) {
                        errorMessage("Unexpected server response.");
                        return;
                    }
    
                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );
    
                    if(jsonResponse.status_code === "success"){
                        $("#update_sales_modal").modal("hide"); //Hide the modal
                        $("#loader-container").show(); //Show the loader
    
                        //Reload the current page
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else if(jsonResponse.status_code === "error") {
                        $("#loader-container").hide(); //Hide the loader if there's an error
                    }
                }, 
                error: function(xhr, status, error){
                    var errorMessage = "An error occurred while updating the sale.";
                    if(xhr.responseText){
                        errorMessage = JSON.parse(xhr.responseText).status;
                    }
                    errorMessage(errorMessage);
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            })
        }
    });

    //Delete Sales
    $("#deleteSaleForm").submit(function(event){
        event.preventDefault();
        
        //Send the data to the PHP Script using AJAX
        $.ajax({
            type: "POST",
            url: "php/sales/delete.php",
            data: $(this).serialize() + "&action=deleteSale",
            success: function (response){
                try {
                    var jsonResponse = JSON.parse(response);
                } catch (e) {
                    errorMessage("Unexpected server response.");
                    return;
                }

                //Display the message
                successMessage(
                    jsonResponse.status_code === "error" ? "error" : "success",
                    jsonResponse.status
                );

                if(jsonResponse.status_code === "success"){
                    $("#delete_sales_modal").modal("hide"); //Hide the modal
                    $("#loader-container").show(); //Show the loader

                    //Reload the current page
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else if(jsonResponse.status_code === "error") {
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            }, 
            error: function(xhr, status, error){
                var errorMessage = "An error occurred while deleting the sale.";
                if(xhr.responseText){
                    errorMessage = JSON.parse(xhr.responseText).status;
                }
                errorMessage(errorMessage);
                $("#loader-container").hide(); //Hide the loader if there's an error
            }
        })
    });

    //Return Sales
    $("#returnSaleForm").submit(function(event){
        event.preventDefault();
        
        //Send the data to the PHP Script using AJAX
        $.ajax({
            type: "POST",
            url: "php/sales/return.php",
            data: $(this).serialize() + "&action=returnSale",
            success: function (response){
                try {
                    var jsonResponse = JSON.parse(response);
                } catch (e) {
                    errorMessage("Unexpected server response.");
                    return;
                }

                //Display the message
                successMessage(
                    jsonResponse.status_code === "error" ? "error" : "success",
                    jsonResponse.status
                );

                if(jsonResponse.status_code === "success"){
                    $("#return_sales_modal").modal("hide"); //Hide the modal
                    $("#loader-container").show(); //Show the loader

                    //Reload the current page
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else if(jsonResponse.status_code === "error") {
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            }, 
            error: function(xhr, status, error){
                var errorMessage = "An error occurred while returning the sale.";
                if(xhr.responseText){
                    errorMessage = JSON.parse(xhr.responseText).status;
                }
                errorMessage(errorMessage);
                $("#loader-container").hide(); //Hide the loader if there's an error
            }
        })
    });
})
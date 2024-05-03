$(document).ready(function(){
    //Add Sales
    $("#saleForm").submit(function(event){
        event.preventDefault();
        
        //Get the Data from the input
        var customer_name = $("#customer_name").val();
        var customer_phone = $("#customer_phone").val();
        var product = $("#product").val();
        var quantity = $("#quantity").val();
        var total_price = $("#grand_total").val();
        var payment = $("#select_payment").val();

        //Check if the input fields are empty
        if(customer_name === "" || customer_phone === "" || product === "" || quantity === "" || payment === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the date to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/sales/add.php",
                data: $(this).serialize() + "$action=addSales",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

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

    //Update Product
    $("#UpdateSaleForm").submit(function(event){
        event.preventDefault();
        var updateQuantity = $("#edit_quantity").val();
        var updatePayment = $("#update_select_payment").val();
        var edit_customer_name = $("#edit_customer_name").val();
        var edit_customer_phone = $("#edit_customer_phone").val();

        if(updatePayment === ""){
            errorMessage("Select a payment method");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else if (updateQuantity == 0) {
            errorMessage("Enter a quantity");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else if (edit_customer_name === "" || edit_customer_phone === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/sales/update.php",
                data: $(this).serialize() + "$action=updateSales",
                success: function (response){
                    var jsonResponse = JSON.parse(response);
    
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
            data: $(this).serialize() + "$action=deleteSale",
            success: function (response){
                var jsonResponse = JSON.parse(response);

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
})
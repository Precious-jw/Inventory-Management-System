$(document).ready(function(){
    //Add Product
    $("#productForm").submit(function(event){
        event.preventDefault();
        
        //Get the Data from the input
        var product_name = $("#product").val();
        var purchase_price = $("#purchase_price").val();
        var sale_price = $("#sale_price").val();
        var retail_price = $("#retail_price").val();
        var quantity = $("#quantity").val();
        var threshold = $("#threshold").val();

        //Check if the input fields are empty
        if(product_name === "" || purchase_price === "" || sale_price === "" || retail_price === "" || quantity === "" || threshold === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/product/add.php",
                data: $(this).serialize() + "&action=saveProduct",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#add_product_modal").modal("hide"); //Hide the modal
                        $("#productForm")[0].reset(); //Reset the form after submission
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
                    var errorMessage = "An error occurred while saving the product.";
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
    $("#UpdateProductForm").submit(function(event){
        event.preventDefault();
        
        //Get the Data from the input
        var product_name = $("#edit_product").val();
        var purchase_price = $("#edit_purchase_price").val();
        var sale_price = $("#edit_sale_price").val();
        var retail_price = $("#edit_retail_price").val();
        var edit_qty = $("#edit_qty").val();
        var edit_threshold = $("#edit_threshold").val();

        //Check if the input fields are empty
        if(product_name === "" || purchase_price === "" || sale_price === "" || retail_price === "" || edit_qty == "" || edit_threshold == ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the date to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/product/update.php",
                data: $(this).serialize() + "&action=updateProduct",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#update_product_modal").modal("hide"); //Hide the modal
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
                    var errorMessage = "An error occurred while updating the product.";
                    if(xhr.responseText){
                        errorMessage = JSON.parse(xhr.responseText).status;
                    }
                    errorMessage(errorMessage);
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            })
        }
    });

    //Delete Product
    $("#deleteProductForm").submit(function(event){
        event.preventDefault();
        
        //Send the data to the PHP Script using AJAX
        $.ajax({
            type: "POST",
            url: "php/product/delete.php",
            data: $(this).serialize() + "&action=deleteProduct",
            success: function (response){
                var jsonResponse = JSON.parse(response);

                //Display the message
                successMessage(
                    jsonResponse.status_code === "error" ? "error" : "success",
                    jsonResponse.status
                );

                if(jsonResponse.status_code === "success"){
                    $("#delete_product_modal").modal("hide"); //Hide the modal
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
                var errorMessage = "An error occurred while deleting the product.";
                if(xhr.responseText){
                    errorMessage = JSON.parse(xhr.responseText).status;
                }
                errorMessage(errorMessage);
                $("#loader-container").hide(); //Hide the loader if there's an error
            }
        })
    });
})
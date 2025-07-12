$(document).ready(function(){
    //Add Product
    $("#expensesForm").submit(function(event){
        event.preventDefault();

        //Get the Data from the input
        var description = $("#description").val();
        var amount = $("#amount").val();

        //Check if the input fields are empty
        if(description === "" || amount === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/expenses/add.php",
                data: $(this).serialize() + "$action=saveExpenses",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#add_expense_modal").modal("hide"); //Hide the modal
                        $("#expensesForm")[0].reset(); //Reset the form after submission
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
    $("#UpdateExpensesForm").submit(function(event){
        event.preventDefault();
        
        //Get the Data from the input
        var description = $("#edit_description").val();
        var amount = $("#edit_amount").val();

        //Check if the input fields are empty
        if(description === "" || amount === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the date to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/expenses/update.php",
                data: $(this).serialize() + "$action=updateExpenses",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#update_expenses_modal").modal("hide"); //Hide the modal
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
                    var errorMessage = "An error occurred while updating the expense.";
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
    $("#deleteExpenseForm").submit(function(event){
        event.preventDefault();
        
        //Send the data to the PHP Script using AJAX
        $.ajax({
            type: "POST",
            url: "php/expenses/delete.php",
            data: $(this).serialize() + "$action=deleteExpense",
            success: function (response){
                var jsonResponse = JSON.parse(response);

                //Display the message
                successMessage(
                    jsonResponse.status_code === "error" ? "error" : "success",
                    jsonResponse.status
                );

                if(jsonResponse.status_code === "success"){
                    $("#delete_expenses_modal").modal("hide"); //Hide the modal
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
                var errorMessage = "An error occurred while deleting the expense.";
                if(xhr.responseText){
                    errorMessage = JSON.parse(xhr.responseText).status;
                }
                errorMessage(errorMessage);
                $("#loader-container").hide(); //Hide the loader if there's an error
            }
        })
    });

    
})
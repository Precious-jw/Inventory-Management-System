$(document).ready(function(){
    //Add Product
    $("#salaryForm").submit(function(event){
        event.preventDefault();

        //Get the Data from the input
        var name = $("#staff-name").val();
        var amount = $("#amounts").val();
        var month = $("#month").val();

        //Check if the input fields are empty
        if(name === "" || amount === "" || month === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/salary/add.php",
                data: $(this).serialize() + "&action=saveSalary",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#add_salary_modal").modal("hide"); //Hide the modal
                        $("#salaryForm")[0].reset(); //Reset the form after submission
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
                    var errorMessage = "An error occurred while saving the Salary.";
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
    $("#UpdateSalaryForm").submit(function(event){
        event.preventDefault();
        
        //Get the Data from the input
        var name = $("#edit_staff_name").val();
        var amount = $("#edit_amount").val();
        var month = $("#edit_month").val();
        var remarks = $("#edit_remarks").val();

        //Check if the input fields are empty
        if(name === "" || amount === "" || month === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the date to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/salary/update.php",
                data: $(this).serialize() + "&action=updateSalary",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#update_salary_modal").modal("hide"); //Hide the modal
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
                    var errorMessage = "An error occurred while updating the salary.";
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
    $("#deleteSalaryForm").submit(function(event){
        event.preventDefault();
        
        //Send the data to the PHP Script using AJAX
        $.ajax({
            type: "POST",
            url: "php/salary/delete.php",
            data: $(this).serialize() + "&action=deleteSalary",
            success: function (response){
                var jsonResponse = JSON.parse(response);

                //Display the message
                successMessage(
                    jsonResponse.status_code === "error" ? "error" : "success",
                    jsonResponse.status
                );

                if(jsonResponse.status_code === "success"){
                    $("#delete_salary_modal").modal("hide"); //Hide the modal
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
                var errorMessage = "An error occurred while deleting the salary.";
                if(xhr.responseText){
                    errorMessage = JSON.parse(xhr.responseText).status;
                }
                errorMessage(errorMessage);
                $("#loader-container").hide(); //Hide the loader if there's an error
            }
        })
    });
    
})
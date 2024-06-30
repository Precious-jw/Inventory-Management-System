$(document).ready(function(){
    //Add User
    $("#userForm").submit(function(event){
        event.preventDefault();
        
        //Get the Data from the input
        var name = $("#name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var role = $("#role").val();

        //Check if the input fields are empty
        if(name === "" || email === "" || phone === "" || username === "" || password === "" || role === ""){
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/users/add.php",
                data: $(this).serialize() + "$action=addUser",
                success: function (response){
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if(jsonResponse.status_code === "success"){
                        $("#add_user_modal").modal("hide"); //Hide the modal
                        $("#userForm")[0].reset(); //Reset the form after submission
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
                    var errorMessage = "An error occurred while adding the user";
                    if(xhr.responseText){
                        errorMessage = JSON.parse(xhr.responseText).status;
                    }
                    errorMessage(errorMessage);
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            })
        }
    });
    
    //Update User
    $("#UpdateUserForm").submit(function(event){
        event.preventDefault();
        var edit_name = $("#edit_name").val();
        var edit_email = $("#edit_email").val();
        var edit_phone = $("#edit_phone").val();
        var edit_username = $("#edit_username").val();
        var edit_password = $("#edit_password").val();
        var edit_role = $("#edit_role").val();

        if (edit_name == "" || edit_email == "" || edit_phone == "" || edit_username == "" || edit_password == "" || edit_role == "") {

        } else {
            //Send the date to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/users/update.php",
                data: $(this).serialize(),
                success: function (response){
                    var jsonResponse = JSON.parse(response);
    
                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );
    
                    if(jsonResponse.status_code === "success"){
                        $("#update_user_modal").modal("hide"); //Hide the modal
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
                    var errorMessage = "An error occurred while updating the User records.";
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
    $("#deleteUserForm").submit(function(event){
        event.preventDefault();
        
        //Send the data to the PHP Script using AJAX
        $.ajax({
            type: "POST",
            url: "php/users/delete.php",
            data: $(this).serialize() + "$action=deleteUser",
            success: function (response){
                var jsonResponse = JSON.parse(response);

                //Display the message
                successMessage(
                    jsonResponse.status_code === "error" ? "error" : "success",
                    jsonResponse.status
                );

                if(jsonResponse.status_code === "success"){
                    $("#delete_user_modal").modal("hide"); //Hide the modal
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
                var errorMessage = "An error occurred while deleting the user.";
                if(xhr.responseText){
                    errorMessage = JSON.parse(xhr.responseText).status;
                }
                errorMessage(errorMessage);
                $("#loader-container").hide(); //Hide the loader if there's an error
            }
        })
    });
})
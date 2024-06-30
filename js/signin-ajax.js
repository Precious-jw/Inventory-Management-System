$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        //Get the Data from the input
        var username = $("#username").val();
        var password = $("#password").val();

        //Check if the input fields are empty
        if (username === "" || password === "") {
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/users/signin.php",
                data: $(this).serialize(),
                success: function (response) {
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if (jsonResponse.status_code === "success") {
                        //$("#loginForm")[0].reset(); //Reset the form after submission
                        $("#loader-container").show(); //Show the loader

                        //Reload the current page
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                    } else if (jsonResponse.status_code === "error") {
                        $("#loader-container").hide(); //Hide the loader if there's an error
                    }
                },
                error: function (xhr, status, error) {
                    var errorMessage = "An error occurred while trying to login.";
                    if (xhr.responseText) {
                        errorMessage = JSON.parse(xhr.responseText).status;
                    }
                    errorMessage(errorMessage);
                    $("#loader-container").hide(); //Hide the loader if there's an error
                }
            })
        }
    });
})
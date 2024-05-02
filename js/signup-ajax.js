$(document).ready(function () {
    $("#register").submit(function (event) {
        event.preventDefault();
        //Get the Data from the input
        var name = $("#name").val();
        var email = $("#email").val();
        var business_name = $("#business_name").val();
        var address = $("#address").val();
        var phone = $("#phone").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();

        //Check if the input fields are empty
        if (name === "" || email === "" || business_name === "" || address === "" || phone === "" || username === "" || password === "" || confirm_password === "") {
            errorMessage("All fields are required");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else if (password.length < 8) {
            errorMessage("passwords must be at least 8 characters");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else if (password !== confirm_password) {
            errorMessage("passwords do not match");
            $("#loader-container").hide(); //Hide the loader if there's an error
        } else {
            //Send the data to the PHP Script using AJAX
            $.ajax({
                type: "POST",
                url: "php/users/signup.php",
                data: $(this).serialize(),
                success: function (response) {
                    var jsonResponse = JSON.parse(response);

                    //Display the message
                    successMessage(
                        jsonResponse.status_code === "error" ? "error" : "success",
                        jsonResponse.status
                    );

                    if (jsonResponse.status_code === "success") {
                        $("#register")[0].reset(); //Reset the form after submission
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
                    var errorMessage = "An error occurred while registering";
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

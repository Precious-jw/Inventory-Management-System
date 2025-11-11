<!-- Loader -->
<div id="loader-container">
    <div class="loader"></div>
</div>  

<style>
    .main-content-wrapper{
        margin-left: 14rem;
        
    }

    @media (max-width: 768px) {
        .main-content-wrapper{
            margin-left: 6.5rem;
        }
    }
</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content" class="main-content-wrapper">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="container p-2 navbar-nav row" style="max-width: 100%;">
                <div class="nav-item">
                    <h3><?= isset($_SESSION["business_name"]) ? strtoupper($_SESSION["business_name"]) : strtoupper("Inventory Management System"); ?></h3>
                </div>

                <!-- Nav Item - User Information -->
                <?php 
                    if(isset($_SESSION["username"])){
                        echo "<li class='nav-item dropdown no-arrow ml-auto'>
                        <a class='nav-link dropdown-toggle' href='#' id='userDropdown' role='button'
                            data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <span class='mr-2 d-lg-inline text-gray-600'>Welcome, ".$_SESSION["username"]."</span>
                            <img class='img-profile rounded-circle'
                                src='img/undraw_profile.svg'>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class='dropdown-menu dropdown-menu-right shadow animated--grow-in'
                            aria-labelledby='userDropdown'>
                            <a class='dropdown-item' href='#'>
                                <i class='fas fa-user fa-sm fa-fw mr-2 text-gray-400'></i>
                                Account
                            </a>
                            <div class='dropdown-divider'></div>
                            <form id='logout'>
                                <input type='hidden' value='true' name='log_out'>
                                <button class='dropdown-item' type='submit' name='logout_button' data-toggle='modal'>
                                    <i class='fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400'></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                        </li>";
                    } else {
                        echo ("");
                    }
                ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <script type="text/javascript">

            $(document).ready(function () {
                $("#logout").submit(function (event){
                    event.preventDefault();
                    //Send the data to the PHP Script using AJAX
                    $.ajax({
                        type: "POST",
                        url: "php/users/logout.php",
                        data: $(this).serialize(),
                        success: function (response) {
                            var jsonResponse = JSON.parse(response);

                            //Display the message
                            successMessage(
                                jsonResponse.status_code === "error" ? "error" : "success",
                                jsonResponse.status
                            );

                            if (jsonResponse.status_code === "success") {
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
                            var errorMessage = "An error occurred while trying to logout.";
                            if (xhr.responseText) {
                                errorMessage = JSON.parse(xhr.responseText).status;
                            }
                            errorMessage(errorMessage);
                            $("#loader-container").hide(); //Hide the loader if there's an error
                        }
                    })
                });
            })

        </script>
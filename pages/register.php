<?php

if (isset($_SESSION['username'])){
    redirect(base_url."dashboard");
}
        
?>

<!-- Loader -->
<div id="loader-container">
    <div class="loader"></div>
</div>       
<div class="container-fluid row">  
    <div class="col-lg-9 m-auto">
            <div class="d-sm-flex justify-content-between mb-4 text-center">
                <h1 class="h3 mb-0 text-gray-900 bold">Admin Registration Form</h1>
            </div>
        <form id="register" name="register" action="register" class="needs-validation shadow p-5" novalidate>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="name">Enter Your Name</label>
                <input type="text" class="form-control" id="name" placeholder="John Doe" name="admin_name">
                </div>
                <div class="col-md-6 mb-3">
                <label for="email">Enter Your Email</label>
                <input type="text" class="form-control" id="email" placeholder="johndoe@gmail.com" name="admin_email">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="business_name">Business Name</label>
                <input type="text" class="form-control" id="business_name" placeholder="John Doe Emterprises" name="business_name">
                </div>
                <div class="col-md-6 mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" placeholder="No. 1 John Doe Street" name="admin_address">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="phone">Phone Number</label>
                <input type="number" class="form-control" id="phone" placeholder="08012345678" name="phone">
                </div>
                <div class="col-md-6 mb-3">
                <label for="username">Enter Username</label>
                <input type="text" class="form-control" id="username" placeholder="JohnDoe123" name="username">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="password">Enter Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                </div>
                <div class="col-md-6 mb-3">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                </div>
            </div>
            <button class="btn btn-primary" type="submit" name="submit[]">Register</button>
        </form>
    </div>
    
</div>

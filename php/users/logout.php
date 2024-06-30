<?php 
    session_start();

if (isset($_POST['log_out'])){
    //Send a success message
    $response['status'] = 'Logging out';
    $response['status_code'] = 'success';
    //Send JSON response
    echo json_encode($response);

    session_destroy();

} else {
    $response['status'] = 'Bad request';
    $response['status_code'] = 'error';
    //Send JSON response
    echo json_encode($response);
}

?>
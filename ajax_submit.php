<?php
// Recipient email
$toEmail = lakaydro@gmail.com;

$status = 0;
$statusMsg = 'Something went wrong! Please try again.';
if(isset($_POST['contact_submit'])){
  // Get the submitted form data
  $email = $_POST['email'];
  $name = $_POST['name'];
  $message = $_POST['message'];

  // check if data submission isempty or not
  if(!empty($email) && !empty($name) && !empty($message)){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)=== false){
      $statusMsg = 'Please enter a valid email address.';
    } else {
      $emailSubject = 'Contact Request Submitted by '.$name;
      $htmlContent = '<h2>Contact Request Submitted</h2>
<h4>Name</h4><p>'.$name.'</p>
<h4>Email</h4><p>'.$email.'</p>
<h4>Message</h4><p>'.$message.'</p>';

      // Set content-type header for sending HTML email 
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .="Content-type:text/html;charset=UTF-8" . "\r\n";

      // Additional Headers
      $headers.= 'From: '.$name.'<'.$email.'>'."\r\n";

      // Send email
      $sendEmail = mail($toEmail, $emailSubject, $htmlContent, $headers);
      if($sendEmail){
        $status = 1;
        $statusMsg = 'Thanks! Your contact request has been submitted successfully.';
      } else {
        $statusMsg = 'Failed! Your contact request submission failed, please try again.';
      }
    }
  } else {
    $statusMsg = 'Please fill in all the mandatory fields.';
  }
}

$response = array(
  'status' => $status, 
  'message' => $statusMsg
);
echo json_encode($response);
?>
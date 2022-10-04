<?php
// -------- name: import_sms_schedule.php
// -------- date: 02.10.2022
// -------- authors: Michael Polman, Daniel Polman
// -------- function: upload users CSV file to send SMS using Twilio

$file_ok = 'N';

if(isset($_FILES['import'])){   // ----- When file is uploaded: check and move!

      $errors= array();
      $file_name = $_FILES['import']['name'];
      $file_size =$_FILES['import']['size'];
      $file_tmp =$_FILES['import']['tmp_name'];
      $file_type=$_FILES['import']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['import']['name'])));

      $extensions= array("csv");

      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension is not allowed, can only upload .csv";
      }

      if($file_size > 12097152){
         $errors[]='File size must be less than 12 MB';
      }

      if($_POST['password']<>'XXXXX'){		// ---- set simple password for confirmation
         $errors[]='Code voor import incorrect';
      }

      if(empty($errors)==true){

        

         if(move_uploaded_file($file_tmp,'/yourpath/'.$file_name)){ // ---- set directory where file should be placed
            echo "<h3>Upload was successful</h3>";
            $file_ok = 'Y';
         } else {
            echo "<h3>Upload failed</h3>"; // ---- Make sure uploads directory has adequate rights: XRWXRWXRW (777)
         }

 } else {

         echo "<h3 colors='red'>Errors:</h3>\n";
         echo "<ul>\n";

         foreach ($errors as $value){
           echo "<li>".$value."</li>\n";
         }
         echo "</ul>\n";
      }

}


if ($file_ok <> 'Y'){  // ---- No upload yet: show upload form

   echo "<html>\n
      <body>\n<h3>Select file with respondents and scheduled time</h3> // ---- see format on https://github.com/DanielPolman/twilio-sms-schedule-php/
      <form action='import_sms.php' method='POST' enctype='multipart/form-data'>\n";
   echo Provide password <input name='password' type='password' required>\n<br />";
   echo "<br/><input name='import' enctype='multipart/form-data' type='file' required>\n";
   echo "<input type='submit' value='OK' />\n";
   echo "</form>\n
      </body>\n
      </html>\n";

}

// ------ EOF import_sms_schedule.php
?>

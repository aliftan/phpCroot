<?php  
   // Process delete operation after confirmation
   if(isset($_POST["id"]) && !empty($_POST["id"])){
       // Include config file
       require_once 'config.php';
       
       // Prepare a delete statement
       $sql = "DELETE FROM label WHERE id = ?";
       
       if($stmt = $mysqli->prepare($sql)){
           // Bind variables to the prepared statement as parameters
           $stmt->bind_param("i", $param_id);
           
           // Set parameters
           $param_id = trim($_POST["id"]);
           
           // Attempt to execute the prepared statement
           if($stmt->execute()){
               // Records deleted successfully. Redirect to landing page
               header("location: index.php");
               exit();
           } else{
               echo "Oops! Something went wrong. Please try again later.";
           }
       }
        
       // Close statement
       $stmt->close();
       
       // Close connection
       $mysqli->close();
   } else{
       // Check existence of id parameter
       if(empty(trim($_GET["id"]))){
           // URL doesn't contain id parameter. Redirect to error page
           header("location: error.php");
           exit();
       }
   }
 ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Delete Record</title>
      <!-- add favicon -->
      <link rel="icon" type="image/x-icon" href="/favicon/favicon.ico">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
      <style type="text/css">
         .wrapper{
         width: 650px;
         margin: 0 auto;
         margin-top: 20px;
         }
      </style>
   </head>
   <body>
      <div class="wrapper">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                  <div class="page-header">
                     <h1>Delete Label</h1>
                  </div>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                     <div class="alert alert-danger" role="alert">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Are you sure you want to delete this record?</p>
                        <input type="submit" value="Yes" class="btn btn-danger">
                        <a href="index.php" class="btn btn-default">No</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
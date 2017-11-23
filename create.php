<?php  
   // Include config file
   require_once 'config.php';
    
   // Define variables and initialize with empty values
   $name = $color = "";
   $name_err = $color_err = "";
    
   // Processing form data when form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){
       // Validate name
       $input_name = trim($_POST["name"]);
       if(empty($input_name)){
           $name_err = "Please enter a name.";
       } else{
           $name = $input_name;
       }
       
       // Validate Color
       $input_color = trim($_POST["color"]);
       if(empty($input_color)){
           $color_err = 'Please enter an color.';     
       } else{
           $color = $input_color;
       }       
       
       // Check input errors before inserting in database
       if(empty($name_err) && empty($color_err)){
           // Prepare an insert statement
           $sql = "INSERT INTO label (name, color) VALUES (?, ?)";
    
           if($stmt = $mysqli->prepare($sql)){
               // Bind variables to the prepared statement as parameters
               $stmt->bind_param("ss", $param_name, $param_color);
               
               // Set parameters
               $param_name = $name;
               $param_color = $color;
               
               // Attempt to execute the prepared statement
               if($stmt->execute()){
                   // Records created successfully. Redirect to landing page
                   header("location: index.php");
                   exit();
               } else{
                   echo "Something went wrong. Please try again later.";
               }
           }
            
           // Close statement
           $stmt->close();
       }
       
       // Close connection
       $mysqli->close();
   }
   ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Create Label</title>
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
         .page-header{
            margin-bottom: 20px
         }
      </style>
   </head>
   <body>
      <div class="wrapper">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                  <div class="page-header">
                     <h2>Create New Label</h2>
                  </div>
                  <p>Please fill this form and submit to add employee record to the database.</p>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                     <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err;?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($color_err)) ? 'has-error' : ''; ?>">
                        <label>Color</label>
                        <input type="text" name="color" class="form-control" value="<?php echo $color; ?>">
                        <span class="help-block"><?php echo $color_err;?></span>
                     </div>                     
                     <input type="submit" class="btn btn-primary" value="Submit">
                     <a href="index.php" class="btn btn-default">Cancel</a>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<!DOCTYPE html> 
<html lang="en"> 
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Label Manager</title>
      <!--- tambahkan favicon -->
      <link rel="icon" type="image/x-icon" href="/favicon/favicon.ico">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
      <!-- saat tekan N akan masuk halaman buat data -->
      <script> document.onkeydown = checkKey; function checkKey(e) { e = e || window.event; if (e.keyCode == '78') { window.open("create.php","_self")}}</script>
      <!-- berfungsi untuk menghitung berapa banyak data yang ditampilkan -->
      <script> $(function(){ var count = $('table tr').length; var data = count-1; document.getElementById("title").innerHTML = 'Label Lists: ' + data;})</script>
      <style type="text/css">
         .wrapper{
         width: 650px;
         margin: 0 auto;
         margin-top: 20px;
         }
         .page-header h2{
         margin-top: 0;
         }
         table tr td:last-child a{
         margin-right: 15px;
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
                  <div class="page-header clearfix">
                     <h2 class="float-left" id="title"></h2>                     
                     <a href="create.php" code="1" class="btn btn-success float-right">+ Add New Label</a>
                  </div>
                  <?php
                     // Sertakan file konfigurasi
                     require_once 'config.php';
                     
                     // Mencoba pilih eksekusi query
                     $sql = "SELECT * FROM label";
                     if($result = $mysqli->query($sql)){
                         if($result->num_rows > 0){
                             echo "<table class='table table-bordered table-striped'>";
                                 echo "<thead>";
                                     echo "<tr>";
                                         echo "<th>#</th>";
                                         echo "<th>Name</th>";
                                         echo "<th>Color</th>";            
                                         echo "<th>Action</th>";
                                     echo "</tr>";
                                 echo "</thead>";
                                 echo "<tbody>";
                                 while($row = $result->fetch_array()){
                                     echo "<tr>";
                                         echo "<td>" . $row['id'] . "</td>";
                                         echo "<td>" . $row['name'] . "</td>";
                                         echo "<td>" . $row['color'] . "</td>";
                                         echo "<td>";
                                             echo "<a href='read.php?id=". $row['id'] ."' title='Detail Record'><i class='fa fa-eye'></i></a>";
                                             echo "<a href='update.php?id=". $row['id'] ."' title='Update Record'><i class='fa fa-edit'></i></a>";
                                             echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record'><i class='fa fa-trash'></i></a>";
                                         echo "</td>";
                                     echo "</tr>";
                                 }
                                 echo "</tbody>";                            
                             echo "</table>";
                             // Free result set
                             $result->free();
                         } else{
                             echo "<p class='lead'><em>Tidak ada catatan yang ditemukan.</em></p>";
                         }
                     } else{
                         echo "KESALAHAN: Tidak dapat melakukan eksekusi $sql. " . $mysqli->error;
                     }
                     
                     // Close connection
                     $mysqli->close();
                     ?>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
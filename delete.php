<?php  
   // Proses hapus operasi setelah konfirmasi
   if(isset($_POST["id"]) && !empty($_POST["id"])){
       // Sertakan file konfigurasi
       require_once 'config.php';
       
       // Siapkan pernyataan hapus
       $sql = "DELETE FROM label WHERE id = ?";
       
       if($stmt = $mysqli->prepare($sql)){
           // Bind variabel ke pernyataan yang disiapkan sebagai parameter
           $stmt->bind_param("i", $param_id);
           
           // Tetapkan parameter
           $param_id = trim($_POST["id"]);
           
           // Mencoba untuk melaksanakan pernyataan yang telah disiapkan
           if($stmt->execute()){
               // Catatan berhasil dihapus Redirect ke halaman indeks
               header("location: index.php");
               exit();
           } else{
               echo "Ups! Ada yang salah. Silakan coba lagi nanti.";
           }
       }
        
       // Tutup pernyataan
       $stmt->close();
       
       // Tutup koneksi
       $mysqli->close();
   } else{
       // Cek adanya parameter id
       if(empty(trim($_GET["id"]))){
           // URL tidak berisi parameter id Redirect ke halaman error
           header("location: error.php");
           exit();
       }
   }
 ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Hapus Rekaman</title>
      <!-- tambahkan favicon -->
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
                     <h1>Hapus Label</h1>
                  </div>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                     <div class="alert alert-danger" role="alert">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Yakin ingin menghapus rekaman ini?</p>
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
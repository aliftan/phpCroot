<?php  
   // Sertakan file konfigurasi
   require_once 'config.php';
    
   // Tentukan variabel dan inisialisasi dengan nilai kosong
   $name = $color = "";
   $name_err = $color_err = "";
    
   // Memproses data formulir saat form diajukan
   if($_SERVER["REQUEST_METHOD"] == "POST"){
       // Validasi nama
       $input_name = trim($_POST["name"]);
       if(empty($input_name)){
           $name_err = "Harap masukkan sebuah nama.";
       } else{
           $name = $input_name;
       }
       
       // Validasi Warna
       $input_color = trim($_POST["color"]);
       if(empty($input_color)){
           $color_err = "Silahkan masukkan warna.";     
       } else{
           $color = $input_color;
       }       
       
       // Periksa kesalahan masukan sebelum memasukkan ke dalam database
       if(empty($name_err) && empty($color_err)){
           // Siapkan sebuah pernyataan insert
           $sql = "INSERT INTO label (name, color) VALUES (?, ?)";
    
           if($stmt = $mysqli->prepare($sql)){
               // Bind variabel ke pernyataan yang disiapkan sebagai parameter
               $stmt->bind_param("ss", $param_name, $param_color);
               
               // Tetapkan parameter
               $param_name = $name;
               $param_color = $color;
               
               // Mencoba untuk melaksanakan pernyataan yang telah disiapkan
               if($stmt->execute()){
                   // Catatan berhasil dibuat. Arahkan ulang ke halaman arahan
                   header("location: index.php");
                   exit();
               } else{
                   echo "Ada yang salah. Silakan coba lagi nanti.";
               }
           }
            
           // Tutup pernyataan
           $stmt->close();
       }
       
       // Tutup koneksi
       $mysqli->close();
   }
   ?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Create Label</title>
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
                     <h2>Buat Label Baru</h2>
                  </div>
                  <p>Silahkan isi formulir ini.</p>
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
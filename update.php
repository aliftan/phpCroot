<?php 
// Sertakan file konfigurasi
require_once 'config.php';
 
// Tentukan variabel dan inisialisasi dengan nilai kosong
$name = $color = "";
$name_err = $color_err = "";
 
// Memproses data formulir saat form diajukan
if(isset($_POST["name"]) && !empty($_POST["name"])){
    // Dapatkan nilai input tersembunyi
    $id = $_GET["id"];
    
    // Validasi nama
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Harap masukkan sebuah nama.";
    } else{
        $name = $input_name;
    }
    
    // Validasi warna warna
    $input_color = trim($_POST["color"]);
    if(empty($input_color)){
        $color_err = 'Silahkan masukkan warna.';     
    } else{
        $color = $input_color;
    }
    
    
    // Periksa kesalahan masukan sebelum memasukkan ke dalam database
    if(empty($name_err) && empty($color_err)){
        // Siapkan sebuah pernyataan update
        $sql = "UPDATE label SET name=?, color=? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){
            // Bind variabel ke pernyataan yang disiapkan sebagai parameter
            $stmt->bind_param("ssi", $param_name, $param_color, $param_id);
            
            // Tetapkan parameter
            $param_name = $name;
            $param_color = $color;
            $param_id = $id;
            
            // Mencoba untuk melaksanakan pernyataan yang telah disiapkan
            if($stmt->execute()){
                // Catatan berhasil diperbarui. Arahkan ulang ke halaman arahan
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


} else{
    // Cek adanya parameter id sebelum melanjutkan lebih jauh
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Dapatkan parameter URL
        $id =  trim($_GET["id"]);
        
        // Siapkan pernyataan pilih
        $sql = "SELECT * FROM label WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variabel ke pernyataan yang disiapkan sebagai parameter
            $stmt->bind_param("i", $param_id);
            
            // Tetapkan parameter
            $param_id = $id;
            
            // Mencoba untuk melaksanakan pernyataan yang telah disiapkan
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    // Ambil baris hasil sebagai array asosiatif.
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Ambil nilai bidang individu
                    $name = $row["name"];
                    $color = $row["color"];
                } else{
                    // URL tidak berisi id yang valid Redirect ke halaman error
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Ups! Ada yang salah. Silakan coba lagi nanti.";
            }
        }
        
        // Tutup pernyataan
        $stmt->close();
        
        // Tutup koneksi
        $mysqli->close();
    }  else{
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
      <title>Update Label</title>
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
                     <h2>Perbarui Data</h2>
                  </div>
                  <p>Harap edit nilai masukan dan kirimkan untuk memperbarui rekaman.</p>
                  <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                     <div class="form-group">
                        <label>Id</label>
                        <input type="text" class="form-control" placeholder="<?php echo $id; ?>" readonly>
                     </div>
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
                     <input type="submit" class="btn btn-primary" value="Update">
                     <a href="index.php" class="btn btn-default">Cancel</a>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
<?php 
// Cek adanya parameter id sebelum melanjutkan lebih jauh
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Sertakan file konfigurasi
    require_once 'config.php';
    
    // Siapkan pernyataan pilih
    $sql = "SELECT * FROM label WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variabel ke pernyataan yang disiapkan sebagai parameter
        $stmt->bind_param("i", $param_id);
        
        // Tetapkan parameter
        $param_id = trim($_GET["id"]);
        
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
                // URL tidak berisi parameter id yang valid Redirect ke halaman error
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
} else{
    // URL tidak berisi parameter id Redirect ke halaman error
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <title>Detail Biodata</title>
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
                        <h1>Detail Bio</h1>
                    </div>
                    <div class="form-group">
                        <label>Id</label>
                        <input type="text" class="form-control" placeholder="<?php echo $row["id"];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="<?php echo $row["name"];?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input type="text" class="form-control" placeholder="<?php echo $row["color"];?>" readonly>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
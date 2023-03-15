<?php 

$id = $_GET['provider_id'];

function dispaly_data(){
   global $id;
   $con = mysqli_connect("localhost","root","","services");

   if(!$con){
     die("Connection Error");
   }
   
   $query = "select * from bookings where provider_id = $id";
   $result = mysqli_query($con,$query);
   return $result;
}

// Call the function to get the results and assign them to the $result variable
$result = dispaly_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>Track your Bookings</title>
</head>
<body class="bg-dark">
    <div class="container">
      <div class="row mt-5">
        <div class="col">
          <div class="card mt-5">
            <div class="card-header">
              <h2 class="display-6 text-center">Track your Bookings</h2>
            </div>
            <div class="card-body">
              <table class="table table-bordered text-center">
                <tr class="bg-dark text-white">
                  <td> Provider Id </td>
                  <td> First Name </td>
                  <td> Last Name </td>
                  <td> contact</td>
                  <td> address</td>
                  <td> date</td>
                 <!-- <td> Edit </td>
                  <td> Delete </td> -->
                </tr>
                <?php 
                  while($row = mysqli_fetch_assoc($result))
                  {
                ?>
                  <tr>
                    <td><?php echo $row['provider_id']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><?php echo $row['adder']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <!--<td><a href="#" class="btn btn-primary">Edit</a></td>  
                    <td><a href="#" class="btn btn-danger">Delete</a></td>  
                    -->
                  </tr>
                <?php    
                  }
                ?>
                <tr> 
                <td><a href="../provider.php" class="btn btn-primary">Back to Site</a></td> 
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>

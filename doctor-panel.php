<!DOCTYPE html>
<?php
include('func1.php');
$con = mysqli_connect("localhost", "root", "", "hospitalms");
$doctor = $_SESSION['dname'];

if (isset($_GET['cancel'])) {
    $query = mysqli_query($con, "update appointmenttb set doctorStatus='0' where ID = '".$_GET['ID']."'");
    if ($query) {
        echo "<script>alert('Your appointment successfully cancelled');</script>";
    }
}

if (isset($_POST['update_availability'])) {
    $doctor = $_SESSION['dname'];
    $days = isset($_POST['days']) ? $_POST['days'] : []; // Fix: Check if 'days' is set
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Clear existing availability
    mysqli_query($con, "DELETE FROM doctor_availability WHERE doctor='$doctor'");

    // Insert new availability only if days are selected
    if (is_array($days) && !empty($days)) { // Fix: Ensure $days is an array and not empty
        foreach ($days as $day) {
            $query = "INSERT INTO doctor_availability (doctor, day, start_time, end_time) VALUES ('$doctor', '$day', '$start_time', '$end_time')";
            mysqli_query($con, $query);
        }
        echo "<script>alert('Availability updated successfully!');</script>";
    } else {
        echo "<script>alert('Please select at least one day.');</script>";
    }
}
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <style>
      .btn-outline-light:hover {
        color: #25bef7;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
      }
      .bg-primary {
        background: #F0F2F0;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #006400, #F0F2F0);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #006400, #F0F2F0); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      }
      .list-group-item.active {
        z-index: 2;
        color: #fff;
        background: #F0F2F0; 
        background: -webkit-linear-gradient(to right, #006400, #F0F2F0);
        background: linear-gradient(to right, #006400, #F0F2F0);
        border-color: #c3c3c3;
      }
      .text-primary {
        color: #342ac1!important;
      }
    </style>
  </head>
  <body style="padding-top:50px;">
    <!-- Header Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <a class="navbar-brand" href="#"><i class="fa fa-hospital-o" aria-hidden="true"></i> Hospital Management System</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout1.php"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
          <input class="form-control mr-sm-2" type="text" placeholder="Enter contact number" aria-label="Search" name="contact">
          <input type="submit" class="btn btn-primary" id="inputbtn" name="search_submit" value="Search">
        </form>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid" style="margin-top:50px;">
      <h3 style="margin-left: 40%; padding-bottom: 20px;font-family:'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $_SESSION['dname'] ?>  </h3>
      <div class="row">
        <div class="col-md-4" style="max-width:18%;margin-top: 3%;">
          <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" aria-controls="home" data-toggle="list">Dashboard</a>
            <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointments</a>
            <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home"> Prescription List</a>
            <a class="list-group-item list-group-item-action" href="#list-availability" id="list-availability-list" role="tab" data-toggle="list" aria-controls="home">Manage Availability</a>
          </div><br>
        </div>
        <div class="col-md-8" style="margin-top: 3%;">
          <div class="tab-content" id="nav-tabContent" style="width: 950px;">
            <!-- Dashboard Section -->
            <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
              <div class="container-fluid container-fullw bg-white">
                <div class="row">
                  <div class="col-sm-4" style="left: 10%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;"> View Appointments</h4>
                        <script>
                          function clickDiv(id) {
                            document.querySelector(id).click();
                          }
                        </script>                      
                        <p class="links cl-effect-1">
                          <a href="#list-app" onclick="clickDiv('#list-app-list')">
                            Appointment List
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4" style="left: 15%">
                    <div class="panel panel-white no-radius text-center">
                      <div class="panel-body">
                        <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-file-powerpoint-o fa-stack-1x fa-inverse"></i> </span>
                        <h4 class="StepTitle" style="margin-top: 5%;"> Prescriptions</h4>
                        <p class="links cl-effect-1">
                          <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                            Prescription List
                          </a>
                        </p>
                      </div>
                    </div>
                  </div>    
                </div>
              </div>
            </div>

            <!-- Appointments Section -->
            <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-app-list">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Patient</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    <th scope="col">Prescribe</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $con = mysqli_connect("localhost", "root", "", "hospitalms");
                    global $con;
                    $dname = $_SESSION['dname'];
                    $query = "select pid,ID,fname,lname,gender,email,contact,appdate,apptime,userStatus,doctorStatus from appointmenttb where doctor='$dname';";
                    $result = mysqli_query($con, $query);
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['appdate']; ?></td>
                        <td><?php echo $row['apptime']; ?></td>
                        <td>
                          <?php 
                            if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                              echo "Active";
                            } elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                              echo "Cancelled by Patient";
                            } elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                              echo "Cancelled by You";
                            }
                          ?>
                        </td>
                        <td>
                          <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
                            <a href="doctor-panel.php?ID=<?php echo $row['ID'] ?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment?')" title="Cancel Appointment">
                              <button class="btn btn-danger">Cancel</button>
                            </a>
                          <?php } else {
                            echo "Cancelled";
                          } ?>
                        </td>
                        <td>
                          <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
                            <a href="prescribe.php?pid=<?php echo $row['pid'] ?>&ID=<?php echo $row['ID'] ?>&fname=<?php echo $row['fname'] ?>&lname=<?php echo $row['lname'] ?>&appdate=<?php echo $row['appdate'] ?>&apptime=<?php echo $row['apptime'] ?>" title="Prescribe">
                              <button class="btn btn-success">Prescribe</button>
                            </a>
                          <?php } else {
                            echo "-";
                          } ?>
                        </td>
                      </tr>
                  <?php $cnt++; } ?>
                </tbody>
              </table>
            </div>

            <!-- Prescription List Section -->
            <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Patient</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergy</th>
                    <th scope="col">Prescription</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $con = mysqli_connect("localhost", "root", "", "hospitalms");
                    global $con;
                    $query = "select pid,fname,lname,ID,appdate,apptime,disease,allergy,prescription from prestb where doctor='$doctor';";
                    $result = mysqli_query($con, $query);
                    if (!$result) {
                      echo mysqli_error($con);
                    }
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($result)) {
                  ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></td>                        
                        <td><?php echo $row['appdate']; ?></td>
                        <td><?php echo $row['apptime']; ?></td>
                        <td><?php echo $row['disease']; ?></td>
                        <td><?php echo $row['allergy']; ?></td>
                        <td><?php echo $row['prescription']; ?></td>
                      </tr>
                  <?php $cnt++; } ?>
                </tbody>
              </table>
            </div>

            <!-- Manage Availability Section -->
            <div class="tab-pane fade" id="list-availability" role="tabpanel" aria-labelledby="list-availability-list">
              <h4>Manage Your Availability</h4>
              <form method="post" action="">
                <div class="form-group">
                  <label>Select Available Days:</label><br>
                  <input type="checkbox" name="days[]" value="Monday"> Monday<br>
                  <input type="checkbox" name="days[]" value="Tuesday"> Tuesday<br>
                  <input type="checkbox" name="days[]" value="Wednesday"> Wednesday<br>
                  <input type="checkbox" name="days[]" value="Thursday"> Thursday<br>
                  <input type="checkbox" name="days[]" value="Friday"> Friday<br>
                  <input type="checkbox" name="days[]" value="Saturday"> Saturday<br>
                  <input type="checkbox" name="days[]" value="Sunday"> Sunday<br>
                </div>
                <div class="form-group">
                  <label>Consultation Hours:</label><br>
                  <input type="time" name="start_time" required> to <input type="time" name="end_time" required>
                </div>
                <button type="submit" name="update_availability" class="btn btn-primary">Update Availability</button>
              </form>

              <h4>Current Schedule</h4>
              <?php
              $con = mysqli_connect("localhost", "root", "", "hospitalms");
              $doctor = $_SESSION['dname'];
              $query = "SELECT * FROM doctor_availability WHERE doctor='$doctor'";
              $result = mysqli_query($con, $query);

              if (mysqli_num_rows($result) > 0) {
                  echo "<ul>";
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<li>" . $row['day'] . ": " . $row['start_time'] . " - " . $row['end_time'] . "</li>";
                  }
                  echo "</ul>";
              } else {
                  echo "<p>No availability set.</p>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-primary text-white text-center py-3">
      <p>&copy; 2025 Hospital Management System. All rights reserved.</p>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
  </body>
</html>
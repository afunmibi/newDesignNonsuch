<?php 
require'connection.php';
$sql = "select * from `log_enrollees_in` ";
$result = mysqli_query($con, $sql);
$row=mysqli_fetch_assoc($result);
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PA code Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .form-control:focus {
            border-color: skyblue;
            box-shadow: 0 0 0 0.2rem rgba(135, 206, 250, 0.25);
        }

        .btn-primary {
            background-color: skyblue;
            border-color: skyblue;
        }

        .btn-primary:hover {
            background-color: #87CEEB;
            border-color: #87CEEB;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 form-container">
                <h2 class="text-center mb-4">Approve PA code </h2>
                <form action="#" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="name" class="form-label">Name of Enrollee</label>
                            <p> <?php echo $row['name_of_enrollee'];?></p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="nhia" class="form-label">NHIA No</label>
                            <p><?php echo $row['nhia_no'];?>  </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Sex</label>
                            <div class="form-check">
                                
                            </div>
                            <div class="form-check">
                            <p><?php echo $row['sex'];?>  </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="phone" class="form-label">Phone No</label>
                            <p><?php echo $row['phone_no'];?>  </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="primaryHospital" class="form-label">Primary Hospital</label>
                            <p><?php echo $row['primary_hospital'];?>  </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="secondaryHospital" class="form-label">Secondary Hospital</label>
                            <p><?php echo $row['secondary_hospital'];?>  </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                            <p><?php echo $row['status_position'];?>  </p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="primaryHospital" class="form-label">Primary Hospital Code</label>
                            <p><?php echo $row['primary_hospital_code'];?>  </p>                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="secondaryHospital" class="form-label">Secondary Hospital Code</label>
                            <p><?php echo $row['secondary_hospital_code'];?>  </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <p><?php echo $row['diagnosis'];?>  </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="procedure" class="form-label">Procedure</label>
                            <p><?php echo $row['procedure_text'];?>  </p>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <p><?php echo $row['dob'];?>  </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="furtherDiagnosis" class="form-label">Further Diagnosis</label>
                            <p><?php echo $row['further_diagnosis'];?>  </p>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-md-12 mb-2">
                            <label for="furtherDiagnosis" class="form-label">PA Code: </label>
                            <p>The PA Code for <?php echo $row['name_of_enrollee'] ?> on diagnosis - <?php echo $row['diagnosis'] ?> is <?php echo $row['pa_code'].'/'.$row['id'];?>. PA code issued on <?php echo $row['created_on'] ?>  </p>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#enrolleeForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'process_enrollee.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#enrolleeForm')[0].reset(); // Reset the form
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred during the AJAX request.');
                    }
                });
            });
        });
    </script>
</body>

</html>
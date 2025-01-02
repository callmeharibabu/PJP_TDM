<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Code for Signup
if(isset($_POST['submit'])) 
{
    $fname=$_POST['fname'];
    $emailid=$_POST['emailid'];
    $phoneno=$_POST['mobileno'];
    $password=md5($_POST['password']);
    
    // Checking if email or mobile already registered
    $query =$dbh->prepare("SELECT ID FROM tblteacher WHERE Email=:emailid and MobileNumber=:phoneno");
    $query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
    $query->bindParam(':phoneno', $phoneno, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    if($query->rowCount() > 0)
    {
        echo "<script>alert('Email id or Mobile no already registered with another account.');</script>";
        echo "<script type='text/javascript'> document.location ='signup.php'; </script>";
    } else {
        $sql = "INSERT INTO tblteacher(Name, Email, MobileNumber, password) VALUES (:fname, :emailid, :phoneno, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':emailid', $emailid, PDO::PARAM_STR);
        $query->bindParam(':phoneno', $phoneno, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        
        $LastInsertId = $dbh->lastInsertId();
        
        if ($LastInsertId > 0) {
            echo '<script>alert("Registered successfully")</script>';
            echo "<script>window.location.href ='index.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRMS Teacher Registration</title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, rgb(116, 52, 185), rgb(54, 119, 230));
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sufee-login {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .login-content {
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-logo h3 {
            font-size: 28px;
            color: #2575fc;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .login-form {
            text-align: left;
        }

        .login-form input {
            border-radius: 25px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 100%;
            transition: 0.3s ease-in-out;
            box-sizing: border-box;
            padding-right: 35px; /* Add right padding for a cleaner look */
        }

        .login-form input:focus {
            border-color: #2575fc;
            box-shadow: 0 0 10px rgba(37, 117, 252, 0.5);
        }

        .btn-success {
            background-color: #2575fc;
            border: none;
            color: #fff;
            font-size: 16px;
            padding: 15px 30px;
            width: 100%;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #6a11cb;
            transform: translateY(-5px);
        }

        .checkbox a {
            color: #2575fc;
            text-decoration: none;
            font-size: 14px;
        }

        .checkbox a:hover {
            text-decoration: underline;
        }

        .login-form hr {
            border-top: 1px solid #2575fc;
            margin: 20px 0;
        }

        p {
            color: #2575fc;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .links {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-top: 10px;
        }

        .links a {
            color: #2575fc;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-content {
                padding: 30px;
            }

            .login-logo h3 {
                font-size: 24px;
            }

            .btn-success {
                padding: 12px 20px;
            }
        }
    </style>

</head>

<body>

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <h3>Teacher Records Management System</h3>
                    <hr color="red"/>
                    <h3>Teacher Registration</h3>
                    <hr color="red"/>
                </div>
                <div class="login-form">
                    <form action="" method="post" name="login">
                        
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Full Name" required="true" name="fname">
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email id" required="true" name="emailid">
                        </div> 

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Mobile Number" maxlength="10" pattern="[0-9]{10}" title="10 numeric characters only" required="true" name="mobileno">
                        </div> 

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required="true">
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" name="submit">Sign Up</button>
                        
                        <!-- Links Section -->
                        <div class="links">
                            <a href="../index.php">Back Home!!</a>
                            <a href="index.php">Already Registered? Login Here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>

</body>
</html>

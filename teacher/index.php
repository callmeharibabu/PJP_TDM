<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
{
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID,Name FROM tblteacher WHERE (Email=:username || MobileNumber=:username) and password=:password";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $_SESSION['trmsuid']=$result->ID;
            $_SESSION['trmstname']=$result->Name;
        }

        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRMS Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, rgb(116, 52, 185), rgb(54, 119, 230));
            color: #fff;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .login-content {
            background: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-logo h3 {
            font-size: 28px;
            color: #2575fc;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .login-form input {
            border-radius: 25px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 100%;
            transition: 0.3s ease-in-out;
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

        .form-group label {
            font-size: 14px;
            font-weight: 600;
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

        .form-group input {
            border-radius: 20px;
            padding: 12px;
        }

        /* Align the footer links properly */
        .checkbox {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .checkbox a {
            font-size: 14px;
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
        .signup-link {
    text-decoration: none; /* Removes the underline */
    color: #007BFF; /* Initial color */
}

.signup-link:hover {
    color: #FF5733; /* Color when hovered */
    text-decoration: underline; /* Optional underline on hover */
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
                </div>
                <div class="login-form">
                    <form action="" method="post" name="login">
                        <div class="form-group">
                            <label for="username">Email Id / Mobile Number</label>
                            <input type="text" id="username" class="form-control" placeholder="Email id / Mobile Number" required="true" name="username">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Password" name="password" required="true">
                        </div>
                        
                        <div class="checkbox">
                            <label class="pull-left">
                                <a href="../index.php">Back Home!!</a>
                            </label>
                            <label class="pull-right">
                                <a href="forgot-password.php">Forgot Password?</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" name="login">Sign in</button>
                        <hr />
                        <p><a href="signup.php" class="signup-link">Signup Here</a></p>

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

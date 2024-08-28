<?php
include '../config/koneksi.php';
include '../library/fungsi.php';

session_start();
date_default_timezone_set("Asia/Jakarta");

$aksi = new oop($conn);

$username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
$password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';

if (isset($_SESSION['username_agen']) && $_SESSION['username_agen'] != "") {
    $aksi->redirect("hal_utama.php?menu=home");
}

if (isset($_POST['login'])) {
    $aksi->login("agen", $username, $password, "hal_utama.php?menu=home");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FORM LOGIN - USER</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        /* Design the webpage */
        body {
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #2e0d4d;
        }
        /* Basic structure of login form */
        .form {
            position: relative;
            padding: 50px 15px;
            width: 350px;
            height: 400px;
            background: #2e0d4d;
            overflow: hidden;
            box-shadow: 0px 0px 10px 0px rgb(116, 119, 114);
            border-radius: 5px;
        }
        /* The main area of the login form */
        .form-inner {
            position: absolute;
            height: 98%;
            width: 98%;
            top: 50%;
            left: 50%;
            background: #041630;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }
        
        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top:55px;
        }

        .logo-container {
            margin-right: 10px;
        }

        .text-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .text-container h2, .text-container p {
            font-size: 25px;
            color: white;
            margin: 0;
        }
        
        .content {
            width: 100%;
            padding: 30px;
        }
        /* Input fields */
        .input {
            display: block;
            padding: 12px 15px;
            width: 100%;
            left: 50%;
            border-radius: 10px;
            margin-top: 20px;
            border: 1.5px solid rgb(109, 87, 121);
            outline: none;
            background: #233c61;
            color: white;
        }
        .input::placeholder {
            color: white;
            opacity: 1; /* Ensures the placeholder is fully opaque */
        }

        /* Login button */
        .btn {
            cursor: pointer;
            color: white;
            margin-top: 40px;
            margin-bottom:60px;
            width: 100%;
            padding: 12px;
            outline: none;
            background: #0c387a;
            border: none;
            font-size: 18px;
            border-radius: 10px;
            transition: 0.4s;
        }
        .btn:hover {
            background: #204173;
        }
        /* Border animation of login form */
        .form span {
            position: absolute;
            height: 50%;
            width: 50%;
        }
        /* Animation of the first line */
        .form span:nth-child(1) {
            background: #ffda05;
            top: 0;
            left: -48%;
            animation: 5s span1 infinite linear;
            animation-delay: 1s;
        }
        
        @keyframes span1 {
            0% {
                top: -48%;
                left: -48%;
            }
            25% {
                top: -48%;
                left: 98%;
            }
            50% {
                top: 98%;
                left: 98%;
            }
            75% {
                top: 98%;
                left: -48%;
            }
            100% {
                top: -48%;
                left: -48%;
            }
        }
        /* Animation of the second line */
        .form span:nth-child(2) {
            background: #00a800;
            bottom: 0;
            right: -48%;
            animation: 5s span2 infinite linear;
        }
        
        @keyframes span2 {
            0% {
                bottom: -48%;
                right: -48%;
            }
            25% {
                bottom: -48%;
                right: 98%;
            }
            50% {
                bottom: 98%;
                right: 98%;
            }
            75% {
                bottom: 98%;
                right: -48%;
            }
            100% {
                bottom: -48%;
                right: -48%;
            }
        }
        /* Animation of the third line */
        .form span:nth-child(3) {
            background: #800080;
            right: -48%;
            top: 0px;
            animation: 5s span3 infinite linear;
        }
        
        @keyframes span3 {
            0% {
                top: -48%;
                left: -48%;
            }
            25% {
                top: -48%;
                left: 98%;
            }
            50% {
                top: 98%;
                left: 98%;
            }
            75% {
                top: 98%;
                left: -48%;
            }
            100% {
                top: -48%;
                left: -48%;
            }
        }
        /* Animation of the fourth line */
        .form span:nth-child(4) {
            background: #ff0000;
            bottom: 0;
            right: -48%;
            animation: 5s span4 infinite linear;
            animation-delay: 1s;
        }
        
        @keyframes span4 {
            0% {
                bottom: -48%;
                right: -48%;
            }
            25% {
                bottom: -48%;
                right: 98%;
            }
            50% {
                bottom: 98%;
                right: 98%;
            }
            75% {
                bottom: 98%;
                right: -48%;
            }
            100% {
                bottom: -48%;
                right: -48%;
            }
        }
    </style>
</head>
<body style="background:url('../images/main.jpg');background-size:cover;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
        <!-- Border Animation -->
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <!-- Login Form Area -->
        <div class="form-inner">
            <div class="panel-heading">
                <div class="logo-container">
                    <img src="../images/lg1.png" alt="logo" class="logo" width="90px">
                </div>
                <div class="text-container">
                    <h2>LOGIN</h2>
                    <p>BRIGHT POWER</p>
                </div>
            </div>
            <!-- Input Place -->
            <div class="content">
                <input class="input" type="text" placeholder="Masukan username Anda..." id="username" name="username" required maxlength="30" autocomplete="off" />
                <input class="input" type="password" placeholder="Masukan password Anda..." id="password" name="password" required maxlength="30" autocomplete="off" />
                <button class="btn" type="submit" name="login">Login</button>
            </div>
        </div>
    </form>
</body>
</html>

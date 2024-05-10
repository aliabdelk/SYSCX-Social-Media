<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Register on SYSCX</title>
   <link rel="stylesheet" href="assets/css/reset.css">
   <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1>SYSCX</h1>
        <p>Social media for SYSC students in Carleton University</p>
    </header>

    <table>
        <tr>
            <td class="navbar">
                <div>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <!-- <li><a href="profile.php">Profile</a></li> -->
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php" id='nav-sel'>Login</a></li>
                        <!-- <li><a href="index.php">Logout</a></li> -->
                    </ul>
                </div>
            </td>

            <td class="main">
                <section>
                    <h2> Login</h2>
                    <form method="POST" action="">
                        <fieldset>
                            <table>
                                <tr>
                                    <td><label>Email address: </label><input type="email" name="student_email" required="true"></td>
                                </tr>
                                <tr>
                                    <td><label>Password: </label><input type="password" name="login_password" id="login-password" required="true"></td>
                                </tr>
                                <tr>
                                    <td><p name="login-error-msg" id="login-error-msg" style="color: red;"></p></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="Login" name="submit-login">
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                </section>
                <br>
                <p>To create a new account, please register <a href="register.php">here</a>.</p>
            </td>

            <td class="user-profile">
                <div>
                </div>
            </td>
        </tr>
    </table>

    <?php
        include("connection.php");

        if (isset($_POST["submit-login"]) && isset($_SESSION)) {
            // 
            try {
                // Connect to the database
                $conn = new mysqli($server_name, $username, $password, $database_name);
                if ($conn->connect_error) {
                    die("Error: Couldn't connect. <br>" . $conn->connect_error);
                }

                $student_email_entered = $_POST["student_email"];
                $pswd_entered = $_POST["login_password"];

                // Check if the password and email entered are correct
                // Check if the email is in the DB already
                $sql = "SELECT * FROM users_info WHERE student_email = ?";
                $statement = $conn->prepare($sql);
                $statement->bind_param('s', $student_email_entered);
                $statement->execute();
                $email_exists_result = $statement->get_result();
                $email_exists_result = $email_exists_result->fetch_assoc();

                if ($email_exists_result) {
                    // Get the student ID
                    $student_id = $email_exists_result["student_id"];

                    // Check if the password is correct
                    $sql = "SELECT * FROM users_passwords WHERE student_id = ?";
                    $statement = $conn->prepare($sql);
                    $statement->bind_param('i', $student_id);
                    $statement->execute();
                    $pswd_result = $statement->get_result();
                    $pswd_result = $pswd_result->fetch_assoc();

                    if ($pswd_result) {
                        $hashed_db_pswd = $pswd_result["password"];

                        if (password_verify($pswd_entered, $hashed_db_pswd)) {
                            // The password is valid.

                            // Store user info
                            $_SESSION['student_id'] = $student_id;
                            $_SESSION['student_email'] = $email_exists_result["student_email"];
                            $_SESSION['first_name'] = $email_exists_result["first_name"];
                            $_SESSION['last_name'] = $email_exists_result["last_name"];
                            $_SESSION['dob'] = $email_exists_result["dob"];

                            // Store avatar
                            $sql = "SELECT * FROM users_avatar WHERE student_id = ?";
                            $statement = $conn->prepare($sql);
                            $statement->bind_param('i', $student_id);
                            $statement->execute();
                            $avatar_result = $statement->get_result();
                            $avatar_result = $avatar_result->fetch_assoc();
                            $_SESSION['avatar'] = ($avatar_result ? $avatar_result["avatar"] : '0');

                            // Store program
                            $sql = "SELECT * FROM users_program WHERE student_id = ?";
                            $statement = $conn->prepare($sql);
                            $statement->bind_param('i', $student_id);
                            $statement->execute();
                            $program_result = $statement->get_result();
                            $program_result = $program_result->fetch_assoc();
                            $_SESSION['program'] = ($program_result ? $program_result["program"] : "");

                            // Store address
                            $sql = "SELECT * FROM users_address WHERE student_id = ?";
                            $statement = $conn->prepare($sql);
                            $statement->bind_param('i', $student_id);
                            $statement->execute();
                            $address_result = $statement->get_result();
                            $address_result = $address_result->fetch_assoc();

                            $_SESSION['street_number'] = ($address_result ? $address_result["street_number"] : "");
                            $_SESSION['street_name'] = ($address_result ? $address_result["street_name"] : "");
                            $_SESSION['city'] = ($address_result ? $address_result["city"] : "");
                            $_SESSION['province'] = ($address_result ? $address_result["province"] : "");
                            $_SESSION['postal_code'] = ($address_result ? $address_result["postal_code"] : "");

                            // Store account type
                            $sql = "SELECT * FROM users_permissions WHERE student_id = ?";
                            $statement = $conn->prepare($sql);
                            $statement->bind_param('i', $student_id);
                            $statement->execute();
                            $permission_result = $statement->get_result();
                            $permission_result = $permission_result->fetch_assoc();
                            $_SESSION['permission_level'] = ($permission_result ? $permission_result["account_type"] : "");
    ?>
    <script>
        console.log("login successful. moving to index page");
        var loginError = document.getElementById('login-error-msg'); 
        loginError.textContent = "";
        window.location = "index.php";
    </script>
    <?php
                        }
                        else {
                            // password is invalid
    ?>
    <script>
        console.log("login - password type 1 error - incorrect password entered.");
        var loginError = document.getElementById('login-error-msg'); 
        loginError.textContent = "Invalid password. Please try again.";
    </script>
    <?php
                        }
                    }
    ?>
    <script>
        console.log("login - password type 2 error - no existing password in database.");
        var loginError = document.getElementById('login-error-msg'); 
        loginError.textContent = "Invalid password. Please try again.";
    </script>
    <?php
                }
                else {
    ?>
    <script>
        console.log("login - email error.");
        var loginError = document.getElementById('login-error-msg'); 
        loginError.textContent = "Invalid email. Please try again.";
    </script>
    <?php
                }
            }
            catch (mysqli_sql_exception $e) {
                // Catch an unsuccessful connection
                $error = $e->getMessage();
                echo $error;
            }
        }
    ?>

</body>

</html>

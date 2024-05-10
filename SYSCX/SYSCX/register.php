<?php
    session_start();

    if (isset($_SESSION['student_id']) && isset($_SESSION['first_name'])) {
        header("Location: profile.php");
        exit;
    }
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
                        <li> <a href="index.php">Home</a></li>
                        <!-- <li> <a href="profile.php">Profile</a></li> -->
                        <li> <a href="register.php" id='nav-sel'>Register</a></li>
                        <li> <a href="login.php">Login</a></li>
                        <!-- <li> <a href="logout.php">Logout</a></li> -->
                    </ul>
                </div>
            </td>

            <td class="main">
                <section>
                    <h2>Register a new profile</h2>
                    <form method="post" action="" onsubmit="return checkRegistration()">
                        <table>
                            <tr>
                                <td>
                                    <fieldset>
                                        <legend><span>Personal information</span></legend><br>
                                        <table>
                                            <tr>
                                                <td><label>First Name: </label></td>
                                                <td><input type="text" name="first_name" required="true"></td>
                                                <td><label>Last Name: </label></td>
                                                <td><input type="text" name="last_name" required="true"></td>
                                                <td><label>DOB: </label></td>
                                                <td><input type="date" name="DOB" required="true"></td>
                                            </tr>
                                        </table>
                                        <br>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <fieldset>
                                        <legend><span>Profile information</span></legend><br>
                                        <table>
                                            <tr>
                                                <td><label>Email address: </label><input type="email" name="student_email" id="student-email" required="true"><br></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Program:</label>
                                                    <select name="program" required="true">
                                                        <option>Choose Program</option>
                                                        <option>Computer Systems Engineering</option>
                                                        <option>Software Engineering</option>
                                                        <option>Communications Engineering</option>
                                                        <option>Biomedical and Electrical Engineering</option>
                                                        <option>Electrical Engineering</option>
                                                        <option>Special</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Password: </label><input type="password" name="password" id="password1" required="true">
                                                    <span id="password-error" style="color: red;"></span><br>
                                                    <label>Confirm Password: </label><input type="password" maxlength="255" name="confirm-password" id="password2" required="true"><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p id="email-error" style="color: red;"></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <fieldset>
                                        <input type="submit" value="Register" name="submit-register">
                                        <input type="reset">
                                        <br>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                    </form>
                </section>
                <br>
                <!-- <p>If you are a returning user, please login <a href="login.php">here</a>.</p> -->
            </td>

            <td class="user-profile">
                <div>
                </div>
            </td>
        </tr>
    </table>

    <script>
        function checkRegistration() {
            var password = document.getElementById('password1').value;
            var confirmPassword = document.getElementById('password2').value;
            var passwordError = document.getElementById('password-error');

            // Check the password fields
            if (password !== confirmPassword) {
                passwordError.textContent = 'The passwords entered do not match.';
                console.log("Passwords do not match.");
                return false;
            } 
            else {
                passwordError.textContent = '';
                console.log("Passwords match.");
                return true;
            }
        }
    </script>

    <?php
        include("connection.php");

        // CHECK IF THE REGISTER FORM WAS SUBMITTED
        if (isset($_POST["submit-register"]) && isset($_SESSION)) {
            try {
                // Connect to the database
                $conn = new mysqli($server_name, $username, $password, $database_name);
                if ($conn->connect_error) {
                    die("Error: Couldn't connect. <br>" . $conn->connect_error);
                }
                // Save the values inputted
                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $student_email = $_POST["student_email"];
                $program = $_POST["program"];
                $dob = $_POST["DOB"];
                $password = $_POST["password"];

                // Check if the email is in the DB already
                $sql = "SELECT * FROM users_info WHERE student_email = ?";
                $statement = $conn->prepare($sql);
                $statement->bind_param('s', $student_email);
                $statement->execute();
                $email_exists_result = $statement->get_result();
                $email_exists_result = $email_exists_result->fetch_assoc();

                if ($email_exists_result) {
                    // The email exists in the database, display an error message.
                    // Close the connection to the database
                    $conn->close();
    ?>
    <script>
        console.log("email already exists, displaying error message");
        var emailError = document.getElementById('email-error');
        emailError.innerHTML = "<p>An account with this email already exists.</p><p>Please enter a new email, or, if you are a returning user, please login <a href='login.php'>here</a>.</p>";
    </script>
    <?php
                }
                else {
                    // If the email does not exist in the database, insert the data into the users_info table
                    $sql = "INSERT INTO users_info (student_email, first_name, last_name, dob) 
                            VALUES ('$student_email', '$first_name', '$last_name', '$dob')";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    // Get the latest student_id added
                    $latest_id = mysqli_insert_id($conn);
                    $_SESSION['student_id'] = $latest_id;
                    
                    // Insert the data submitted into the users_program table
                    $sql = "INSERT INTO users_program (student_id, program)
                            VALUES ('$latest_id', '$program')";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    // Insert the data submitted into the users_avatar table
                    $sql = "INSERT INTO users_avatar (student_id, avatar)
                            VALUES ('$latest_id', 0)";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    // Insert the data submitted into the users_address table
                    $sql = "INSERT INTO users_address (student_id, street_number, street_name, city, province, postal_code)
                            VALUES ('$latest_id', 0, NULL, NULL, NULL, NULL)";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    // Hash the password, then store into database
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "INSERT INTO users_passwords (student_id, password)
                            VALUES ('$latest_id', '$hashed_password')";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    // Add the user permission
                    $sql = "INSERT INTO users_permissions (student_id, account_type)
                            VALUES ('$latest_id', 1)";
                    $statement = $conn->prepare($sql);
                    $statement->execute();

                    // Update session variables.
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['dob'] = $dob;
                    $_SESSION['student_email'] = $student_email;
                    $_SESSION['avatar'] = $avatar;
                    $_SESSION['program'] = $program;
                    $_SESSION['permission_level'] = 1;
                    
                    // Close the connection to the database
                    $conn->close();
    ?>
    <script>
        console.log("updated sessions in register");
        var emailError = document.getElementById('email-error'); 
        emailError.textContent = "";
        window.location = "profile.php";
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
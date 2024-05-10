<?php
    session_start();
    
    if (!isset($_SESSION['student_id'])) {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Update SYSCX profile</title>
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
                        <li> <a href="profile.php" id='nav-sel'>Profile</a></li>
                        <!-- <li> <a href="register.php">Register</a></li> -->
                        <!-- <li> <a href="login.php">Login</a></li> -->
                        <?php
                            if ($_SESSION["permission_level"] == 0) {
                                echo '<li><a href="user_list.php">User List</a></li>';
                            }
                        ?>
                        <li> <a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </td>

            <td class="main">
                <section>
                    <h2>Update Profile information</h2>
                    <form method="post" action="">
                        <table>
                            <tr><td>
                                <fieldset>
                                    <legend><span>Personal information</span></legend><br>
                                    <table>
                                        <tr>
                                            <td><label>First Name: </label></td>
                                            <td><input type="text" name="first_name" id="first_name" required="true"></td>
                                            <td><label>Last Name: </label></td>
                                            <td><input type="text" name="last_name" id="last_name" required="true"></td>
                                            <td><label>DOB: </label></td>
                                            <td><input type="date" name="DOB" id="DOB" required="true"></td>
                                        </tr>
                                    </table>
                                    <br>
                                </fieldset>
                            </td></tr>
                            <tr><td>
                                <fieldset>
                                    <legend><span>Address</span></legend><br>
                                    <table>
                                        <tr>
                                            <td><label>Street Number:</label></td>
                                            <td><input type="number" name="street_number" id="street_number" required="true"></td>
                                            <td><label>Street Name:</label></td>
                                            <td><input type="text" name="street_name" id="street_name" required="true"></td>
                                            <td><label>City:</label></td>
                                            <td><input type="text" name="city" id="city" required="true"></td>
                                        </tr>
                                        <tr>
                                            <td><label>Province:</label></td>
                                            <td><input type="text" name="province" id="province" required="true"></td>
                                            <td><label>Postal Code:</label></td>
                                            <td><input type="text" name="postal_code" id="postal_code" required="true"></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <br>
                                </fieldset>
                            </td></tr>
                            <tr><td>
                                <fieldset>
                                    <legend><span>Profile information</span></legend><br>
                                    <table>
                                        <tr>
                                            <td><label>Email address: </label> <input type="email" name="student_email" id="student_email" required="true"><br></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Program:</label>
                                                <select name="program" id="program" required="true">
                                                    <option value='Choose Program'>Choose Program</option>
                                                    <option value='Computer Systems Engineering'>Computer Systems Engineering</option>
                                                    <option value='Software Engineering'>Software Engineering</option>
                                                    <option value='Communications Engineering'>Communications Engineering</option>
                                                    <option value='Biomedical and Electrical Engineering'>Biomedical and Electrical Engineering</option>
                                                    <option value='Electrical Engineering'>Electrical Engineering</option>
                                                    <option value='Special'>Special</option>
                                                </select><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <br>
                                                <label>Choose your Avatar:</label><br><br>
                                                <input type="radio" name="avatar" id="avatar0" value="0"><img src="images/img_avatar1.png" alt="img1">
                                                <input type="radio" name="avatar" id="avatar1" value="1"><img src="images/img_avatar2.png" alt="img2">
                                                <input type="radio" name="avatar" id="avatar2" value="2"><img src="images/img_avatar3.png" alt="img3">
                                                <input type="radio" name="avatar" id="avatar3" value="3"><img src="images/img_avatar4.png" alt="img4">
                                                <input type="radio" name="avatar" id="avatar4" value="4"><img src="images/img_avatar5.png" alt="img5">
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                </fieldset>
                            </td></tr>
                            <tr><td>
                                <fieldset>
                                    <input type="submit" value="Submit" name="submit-profile">
                                    <input type="reset">
                                    <br>
                                </fieldset>
                            </td></tr>
                        </table>
                    </form>
                </section>
            </td>


            <td class="user-profile">
                <div>
                    <p>
                        <?php
                            if (isset($_SESSION) && isset($_SESSION["student_id"])) {
                                echo $_SESSION["first_name"] . " " . $_SESSION["last_name"];
                            }
                        ?>
                    </p>
                    <p>
                        <?php
                            if (isset($_SESSION) && isset($_SESSION["student_id"])) {
                                $avatar_img = "";
                                if ($_SESSION["avatar"] == 0) {
                                    $avatar_img = "images/img_avatar1.png";
                                }
                                elseif ($_SESSION["avatar"] == 1) {
                                    $avatar_img = "images/img_avatar2.png";
                                }
                                elseif ($_SESSION["avatar"] == 2) {
                                    $avatar_img = "images/img_avatar3.png";
                                }
                                elseif ($_SESSION["avatar"] == 3) {
                                    $avatar_img = "images/img_avatar4.png";
                                }
                                elseif ($_SESSION["avatar"] == 4) {
                                    $avatar_img = "images/img_avatar5.png";
                                }
                                else {
                                    // error
                                }
                                echo '<img src=' . $avatar_img . ' alt="User\'s Avatar">';
                            }
                        ?>
                    </p>
                    <p>
                        <?php
                            if (isset($_SESSION) && isset($_SESSION["student_id"])) {
                                echo "Email: ";
                                echo '<a href="mailto:' . $_SESSION["student_email"] . '">' . $_SESSION["student_email"] . '</a>';
                            }
                        ?>
                    </p>
                    <p>
                        <?php
                            if (isset($_SESSION) && isset($_SESSION["student_id"])) {
                                echo "Program: <br>";
                                echo $_SESSION['program'];
                            }
                        ?>
                    </p>
                </div>
            </td>
            
        </tr>
    </table>

    <script>
        console.log("profile - initial fields");

        let firstName = "<?php echo isset($_SESSION["first_name"]) ? $_SESSION["first_name"] : ''; ?>";
        let lastName = "<?php echo isset($_SESSION["last_name"]) ? $_SESSION["last_name"] : ''; ?>";
        let dob = "<?php echo isset($_SESSION["dob"]) ? $_SESSION["dob"] : ''; ?>";
        let studentEmail = "<?php echo isset($_SESSION["student_email"]) ? $_SESSION["student_email"] : ''; ?>";
        let avatarSel = "<?php echo isset($_SESSION["avatar"]) ? $_SESSION["avatar"] : '0'; ?>";
        let program = "<?php echo isset($_SESSION["program"]) ? $_SESSION["program"] : 'Choose Program'; ?>";

        console.log(firstName);

        let streetNumber = "<?php echo isset($_SESSION['street_number']) ? $_SESSION['street_number'] : ''; ?>";
        let streetName = "<?php echo isset($_SESSION['street_name']) ? $_SESSION['street_name'] : ''; ?>";
        let city = "<?php echo isset($_SESSION['city']) ? $_SESSION['city'] : ''; ?>";
        let province = "<?php echo isset($_SESSION['province']) ? $_SESSION['province'] : ''; ?>";
        let postalCode = "<?php echo isset($_SESSION['postal_code']) ? $_SESSION['postal_code'] : ''; ?>";

        // Update the values of the input text boxes
        document.getElementById("first_name").value = firstName;
        document.getElementById("last_name").value = lastName;
        document.getElementById("DOB").value = dob;
        document.getElementById("student_email").value = studentEmail;

        document.getElementById("street_number").value = streetNumber;
        document.getElementById("street_name").value = streetName;
        document.getElementById("city").value = city;
        document.getElementById("province").value = province;
        document.getElementById("postal_code").value = postalCode;

        let avOptions = document.querySelectorAll('input[type="radio"]');
        avOptions.forEach(avatar => {
            if (avatar.value === avatarSel.toString()) {
                avatar.checked = true;
            }
            else {
                avatar.checked = false;
            }
        });

        let programList = document.getElementById('program');
        for (let i = 0; i < programList.options.length; i++) {
            const option = programList.options[i];
            if (option.value === program.toString()) {
                option.selected = true;
                break;
            }
        }
    </script>

    <p>
        <?php
            include("connection.php");

            if ( (isset($_POST["submit-profile"])) && (isset($_SESSION['student_id'])) ) {
                try {
                    // Connect to the database
                    $conn = new mysqli($server_name, $username, $password, $database_name);
                    if ($conn->connect_error) {
                        die("Error: Couldn't connect. <br>" . $conn->connect_error);
                    }
                    $student_id = $_SESSION['student_id'];

                    // Save the values inputted into the form
                    $first_name = $_POST["first_name"];
                    $last_name = $_POST["last_name"];
                    $dob = $_POST["DOB"];
                    $street_number = $_POST["street_number"];
                    $street_name = $_POST["street_name"];
                    $city = $_POST["city"];
                    $province = $_POST["province"];
                    $postal_code = $_POST["postal_code"];
                    $student_email = $_POST["student_email"];
                    $program = $_POST["program"];
                    $avatar = $_POST["avatar"];

                    // Insert the data submitted into the users_info table
                    $sql = "UPDATE users_info 
                            SET student_email='$student_email', first_name='$first_name', last_name='$last_name', dob='$dob'
                            WHERE student_id = ?;";
                    $statement = $conn->prepare($sql);
                    $statement->bind_param('i', $student_id);
                    $statement->execute();

                    // Insert the data submitted into the users_program table
                    $sql = "UPDATE users_program
                            SET program='$program'
                            WHERE student_id = ?;";
                    $statement = $conn->prepare($sql);
                    $statement->bind_param('i', $student_id);
                    $statement->execute();

                    // Insert the data submitted into the users_avatar table
                    $sql = "UPDATE users_avatar
                            SET avatar='$avatar'
                            WHERE student_id = ?;";
                    $statement = $conn->prepare($sql);
                    $statement->bind_param('i', $student_id);
                    $statement->execute();

                    // Insert the data submitted into the users_address table
                    $sql = "UPDATE users_address
                            SET street_number='$street_number', street_name='$street_name', city='$city', province='$province', postal_code='$postal_code'
                            WHERE student_id = ?;";
                    $statement = $conn->prepare($sql);
                    $statement->bind_param('i', $student_id);
                    $statement->execute();

                    // Update session variables
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['dob'] = $dob;
                    $_SESSION['student_email'] = $student_email;
                    $_SESSION['avatar'] = $avatar;
                    $_SESSION['program'] = $program;
                    $_SESSION['street_number'] = $street_number;
                    $_SESSION['street_name'] = $street_name;
                    $_SESSION['city'] = $city;
                    $_SESSION['province'] = $province;
                    $_SESSION['postal_code'] = $postal_code;

                    // Close connection
                    $conn->close();
        ?>
        <script>
            console.log("updated sessions in profile.php, refreshing page.");
            window.location = "profile.php";
        </script>
        <?php
                }
                catch (mysqli_sql_exception $e) {
                    // Catch an unsuccessful connection
                    $error = $e->getMessage();
                    echo $error;
                }
            }
        ?>
    </p>

</body>
</html>

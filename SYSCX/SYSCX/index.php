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
                        <li><a href="index.php" id='nav-sel'>Home</a></li>
                        <?php
                            if (isset($_SESSION['student_id'])) {
                                // user is logged in
                                echo '<li><a href="profile.php">Profile</a></li>';
                                echo '<li><a href="logout.php">Logout</a></li>';
                                if ($_SESSION["permission_level"] == 0) {
                                    echo '<li><a href="user_list.php">User List</a></li>';
                                }
                            }
                            else {
                                echo '<li><a href="register.php">Register</a></li>';
                                echo '<li><a href="login.php">Login</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </td>

            <td class="main">
                <section>
                    <h2>New Post</h2>
                    <form method="POST" action="">
                        <fieldset>
                            <table>
                                <tr>
                                    <td>
                                        <p><textarea style="vertical-align:text-top" name="new_post" maxlength="200"
                                            placeholder="What is happening?! (max 200 char)"></textarea>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="Post" name="submit-post">
                                        <input type="reset">
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>

                    <p>
                        <?php
                            // Need to show values even if the form is not submitted...
                            include("connection.php");

                            // Get the current user's student id
                            if ( isset($_SESSION['student_id']) ) {
                                $student_id = $_SESSION['student_id'];

                                try {
                                    // Connect to the database
                                    $conn = new mysqli($server_name, $username, $password, $database_name);
                                    if ($conn->connect_error) {
                                        die("Error: Couldn't connect. <br>" . $conn->connect_error);
                                    }
                                    // Query data
                                    $sql = "SELECT * FROM users_posts ORDER BY post_date DESC LIMIT 10;";
                                    $statement = $conn->prepare($sql);
                                    $statement->execute();
                                    $result = $statement->get_result();

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<br>';
                                            echo '<details>';
                                                echo '<summary>Post ' . $row["post_id"] . '</summary>';
                                                echo '<p>' . $row["new_post"] . '</p>';
                                            echo '</details>';
                                        }
                                    }
                                    // Close the connection to the database
                                    $conn->close();
                                }
                                catch (mysqli_sql_exception $e) {
                                    // Catch an unsuccessful connection
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                            }

                            if ( isset($_POST["submit-post"]) ) {
                                try {
                                    // Connect to the database
                                    $conn = new mysqli($server_name, $username, $password, $database_name);
                                    if ($conn->connect_error) {
                                        die("Error: Couldn't connect. <br>" . $conn->connect_error);
                                    }

                                    // Save the values inputted
                                    $new_post = $_POST["new_post"];

                                    // Get the current user's student id
                                    if (isset($_SESSION['student_id'])) {
                                        $student_id = $_SESSION['student_id'];

                                        // Insert the data submitted into the users_posts table
                                        $sql = "INSERT INTO users_posts (student_id, new_post)
                                                VALUES ('$student_id', '$new_post')";
                                        $statement = $conn->prepare($sql);
                                        $statement->execute();
                                    }
                                    // Close the connection to the database
                                    $conn->close();

                                    header("Location: " . $_SERVER['PHP_SELF']);
                                    exit;
                                }
                                catch (mysqli_sql_exception $e) {
                                    // Catch an unsuccessful connection
                                    $error = $e->getMessage();
                                    echo $error;
                                }
                            }
                        ?>
                    </p>
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

</body>

</html>
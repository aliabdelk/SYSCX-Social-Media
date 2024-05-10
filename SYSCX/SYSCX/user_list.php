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
                        <li><a href="index.php">Home</a></li>
                        <?php
                            if (isset($_SESSION['student_id'])) {
                                // user is logged in
                                echo '<li><a href="profile.php">Profile</a></li>';
                                echo '<li><a href="logout.php">Logout</a></li>';
                                echo '<li><a href="user_list.php" id="nav-sel">User List</a></li>';
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
                    <h2>List of Users</h2>
                    <?php
                        if ($_SESSION["permission_level"] == 1) {
                            // User is an admin
                    ?>
                        <table class="users-list">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Student Email</th>
                                    <th>Program</th>
                                    <th>Account Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include("connection.php");

                                    try {
                                        // Connect to the database
                                        $conn = new mysqli($server_name, $username, $password, $database_name);
                                        if ($conn->connect_error) {
                                            die("Error: Couldn't connect. <br>" . $conn->connect_error);
                                        }

                                        // Query user data
                                        $sql = "SELECT * FROM users_info";
                                        $statement = $conn->prepare($sql);
                                        $statement->execute();
                                        $user_data = $statement->get_result();

                                        if ($user_data && $user_data->num_rows > 0) {
                                            while ($row = $user_data->fetch_assoc()) {
                                                // get the remaining data 
                                                $sql2 = "SELECT * FROM users_permissions WHERE student_id=?";
                                                $statement2 = $conn->prepare($sql2);
                                                $statement2->bind_param('i', $row["student_id"]);
                                                $statement2->execute();
                                                $user_type = $statement2->get_result();
                                                $user_type = $user_type->fetch_assoc();

                                                echo '<tr>';
                                                echo '<td>' . $row["student_id"] . '</td>';
                                                echo '<td>' . $row["first_name"] . '</td>';
                                                echo '<td>' . $row["last_name"] . '</td>';
                                                echo '<td>' . $row["student_email"] . '</td>';
                                                echo '<td>' . $row["program"] . '</td>';
                                                echo '<td>' . $user_type["account_type"] . '</td>';
                                                echo '</tr>';
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
                                ?>
                            </tbody>
                        </table>
                    <?php
                        }
                        else if ($_SESSION["permission_level"] == 0) {
                            // User is a regular user, display error message
                            echo "<br><p style='color: red;'>Permission denied.</p><br>";
                            echo "<p style='color: red;'>Please click here to return to the <a href='index.php'>home page</a>.</p>";
                        }
                        else {
                            // 
                        }
                    ?>
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
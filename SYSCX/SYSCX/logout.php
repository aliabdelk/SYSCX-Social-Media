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

   <p>
    <?php
        if (isset($_SESSION['student_id'])) 
        {
            session_unset();
    ?>
    <script>
        console.log("logging out user.");
    </script>
    <?php
        }
        header("Location: login.php");
        exit;
    ?>
   </p>

</body>
</html>

<?php /*Now included in header.php*/ //session_start(); ?>
<?php include 'header.php'; ?>

<?php
if (!isset($_POST['loginButton'])){
    header('Location: login.php');
    exit();
}

if(isValidLogin(trim($_POST['username']), trim($_POST['password']) ))
{
    setcookie('username', $_POST['username'] );
    $_SESSION['LoggedIn'] = true;

    echo '<br>';
    echo "<a href="."account.php".">Click here to go to your Account Page</a>";
}
else
{
    $_SESSION['LoggedIn'] = false;

    echo '<br>';
    echo '<p>Invalid Username or Password</p>';
    echo "<a href="."login.php".">Click here to go to login page</a>";
}



function isValidLogin($username, $password)
{
    
    $conn = mysqli_connect("localhost", "root", "", "dbrestaurant");
    
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    
    $query = "SELECT username FROM AuthorizedUsers WHERE username='$username' and password='$password'";
    
    $result = mysqli_query($conn, $query);
    
    $rowNum = mysqli_num_rows($result);
    
    mysqli_close($conn);
    
    return $rowNum == 1;
}
?>

<?php include 'footer.php'; ?>
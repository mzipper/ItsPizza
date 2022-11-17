<?php include 'header.php'; ?>

<div class="form">
    <form action="login.response.php" name="loginForm" method="post">

        <br>
        Username: <input type="TEXT" name="username" id="username" size="30"><br>
        Password: <input type="PASSWORD" name="password" id="password" size="40"> <br>

        <br>
        <input type="SUBMIT" name="loginButton" value="Login">

    </form>
</div>

<?php include 'footer.php'; ?>
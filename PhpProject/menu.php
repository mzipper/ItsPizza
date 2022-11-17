<nav>
    <div class="nav">
        <ul id="navigation" class="slimmenu">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="form.php">Order-Form</a></li>
            <?php
            if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == true) {
                echo '<li><a href="account.php">Account</a></li>';
                echo '<li><a href="sign-out.php">Sign-Out</a></li>';
            }
            else {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>
            <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
        
    </div>
    
</nav>
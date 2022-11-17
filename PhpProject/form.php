<?php include "header.php"; ?>
<?php
    require_once 'mysqli.connect.php';


    if(!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn'] == false) {
        echo '<p><b>Note: To place order user must be <a href="login.php">logged in</a>.</b></p>';
    }
?>


<div class="form">
    <form action="form.response.php" name="orderForm" method="post">
        
        
        <br>

        Choose Pizza Type: <br>

        <?php
        $query = "SELECT * FROM pizzas";
        $result = mysqli_query($conn, $query);
        
        
        while ($row = mysqli_fetch_array($result)) {
            echo '<input type="RADIO" name="pizzaType" value="' . $row['Name'] . '" >' . $row['Name'] . ' $' . $row['Price'] . '<br>';
        }
        ?>
        <br>

        Pies <select name="pieQty" id="piesQty">
            <option value="0" SELECTED>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        Slices <select name="sliceQty" id="slicesQty">
            <option value="0" SELECTED>0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select> <br>

        <br>

        Choose Topping: <br>
        
         <?php
        $query = "SELECT * FROM toppings";
        $result = mysqli_query($conn, $query);
        
        
        while ($row = mysqli_fetch_array($result)) {
            echo '<input type="RADIO" name="toppingType" value="' .  $row['Name'] . '" >' .  $row['Name'] . ' $' . $row['Price'] . '<br>';
        }
        ?>
        <br>
        
        
        <br>
        <input type="SUBMIT" name="submitButton" value="Submit Order">

    </form>
</div>

<?php
    mysqli_close($conn);

include "footer.php";

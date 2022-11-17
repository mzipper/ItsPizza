<?php /*Now included in header.php*/ //session_start(); ?>
<?php include 'header.php'; ?>
<?php require_once 'mysqli.connect.php'; ?>
<?php

if(isset($_SESSION['LoggedIn']) )
{
    if($_SESSION['LoggedIn'] == true)
    {
        echo '<br>';
        echo "Hello " . $_COOKIE['username'];
        
        /*
         * Display Account info here in theory.
         * User info
         * Order history
         */
        
        
        $sql = "SELECT pizzas.Name AS PizzaName, pizzas.Price AS PizzaPrice,
                    toppings.Name AS ToppingName, toppings.Price AS ToppingPrice,
                    pizzaorders.Quantity AS Quantity, pizzaorders.Price AS TotalPrice
                FROM pizzaorders
                INNER JOIN orders ON pizzaorders.OrderID = orders.OrdersID
                INNER JOIN pizzas ON pizzaorders.PIzzaID = pizzas.PizzaID
                INNER JOIN toppings ON pizzaorders.ToppingID = toppings.ToppingsID
                INNER JOIN authorizedusers ON orders.AuthorizedUserID = authorizedusers.AuthorizedUsersID
                WHERE authorizedusers.Username = ?
                ORDER BY orders.OrderDate";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $_COOKIE['username']);

        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        $rowNum = mysqli_num_rows($result);
        
        echo '<br><br>';
        
        if($rowNum < 1) {
            echo 'No Orders Found';
        }
        
        echo '<br><br>';
        
        echo '
            <table>
                <caption>
                    Your Order History
                </caption>
                <thead>
                    <tr>
                        <th>Pizza Type</th>
                        <th>Pizza Price</th>
                        <th>Topping</th>
                        <th>Topping Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                ';
        if($rowNum >=1) {
            while ($row = mysqli_fetch_array($result)) {
                    echo '
                    <tr>
                        <td>'. $row['PizzaName'] . '</td>
                        <td>$'. $row['PizzaPrice'] . '</td>
                        <td>'. $row['ToppingName'] . '</td>
                        <td>$'. $row['ToppingPrice'] . '</td>
                        <td>'. $row['Quantity'] . '</td>
                        <td>$'. $row['TotalPrice'] . '</td>
                    </tr>
                    ';
            }
        }
        else {
            echo '
                    <tr>
                        <td> --- </td>
                        <td> --- </td>
                        <td> --- </td>
                        <td> --- </td>
                        <td> --- </td>
                        <td> --- </td>
                    </tr>
                    ';
        }
        
                    echo '
                </tbody>
            </table>
        ';
        
        
        
        
        
        echo '<br><br><br>';
        echo 'Account Info: ... <br>';
    }
    else
    {
        echo '<br>';
        echo 'ERROR: no user is logged in <br>';
        echo '<br>';
        echo "<a href="."login.php".">login</a>";
    }
}
else {
    header('Location: login.php');
    exit();
}

?>



<?php include 'footer.php'; ?>
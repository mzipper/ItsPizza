<?php include 'header.php';
require_once 'mysqli.connect.php';

if (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn'] == false || !isset($_POST['submitButton'])){
    header('Location: login.php');
    exit();
}

//order query using user ID.
$queryOrder = "INSERT INTO orders (orders.AuthorizedUserID)
	SELECT authorizedusers.AuthorizedUsersID
     	FROM authorizedusers
     	WHERE username = ?";

$statmnt = mysqli_prepare($conn, $queryOrder);
mysqli_stmt_bind_param($statmnt, 's', $_COOKIE['username']);

mysqli_stmt_execute($statmnt);


//get the order ID created in previous query.
$orderId = mysqli_insert_id($conn);

//pizzaOrder query.
$queryPizzaOrders = "INSERT INTO pizzaorders
    VALUES (
        NULL,
        $orderId,
        (SELECT pizzas.PizzaID FROM pizzas WHERE Name = ?),
        (SELECT toppings.ToppingsID FROM toppings WHERE Name = ?),
        ?,
        ? * ((SELECT pizzas.Price FROM pizzas WHERE Name = ?) + (SELECT toppings.Price FROM toppings WHERE toppings.Name = ?))
    )";

//calculate slice qty.
$numSlices = $_POST['pieQty'] * 8 + $_POST['sliceQty'];

//prepare, bind, and execute
//pizzaOrders query.
$stmt = mysqli_prepare($conn, $queryPizzaOrders);
mysqli_stmt_bind_param($stmt, 'ssddss',
        $_POST['pizzaType'], $_POST['toppingType'], $numSlices, $numSlices, $_POST['pizzaType'], $_POST['toppingType']);

mysqli_stmt_execute($stmt);


$sql = "SELECT pizzas.Name AS PizzaName, pizzas.Price AS PizzaPrice,
	toppings.Name AS ToppingName, toppings.Price AS ToppingPrice,
    pizzaorders.Quantity AS Quantity, pizzaorders.Price AS TotalPrice
FROM pizzaorders
INNER JOIN orders ON pizzaorders.OrderID = orders.OrdersID
INNER JOIN pizzas ON pizzaorders.PIzzaID = pizzas.PizzaID
INNER JOIN toppings ON pizzaorders.ToppingID = toppings.ToppingsID
WHERE orders.OrdersID = $orderId";


$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_array($result);

echo '<p>Your order was submitted</p>';
echo '<p>Thank you for your order!</p>';
echo '<br>';

echo '
    <table>
        <caption>
            Your Order Details
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
        ';
        echo '
        <tbody>
            <tr>
                <td>'. $data['PizzaName'] . '</td>
                <td>$'. $data['PizzaPrice'] . '</td>
                <td>'. $data['ToppingName'] . '</td>
                <td>$'. $data['ToppingPrice'] . '</td>
                <td>'. $data['Quantity'] . '</td>
                <td>$'. $data['TotalPrice'] . '</td>
            </tr>
        </tbody>
    </table>
';



echo '<br>';

include 'footer.php';
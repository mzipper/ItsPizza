const express = require('express');
const app = express();
const mysql = require('mysql');
const emailjs = require('./email');
const bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: false }));

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "dbrestaurant"
});

con.connect(function (err) {
    console.log(err);
});


app.use(express.static(__dirname + '/public'));
app.set('view engine', 'pug');

/*
Home page
 */
app.get('/', (req, res) => {
    res.render('index', {
        title: 'Home'
    });
});

app.get('/index.html', (req, res) => {
    res.render('index', {
        title: 'Home'
    });
});


//Form page
app.get('/form.html', (req, res) => {
    let toppings;
    let sql = "SELECT * FROM toppings";
    con.query(sql, function (err, result, fields) {
        if (err) throw err;

        toppings = result;

        let sqlPizza = "SELECT * FROM pizzas";
        con.query(sqlPizza, function (err, result, fields) {
            if (err) throw err;

            res.render('form', {
                title: 'Form',
                list: toppings,
                pizzas: result
            });
        });
    });
});

//Form response page
app.post('/form-response.html', (req, res) => {

    let userName = 'bob'; //'guestuser';

    let pieQty = parseInt(req.body.pieQty);
    let sliceQty = parseInt(req.body.sliceQty);
    let pizzaType = mysql.escape(req.body.pizzaType);
    let toppingType = mysql.escape(req.body.toppingType);
    let numSlices = pieQty * 8 + sliceQty;

    //order query using user ID.
    let queryOrder = `INSERT INTO orders (orders.AuthorizedUserID)
    SELECT authorizedusers.AuthorizedUsersID
    FROM authorizedusers
    WHERE username = "${userName}"`;
    con.query(queryOrder, function (err, result, fields) {
        if (err) throw err;


        //get the order ID created in previous query.
        let orderId = result.insertId;

        //pizzaOrder query.
        let queryPizzaOrders = `INSERT INTO pizzaorders
                                VALUES (NULL,
                                        ${orderId},
                                        (SELECT pizzas.PizzaID FROM pizzas WHERE Name = ${pizzaType}),
                                        (SELECT toppings.ToppingsID FROM toppings WHERE Name = ${toppingType}),
                                        ${numSlices},
                                        ${numSlices} * ((SELECT pizzas.Price FROM pizzas WHERE Name = ${pizzaType}) +
                                                        (SELECT toppings.Price
                                                         FROM toppings
                                                         WHERE toppings.Name = ${toppingType})))`;
        con.query(queryPizzaOrders, function (err, result, fields) {
            if (err) throw err;

            res.render('form-response', {
                title: 'Form Response'
            });
        });
    });
});

//Account page
app.get('/account.html', (req, res) => {
    let userName = 'bob'; //'guestuser';
    let sql = `SELECT pizzas.Name AS PizzaName, pizzas.Price AS PizzaPrice,
        toppings.Name AS ToppingName, toppings.Price AS ToppingPrice,
            pizzaorders.Quantity AS Quantity, pizzaorders.Price AS TotalPrice
        FROM pizzaorders
        INNER JOIN orders ON pizzaorders.OrderID = orders.OrdersID
        INNER JOIN pizzas ON pizzaorders.PIzzaID = pizzas.PizzaID
        INNER JOIN toppings ON pizzaorders.ToppingID = toppings.ToppingsID
        INNER JOIN authorizedusers ON orders.AuthorizedUserID = authorizedusers.AuthorizedUsersID
        WHERE authorizedusers.Username = "${userName}"
            ORDER BY orders.OrderDate`;

    con.query(sql, function (err, result, fields) {
        if (err) throw err;

        res.render('account', {
            title: 'Account',
            list: result,
            user: userName
        });
    })
});

//Login page
app.get('/login.html', (req, res) => {
    res.render('login', {
        title: 'Login'
    });
});

//Contact Us page
app.get('/contact-us.html', (req, res) => {
    res.render('contact-us', {
        title: 'Contact Us'
    });
});

/*
Receive form data from the contact-us form.
Process form data ie send the email.
Send feedback that email was sent with related info to browser.
 */
app.post('/contact-us', (req, res) => {

    let name = req.body.name;
    let email = req.body.email;
    let subject = req.body.subject;
    let message = req.body.message;

    let msgEmail = `Name: ${name} , Email: ${email}
        Message: ${message}`;

    emailjs.sendEmail(subject, msgEmail);

    let msg = `Name: ${name} , Email: ${email}
        Subject: ${subject}
        Message: ${message}`;

    res.render('email-sent', {
        title: 'Email Sent',
        msg: msg
    });
});



const server = app.listen(8099, () => {
    console.log(`Express running -> PORT ${server.address().port}`);
});
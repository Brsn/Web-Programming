

<?php
session_start();
setlocale(LC_MONETARY, 'en_US');
$product_id = $_POST['Select_Product']; //the product id from dropdown
$action = $_POST['action']; // the action from the URL
switch ($action) { //decide what to do
    case "Add":
        echo "";
        $_SESSION['cart'][$product_id] ++; //add one to the quantity of the product with id $product_id
        break;
    case "Remove":
        echo "Removing";
        $_SESSION['cart'][$product_id] --; // remove one from the quantity of the product with id $product_id
        if ($_SESSION['cart'][$product_id] <= 0)
            unset($_SESSION['cart'][$product_id]); //if the quanity is zero, remove it completely (using the 'unset' function) 
        break;
    case "Empty":
        unset($_SESSION['cart']); //unset the whole cart, i.e e,pty car
        break;
    case "Info":
        $infonum = $product_id;
        break;
}
//print_r($_SESSION);
require_once 'Databaseconnection.php';
echo "<a href='logout.php'>Logout</a>";
?>

<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <link href="data:image/x-icon;base64,AAABAAEAEBAAAAAAAABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAA19fXAMCAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIBAQECAgICAgICAQEBAgICAQABAgICAgICAgEAAQICAgEAAQECAgECAgEBAAEBAgIBAAAAAQEAAQEAAQAAAAEBAQABAQABAAEBAAEAAQEAAQEAAQEAAQABAQABAAEBAAEBAAEBAAEAAQEAAQABAQABAQAAAAEBAAAAAQEAAAABAQIBAQECAQABAQICAQEBAgICAgICAgEAAQICAgICAgICAgICAgIBAQECAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=" rel="icon" type="image/x-icon" />
        <title>Shopping Cart</title>
        <link href="/CSIS2440/CodeEx/view.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container center-block">
        <div class="form" id="form_container">
            <form action="ShoppingCart.php" method="Post">
                <div>
                 <h2 class="text-left">WELCOME!</h2>
                    <p><span class="text">Please Select a product:</span>
                        <select id="Select_Product" name="Select_Product" onchange="productInfo(this.value)" class="select">
                            <option value=""></option>
                            <option value='2'>Atom Re-Arranger</option>
                            <option value='3'>Bed Springs</option>
                            <option value='4'>Bird Seed</option>
                            <option value='5'>Blasting Power</option>
                            <option value='6'>Cork</option>
                            <option value='7'>Dsintigration Pistol</option>
                            <option value='8'>Earthquake Pills</option>
                            <option value='9'>Female Roadrunner Costume</option>
                            <option value='10'>Giant Rubber Band</option>
                            <option value='11'>Instant Girl</option>
                            <option value='12'>Iron Carrot</option>
                            <option value='13'>Jet Propelled Unicycle</option>
                            <option value='14'>Outboard Moter</option>
                            <option value='15'>Railroad Track</option>
                            <option value='16'>Rocket Sled</option>
                            <option value='17'>Super Outfit</option>
                            <option value='18'>Time Space Gun</option>
                            <option value='19'>Xray</option>
                        </select></p>

                    <?php
                    //setting the select statement and running it
                    $search = "SELECT * FROM ACME.products order by name";
                    $return = $con->query($search);

                    if (!$return) {
                        $message = "Whole query " . $search;
                        echo $message;
                        die('Invalid query: ' . mysqli_error());
                    }
                    while ($row = mysqli_fetch_array($return)) {
                        if ($row['idproducts'] == $product_id) {
                            echo "<option value'" . $row['idproducts'], "'>"
                            . $row['Item'] . "</option>";
                        }
                    }
                    ?>

                    <table><tr>
                            <td>
                                <input id="button_Add" type="submit" value="Add" name="action" class="button"/>
                            </td>
                            <td>
                                <input name="action" type="submit" class="button" id="button_Remove" value="Remove"/>
                            </td>
                            <td>
                                <input name="action" type="submit" class="button" id="button_empty" value="Empty"/>
                            </td>
                            <td>
                                <input name="action" type="submit" class="button" id="button_Info" value="Info"/>
                            </td>
                        </tr>                    
                    </table>

                </div>
                <div id="productInformation">

                </div>
                <div>
                </div>
                <div>
                    You have no items in your shopping cart.
                </div>
            </form>
        </div>
        <div>
            <?php
            if ($infonum > 0) {
                $sql = "SELECT name, description, price, productImage FROM ACME.products WHERE idproducts = " . $infonum;
                //echo $sql;
                echo "<table align ='left' width='100%'><tr><th>name</th><th>description</th><th>price</th><th>productImage</th></tr>";
                $result = $con->query($sql);
                //Only display the row if there is a product (though there should always be as we have already checked)
                if (mysqli_num_rows($result) > 0) {
                    list($infoname, $infodescription, $infoprice, $infoimage) = mysqli_fetch_row($result);
                    echo "<tr>";
//show this information in table cells
                    echo "<td align=\"left\" width=\"450px\">$infoname</td>";
                    echo "<td align=\"left\" width=\"325px\">" . money_format('%(#8n', $infoprice) . " </td>";
                    echo "<td align=\"center\">$infodescription</td>";
                    echo "<td align=\"left\" width=\"450px\"><img src='e-commerce\\$infoimage' height=\"160\" width=\"160\"></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
            <div>
                <?php
                if ($_SESSION['cart']) { //if the cart isn't empty
                    //show the cart
                    echo " <table border=\"1\" padding=\"3\" width=\"640px\"><tr><th>name</th><th>description</th><th>price</th><th>total cost</th>"
                    . "<th width=\"80px\">Product Image</th></tr>"; // format the cart using a HTML table
//iterate through the car, the $product_id is the key and $quantity is the value
                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        $sql = "SELECT name, description, price, productImage FROM ACME.products WHERE idproducts = " . $product_id;
//echo $sql;
                        $result = $con->query($sql);
//only display the row if there 
                        if (mysqli_num_rows($result) > 0) {
                            list($name, $description, $price, $productImage) = mysqli_fetch_row($result);
                            $line_cost = $price * $quantity; //workout the line cost
                            $total = $total + $line_cost; //add to the total cost
                            echo "<tr>";
                            //show this information in table cells
                            echo "<td align=\Left\"\width=\"450px\">$name</td>";
                            echo "<td align=\"center\" width=\"75px\">$description</td>";

                            echo "<td align=\"center\" width=\"75px\">" . money_format('%(#8n', $price) . "</td>";

                            echo "<td align=\"center\">" . money_format('%(#8n', $line_cost) . "</td>";

                            echo "<td>$productImage</td>";

                            echo "</tr>";
                        }
                    }
                    //show the total(
                    echo "<tr>";
                    echo "<td align=\"right\">The right price!</td><td align=\"right\"></td><td align=\"right\">Total</td>";
                    echo "<td align=\"right\">" . money_format('%(#8n', $total) . "</td>";
                    echo "</tr>";
                    echo "</table>";
                } else {
                    //otherwise tell the user they have no items in their cart
                    echo "Shop.";
                }
                mysqli_close($con)
                ?>

            </div>
        </div>

    </body>
</html>

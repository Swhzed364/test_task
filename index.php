<!DOCTYPE html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<title>Title</title>

</head>
<body>

    <?php

        $host = 'localhost';
        $userName = 'guest';
        $password = 'guestpass';
        $dbName = 'CProducts';

        $dataBase = new mysqli ($host, $userName, $password, $dbName);

        if($dataBase->connect_error) {
            echo "Error #".$dataBase->connect_errno."<br>";
            echo $dataBase->connect_error."<br>";
        }

        class CProducts {

            public function getProducts (mysqli $dataBase, int $numberOfRows) {

                $productsList = $dataBase->query("SELECT * FROM Products WHERE IS_HIDDEN = 0  ORDER BY `Products`.`DATE_CREATE` DESC");

                for ($i = 0; $i < $productsList->num_rows; $i++) {
                    $ProductListArr[$i] = $productsList->fetch_array(MYSQLI_ASSOC);
                }
            
                for ($i = 0; $i < $numberOfRows && $i < sizeof($ProductListArr); $i++) {
                    $result[$i] = $ProductListArr[$i];
                }

                return $result;
            }

            public function drawTable (array $cProducts) {

                $id = '<th>ID</th>';
                $productID = '<th>Product ID</th>';
                $productName = '<th>Name</th>';
                $productPrice = '<th>Price</th>';
                $productArticle = '<th>Article</th>';
                $productQuantity = '<th>Quantity</th>';
                $dateCreate = '<th>Date of creation</th>';
                $hideButton = '<th>Hide</th>';
    
                echo '<table><tr>' . $id . $productID . $productName . $productPrice . $productArticle . $productQuantity . $dateCreate . $hideButton . '</tr>';
                for ($i = 0; $i < sizeof($cProducts); $i++) {
                    echo '<tr id="row' . $cProducts[$i]['ID'] .'">';
                        echo '<td>' . $cProducts[$i]['ID'] . '</td>';
                        echo '<td>' . $cProducts[$i]['PRODUCT_ID'] . '</td>';
                        echo '<td>' . $cProducts[$i]['PRODUCT_NAME'] . '</td>';
                        echo '<td>' . $cProducts[$i]['PRODUCT_PRICE'] . '</td>';
                        echo '<td>' . $cProducts[$i]['PRODUCT_ARTICLE'] . '</td>';
                        echo '<td><div id="PRODUCT_QUANTITY' . $cProducts[$i]['ID'] . '">' . $cProducts[$i]['PRODUCT_QUANTITY'] . '</div><div><button onclick="increaseQuantity(' . $cProducts[$i]['ID'] . ')">+</button><button onclick="decreaseQuantity(' . $cProducts[$i]['ID'] . ')">-</button></div></td>';
                        echo '<td>' . $cProducts[$i]['DATE_CREATE'] . '</td>';
                        echo '<td>' . '<button onClick="hideRowAndUpdateDB(' . $cProducts[$i]['ID'] . ')">Hide</button>' . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }
        
        $productsDataBase = new CProducts ();
        $products = $productsDataBase->getProducts($dataBase,5);
        $productsDataBase->drawTable($products);
        
    ?>
        
    <script src='script.js'></script>

    <?php
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $rowToHide = $_POST['rowToHide'];
            $newQuantity = $_POST['newQuantity'];
            $rowID = $_POST['ProductID'];

            if ($rowToHide) $dataBase->query("UPDATE `Products` SET `IS_HIDDEN` = '1' WHERE `Products`.`ID` = " . $rowToHide . ";");
            if ($newQuantity && $rowID) $dataBase->query("UPDATE `Products` SET `PRODUCT_QUANTITY` = '" . $newQuantity ."' WHERE `Products`.`ID` = " . $rowID . ";");
                                                            
        }

    ?>

</body>
</head>
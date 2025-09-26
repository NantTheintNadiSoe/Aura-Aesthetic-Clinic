<?php
function AddProduct($PID, $qty)
{
    include('connect.php');

    $select = "SELECT * FROM product WHERE ProductCode = '$PID'";
    $query = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $data = mysqli_fetch_array($query);

        $pname = $data['ProductName'];
        $pimg = $data['ProductImage'];
        $price = $data['Price'];
        $discount = $data['Discount'];
        $size = $data['ProductSize'];
        $description = $data['Description'];

        if (!isset($_SESSION['ShoppingCart'])) {
            $_SESSION['ShoppingCart'] = array();
        }

        $Index = IndexOf($PID);
        if ($Index == -1) {
            $sizeArr = count($_SESSION['ShoppingCart']);
            $_SESSION['ShoppingCart'][$sizeArr]['ProductCode'] = $PID;
            $_SESSION['ShoppingCart'][$sizeArr]['ProductName'] = $pname;
            $_SESSION['ShoppingCart'][$sizeArr]['ProductImage'] = $pimg;
            $_SESSION['ShoppingCart'][$sizeArr]['Price'] = $price;
            $_SESSION['ShoppingCart'][$sizeArr]['Discount'] = $discount;
            $_SESSION['ShoppingCart'][$sizeArr]['ProductSize'] = $size;
            $_SESSION['ShoppingCart'][$sizeArr]['Description'] = $description;
            $_SESSION['ShoppingCart'][$sizeArr]['Quantity'] = $qty;
        } else {
            $_SESSION['ShoppingCart'][$Index]['Quantity'] += $qty;
        }
    }
}

function RemoveProduct($PID)
{
    $Index = IndexOf($PID);
    unset($_SESSION['ShoppingCart'][$Index]);
    $_SESSION['ShoppingCart'] = array_values($_SESSION['ShoppingCart']);
    echo "<script>window.location='ShoppingCart.php'</script>";
}

function CalculateTotalAmount()
{
    if (isset($_SESSION['ShoppingCart'])) {
        $TotalAmount = 0;
        $size = count($_SESSION['ShoppingCart']);

        for ($i = 0; $i < $size; $i++) {
            $qty = $_SESSION['ShoppingCart'][$i]['Quantity'];
            $Price = $_SESSION['ShoppingCart'][$i]['Price'];
            $discount = $_SESSION['ShoppingCart'][$i]['Discount'];
            $discountedPrice = $Price - ($Price * $discount / 100);
            $TotalAmount += ($qty * $discountedPrice);
        }
        return $TotalAmount;
    } else {
        return 0;
    }
}

function CalculateTotalQuantity()
{
    if (isset($_SESSION['ShoppingCart'])) {
        $TotalQty = 0;
        $size = count($_SESSION['ShoppingCart']);
        for ($i = 0; $i < $size; $i++) {
            $TotalQty += $_SESSION['ShoppingCart'][$i]['Quantity'];
        }
        return $TotalQty;
    } else {
        return 0;
    }
}

function CalculateTaxAmount()
{
    if (isset($_SESSION['ShoppingCart'])) {
        $TotalAmount = CalculateTotalAmount();
        return $TotalAmount * 0.05; // 5% tax
    } else {
        return 0;
    }
}

function IndexOf($PID)
{
    if (!isset($_SESSION['ShoppingCart'])) {
        return -1;
    }

    $size = count($_SESSION['ShoppingCart']);
    if ($size < 1) {
        return -1;
    } else {
        for ($i = 0; $i < $size; $i++) {
            if ($PID == $_SESSION['ShoppingCart'][$i]['ProductCode']) {
                return $i;
            }
        }
        return -1;
    }
}

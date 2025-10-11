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

        // Use StaffCart for staff, ShoppingCart for patients
        if (isset($_SESSION['sid'])) {
            if (!isset($_SESSION['StaffCart'])) {
                $_SESSION['StaffCart'] = array();
            }
            $Index = IndexOfStaff($PID);
            if ($Index == -1) {
                $sizeArr = count($_SESSION['StaffCart']);
                $_SESSION['StaffCart'][$sizeArr]['ProductCode'] = $PID;
                $_SESSION['StaffCart'][$sizeArr]['ProductName'] = $pname;
                $_SESSION['StaffCart'][$sizeArr]['ProductImage'] = $pimg;
                $_SESSION['StaffCart'][$sizeArr]['Price'] = $price;
                $_SESSION['StaffCart'][$sizeArr]['Discount'] = $discount;
                $_SESSION['StaffCart'][$sizeArr]['ProductSize'] = $size;
                $_SESSION['StaffCart'][$sizeArr]['Description'] = $description;
                $_SESSION['StaffCart'][$sizeArr]['Quantity'] = $qty;
            } else {
                $_SESSION['StaffCart'][$Index]['Quantity'] += $qty;
            }
        } else {
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
} // <-- properly closed AddProduct


function RemoveProduct($PID)
{
    // Remove from correct cart
    if (isset($_SESSION['sid'])) {
        $Index = IndexOfStaff($PID);
        unset($_SESSION['StaffCart'][$Index]);
        $_SESSION['StaffCart'] = array_values($_SESSION['StaffCart']);
    } else {
        $Index = IndexOf($PID);
        unset($_SESSION['ShoppingCart'][$Index]);
        $_SESSION['ShoppingCart'] = array_values($_SESSION['ShoppingCart']);
    }
    echo "<script>window.location='ShoppingCart.php'</script>";
}


function CalculateTotalAmount()
{
    $cart = isset($_SESSION['sid']) ? 'StaffCart' : 'ShoppingCart';
    if (isset($_SESSION[$cart])) {
        $TotalAmount = 0;
        $size = count($_SESSION[$cart]);
        for ($i = 0; $i < $size; $i++) {
            $qty = $_SESSION[$cart][$i]['Quantity'];
            $Price = $_SESSION[$cart][$i]['Price'];
            $discount = $_SESSION[$cart][$i]['Discount'];
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
    $cart = isset($_SESSION['sid']) ? 'StaffCart' : 'ShoppingCart';
    if (isset($_SESSION[$cart])) {
        $TotalQty = 0;
        $size = count($_SESSION[$cart]);
        for ($i = 0; $i < $size; $i++) {
            $TotalQty += $_SESSION[$cart][$i]['Quantity'];
        }
        return $TotalQty;
    } else {
        return 0;
    }
}


function CalculateTaxAmount()
{
    $cart = isset($_SESSION['sid']) ? 'StaffCart' : 'ShoppingCart';
    if (isset($_SESSION[$cart])) {
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


function IndexOfStaff($PID)
{
    if (!isset($_SESSION['StaffCart'])) {
        return -1;
    }
    $size = count($_SESSION['StaffCart']);
    if ($size < 1) {
        return -1;
    } else {
        for ($i = 0; $i < $size; $i++) {
            if ($PID == $_SESSION['StaffCart'][$i]['ProductCode']) {
                return $i;
            }
        }
        return -1;
    }
}

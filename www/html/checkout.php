<?php
//require_once ('db.php');
//$db = new DB();
session_start();
require_once('Users.php');
$users = new Users();
//DBからid=1のユーザデータを取得し、名前、Depositを表示す処理
$usersId = 1;
$rows = "";
if (isset($usersId)) {
    $rows = $users->FetchUsersById($usersId);
}
foreach($rows as $row){
    $userName = $row['user_name'];
    $deposit = $row['deposit'];
}
//カート内容を表示するためPOSTの値を受け取って変数に詰める
$image = isset($_POST['image']) ? htmlspecialchars($_POST['image'], ENT_QUOTES, 'utf-8') : '';
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
$price = isset($_POST['price']) ? htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8') : '';
$count = isset($_POST['count']) ? htmlspecialchars($_POST['count'], ENT_QUOTES, 'utf-8') : '';
$total = isset($_POST['total']) ? htmlspecialchars($_POST['total'], ENT_QUOTES, 'utf-8') : '';
$remainingBalance = $deposit-$total;

//もし、sessionにproductsがあったら
if (isset($_SESSION['products'])) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    foreach ($products as $key => $product) {
        //もし、キーとPOSTで受け取った商品名が一致したら、
        if ($key == $name) {
            //既に商品がカートに入っているので、個数を足し算する
            //SESSION内の商品の個数
            $count = (int)$count + (int)$product['count'];
        }
    }
}
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
//if ($name != '' && $count != '' && $price != '' && $image != '') {
//    $_SESSION['products'][$name] = [
//        'count' => $count,
//        'price' => $price,
//        'image' => $image
//    ];
//}

var_dump($products);
var_dump($userName);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Amado - Furniture Ecommerce Template | Checkout</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="index.html"><img src="img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix">
            <!-- Close Icon -->
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <!-- Logo -->
            <div class="logo">
                <a href="index.html"><img src="img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Amado Nav -->
            <nav class="amado-nav">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li class="active"><a href="checkout.php">Checkout</a></li>
                    <li><a href="order-history.php">Order History</a></li>
                </ul>
            </nav>
            <!-- Button Group -->
            <div class="amado-btn-group mt-30 mb-100">
                <a href="#" class="btn amado-btn mb-15">%Discount%</a>
                <a href="add-product.php" class="btn amado-btn active">Add Product</a>
            </div>
            <!-- Cart Menu -->
            <div class="cart-fav-search mb-100">
                <a href="cart.php" class="cart-nav"><img src="img/core-img/cart.png" alt=""> Cart <span>(0)</span></a>
                <a href="#" class="fav-nav"><img src="img/core-img/favorites.png" alt=""> Favourite</a>
                <a href="#" class="search-nav"><img src="img/core-img/search.png" alt=""> Search</a>
            </div>
            <!-- Social Button -->
            <div class="social-info d-flex justify-content-between">
                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </div>
        </header>
        <!-- Header Area End -->

        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-title">
                                <h2>Checkout Confirmation</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($products as $name => $product): ?>
                                    <tr>
                                        <td class="cart_product_desc">
                                            <h5><?php echo $name; ?></h5>
                                        </td>
                                        <td class="price">
                                            <span>$<?php echo $product['price']; ?></span>
                                        </td>
                                        <td class="qty">
                                            <div class="qty-btn d-flex">
                                                <div class="quantity">
                                                    <span><?php echo $product['count']; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>$<?php echo $product['price']*$product['count']; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li><span>name:</span> <span><?php echo $userName?></span></li>
                                <li><span>total:</span> <span>$<?php echo $total?></span></li>
                                <li><span>Deposit Amount:</span> <span>$<?php echo $deposit?></span></li>
                                <li><span class="mr-sm-2">Remaining Balance:</span> <span>$<?php echo $remainingBalance?></span></li>
                            </ul>

                            <div class="payment-method">
                                <!-- Cash on delivery -->
                                <div class="custom-control mr-sm-2">
<!--                                    <input type="checkbox" class="custom-control-input" id="cod" checked>-->
<!--                                    <label class="custom-control-label" for="cod">Cash on Delivery</label>-->
                                </div>
<!--                                &lt;!&ndash; Paypal &ndash;&gt;-->
<!--                                <div class="custom-control custom-checkbox mr-sm-2">-->
<!--                                    <input type="checkbox" class="custom-control-input" id="paypal">-->
<!--                                    <label class="custom-control-label" for="paypal">Paypal <img class="ml-15" src="img/core-img/paypal.png" alt=""></label>-->
<!--                                </div>-->
                            </div>

                            <div class="cart-btn mt-100">
                                <form action="thanks.php" method="POST" class="cart">
                                    <input type="hidden" name="usersId" value="<?php echo $usersId; ?>">
                                    <input type="hidden" name="userName" value="<?php echo $userName; ?>">
                                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                    <input type="hidden" name="count" value="<?php echo $product['count']; ?>">
                                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                                    <input type="hidden" name="remainingBalance" value="<?php echo $remainingBalance; ?>">
                                    <button type="submit"name='confirm' class="btn amado-btn w-100">Confirm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row align-items-center">
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-4">
                    <div class="single_widget_area">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="index.html"><img src="img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-8">
                    <div class="single_widget_area">
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <nav class="navbar navbar-expand-lg justify-content-end">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                                <div class="collapse navbar-collapse" id="footerNavContent">
                                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item active">
                                            <a class="nav-link" href="index.html">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="shop.php">Shop</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cart.php">Cart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="checkout.php">Checkout</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="order-history.php">Order History</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>
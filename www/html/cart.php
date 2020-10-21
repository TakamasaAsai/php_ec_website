<?php
//カート内商品をSESSIONから削除する処理
$delete_name = isset($_POST['delete_name']) ? htmlspecialchars($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';
session_start();
//unset()で削除ボタンを押した変数を破棄する
if ($delete_name != '') unset($_SESSION['products'][$delete_name]);

//POSTで送られてきたカート内商品のデータを変数へ代入
$image = isset($_POST['image']) ? htmlspecialchars($_POST['image'], ENT_QUOTES, 'utf-8') : '';
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
$price = isset($_POST['price']) ? htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8') : '';
$count = isset($_POST['count']) ? htmlspecialchars($_POST['count'], ENT_QUOTES, 'utf-8') : '';
$updateName = isset($_POST['update_quantity_name']) ? htmlspecialchars($_POST['update_quantity_name'], ENT_QUOTES, 'utf-8') : '';
$updateQuantity = isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity'], ENT_QUOTES, 'utf-8') : '';
$subtotal = "";
//var_dump($_POST);
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
//            echo "<br>";
//            echo "個数追加";
        }
        if ($key == $updateName) {
            //既に商品がカートに入っているので、個数を足し算する
            //SESSION内の商品の個数
            $count = (int)$count + (int)$updateQuantity;
            $name = $updateName;
            $price = $product['price'];
            $image = $product['image'];
//            echo "<br>";
//            var_dump($count);
//            echo "個数更新";
        }
    }
}
//   if(isset($products)){
//           foreach($products as $key => $product){
//           echo "<br>";
//           echo $updateName;
//           echo "<br>";
//           echo $updateQuantity;
//           echo "<br>";
//           echo $count;
//           echo "<br>";
//           echo $key;      //商品名
//           echo "<br>";
//           echo $_POST['update_quantity_name'];      //商品名
//           echo "<br>";
//           echo $product['count'];  //商品の個数
//           echo "<br>";
//           echo $product['price']; //商品の金額
//           echo "<br>";
//       }
//   }
//if (isset($_POST['quantity'])) {
//    $count = $_POST['quantity'];
//}
//if ($name == $_POST['update_quantity_name'] && isset($_POST['quantity'])) {
//    $count = $_POST['quantity'];
//    var_dump($product['count']);
//}
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
//var_dump($name, $count,$price,$image);
if ($name != '' && $count != '' && $price != '' && $image != '') {
    $_SESSION['products'][$name] = [
        'count' => $count,
        'price' => $price,
        'image' => $image
    ];
}
//var_dump($product);
//$_SESSION['products']に値が入ってたら、$productsに配列として代入
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];

foreach ($products as $name => $product) {
    //各商品の小計を取得
    $subtotal = (int)$product['price'] * (int)$product['count'];
    //各商品の小計を$totalに足す
    $total += $subtotal;
}
//foreach ($products as $name => $product) {
//    $count = (int)$updateQuantity;
//    echo $count;
//}

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
    <title>Amado - Furniture Ecommerce Template | Cart</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
        function CheckDelete() {
            return confirm("削除してもよろしいですか？");
        }
    </script>
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
                <li class="active"><a href="cart.php">Cart</a></li>
                <li><a href="checkout.php">Checkout</a></li>
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
                    <div class="cart-title mt-50">
                        <h2>Shopping Cart</h2>
                    </div>

                    <div class="cart-table clearfix">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $name => $product): ?>
                                <tr>
                                    <td class="cart_product_img">
                                        <a href="#"><img src="<?php echo $product['image']; ?>" alt="Product"></a>
                                    </td>
                                    <td class="cart_product_desc">
                                        <h5><?php echo $name; ?></h5>
                                    </td>
                                    <td class="price">
                                        <span>$<?php echo $product['price']; ?></span>
                                    </td>
                                    <td class="qty">
                                        <div class="qty-btn d-flex">
                                            <div class="quantity">
                                                <form action="cart.php" method="post" name="update_quantity">
                                                    <span class="qty-minus" onclick="var effect = document.getElementById('qty<?php echo $name; ?>//'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                                    <input type="number" class="qty-text" id="qty<?php echo $name; ?>"
                                                           step="1" min="1" max="300" name="quantity"
                                                           value="<?php echo $product['count']; ?>">
<!--                                                           value="--><?php //echo (isset($count)) ? $count : $product['count']; ?><!--">-->
                                                    <input type="hidden" name="update_quantity_name" value="<?php echo $name; ?>"
                                                    <span class="qty-plus" onclick="var effect = document.getElementById('qty<?php echo $name; ?>//'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                    <button type="submit" class="btn btn-red quantity">更新</button>
                                                </form>
                                                <!--                                                    <button type="submit" class="btn btn-red quantity" name="update_quantity">更新</button>-->
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">$<?php echo $product['price'] * $product['count']; ?>
                                    </td>

                                    <td>
                                        <form action="cart.php" method="post">
                                            <input type="hidden" name="delete_name" value="<?php echo $name; ?>"
                                                   onClick='return CheckDelete()'>
                                            <button type="submit" class="btn btn-red">削除</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="cart-summary">
                        <h5>Cart Total</h5>
                        <ul class="summary-table">
                            <li><span>total:</span> <span>$<?php echo $total ?></span></li>
                        </ul>
                        <div class="cart-btn mt-100">
                            <form action="checkout.php" method="POST" class="cart">
                                <input type="hidden" name="image" value="<?php echo $product['image']; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <input type="hidden" name="total" value="<?php echo $total; ?>">
<!--                                <input type="hidden" value="--><?php //echo (isset($count)) ? $count : $product['count'];?><!--" name="count">-->
                                <input type="hidden" value="<?php echo $product['count'];?>" name="count">
                                <button type="submit"
                                        class="btn amado-btn w-100" <?php if (empty($total)) echo 'disabled="disabled"'; ?>>
                                    Checkout
                                </button>
                                <button type="button"
                                        class="btn amado-btn active w-100" onclick="location.href='shop.php'">
                                    Continue Shopping
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Main Content Wrapper End ##### -->

<!-- ##### Newsletter Area Start ##### -->
<!--    <section class="newsletter-area section-padding-100-0">-->
<!--        <div class="container">-->
<!--            <div class="row align-items-center">-->
<!--                &lt;!&ndash; Newsletter Text &ndash;&gt;-->
<!--                <div class="col-12 col-lg-6 col-xl-7">-->
<!--                    <div class="newsletter-text mb-100">-->
<!--                        <h2>Subscribe for a <span>25% Discount</span></h2>-->
<!--                        <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur. Donec auctor interdum purus, ac finibus massa bibendum nec.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                &lt;!&ndash; Newsletter Form &ndash;&gt;-->
<!--                <div class="col-12 col-lg-6 col-xl-5">-->
<!--                    <div class="newsletter-form mb-100">-->
<!--                        <form action="#" method="post">-->
<!--                            <input type="email" name="email" class="nl-email" placeholder="Your E-mail">-->
<!--                            <input type="submit" value="Subscribe">-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
<!-- ##### Newsletter Area End ##### -->

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
                    <p class="copywrite">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        All rights reserved | This template is made with <i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i> by <a
                                href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            </div>
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-8">
                <div class="single_widget_area">
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        <nav class="navbar navbar-expand-lg justify-content-end">
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#footerNavContent" aria-controls="footerNavContent"
                                    aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i>
                            </button>
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
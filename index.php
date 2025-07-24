<?php include "./includes/header.php";
$sql = "SELECT * FROM products WHERE status = 'active' ORDER BY id DESC LIMIT 8";
$result = $conn->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>

<!-- Header-->
<header class="py-5" style="background: url('/uploads/banner-image.png') center center / cover no-repeat; position: relative;">
    <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; background-color: rgba(0, 0, 0, 0.6);"></div>
    <div class="container px-4 px-lg-5 my-5 position-relative text-center text-white">
        <h1 class="display-4 fw-bolder">Discover Premium Products</h1>
        <p class="lead fw-normal text-white-50 mb-0">Curated collections tailored to your lifestyle</p>
    </div>
</header>

<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php foreach ($products as $product) : ?>
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="<?php echo $product["image_url"]; ?>" alt="<?php echo $product["name"]; ?>"/>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $product["name"]; ?></h5>
                            <!-- Product price-->
                            $<?php echo $product["price"]; ?>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="/product.php?id=<?php echo $product["id"]; ?>">View</a></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include "./includes/footer.php"; ?>

<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
require_once('partials/_analytics.php');
?>
<head>
    <style>
        body{
            background-color: orange;
        }
    </style>
</head>
<body>
<!-- For more projects: Visit codeastro.com  -->
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <br><br><br>
<div class="min-h-screen bg-orange-300 flex flex-col items-center justify-center p-4">
  <div class="w-full max-w-md">
    <div class="mb-4">
      <label for="barcode" class="block text-lg font-semibold mb-2">Scan Barcode:</label>
      <input type="text" id="barcode" class="w-full p-2 border border-zinc-300 rounded" placeholder="Enter barcode">
    </div>
    <div id="productDetails" class="bg-white p-4 rounded shadow-md">
      <div id="productImage" class="flex justify-center mb-4"></div>
      <div id="productInfo"></div>
    </div>
  </div>
</div>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const barcodeInput = document.getElementById('barcode');
    const searchInput = document.getElementById('productCode');
    const productDetails = document.getElementById('productDetails');
    const productImage = document.getElementById('productImage');
    const productInfo = document.getElementById('productInfo');

    barcodeInput.addEventListener('change', function () {
      const barcode = this.value;
      getProductDetails(barcode);
    });

    searchInput.addEventListener('change', function () {
      const productCode = this.value;
      getProductDetails(productCode);
    });

    function getProductDetails(identifier) {
      // Make an AJAX call to get_product_detail.php to fetch product details based on barcode or product code
      fetch(`get_product_detail.php?identifier=${identifier}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const product = data.product;
            // Display product details
            productImage.innerHTML = `<img src="${product.image}" alt="Product image" class="w-24 h-24 object-cover">`;
            productInfo.innerHTML = `
              <p><strong>Order Code:</strong> ${product.order_code}</p>
              <p><strong>Customer Name:</strong> ${product.customer_name}</p>
              <p><strong>Product Name:</strong> ${product.prod_name}</p>
              <p><strong>Product Quantity:</strong> ${product.prod_qty}</p>
              <p><strong>Total:</strong> ${product.total}</p>
              <p><strong>Created At:</strong> ${product.created_at}</p>
            `;
          } else {
            // Handle error if product not found
            productInfo.innerHTML = `<p>${data.message}</p>`;
          }
        })
        .catch(error => console.error('Error:', error));
    }
  });
</script>




<?php require_once('partials/_scripts.php'); ?>

</body>
</html>

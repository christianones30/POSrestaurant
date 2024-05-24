<?php
include('config/config.php');

if (isset($_GET['identifier'])) {
    $identifier = $_GET['identifier'];

    $stmt = $mysqli->prepare("SELECT o.order_code, o.customer_name, p.prod_name, p.prod_qty, (p.prod_price * p.prod_qty) AS total, o.created_at 
                              FROM rpos_orders o
                              JOIN rpos_products p ON o.prod_id = p.prod_id
                              WHERE p.barcode = ? OR p.prod_code = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode(array('success' => true, 'product' => $product));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Product not found'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Identifier parameter is missing'));
}
?>

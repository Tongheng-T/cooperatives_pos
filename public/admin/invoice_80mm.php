<?php require_once("../../resources/config.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="../dist/css/print80m.css">

    <title>RECEIPT : <?php show_customer_name(); ?></title>
</head>
<?php
$id = $_GET['id'];
$select = query("select * from tbl_invoice where invoice_id = $id");
confirm($select);
$row = $select->fetch_object();
$dd = $row->order_date;

function show_customer_name()
{
    $id = $_GET['id'];
    $select = query("select * from tbl_invoice where invoice_id = $id");
    confirm($select);
    $row = $select->fetch_object();
    $customer_name = $row->customer_name;
    $invoice_id = $row->invoice_id;
    echo 'N0 ' . $invoice_id . ' _ ' . $customer_name;
}

?>

<body>
    <div class="ticket">
        <div class="logo">
            <img src="../productimages/a.png" alt="Logo" class="img-fluid">
            <h5 class="h5">សហគមន៍កសិកម្មតំបែររុងរឿង</h5>
        </div>

        <p class="centered">
            <br>Address: Dambea - Tboung Khmum Province
            <br>Email Address: bibben5016@mgail.com
            <br>fackbook: សហគមន៍កសិកម្មតំបែររុងរឿង
            <br>Phone Number: 097-2449-391
            <br>
        </p>
        <hr>
        <h3 class="RECEIPT">RECEIPT</h3>
        <p class="h_p">Bill TO:
        <p class="top_p"><?php echo $row->customer_name ?></p>
        </p>
        <p class="h_p">INVOICE N0:
        <p class="top_p"><?php echo $row->invoice_id ?></p>
        </p>
        <p class="h_p">Date:
        <p class="top_p"><?php echo date('d-m-Y', strtotime($dd)) ?></p>
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>QTY</th>
                    <th>PRICE</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select = query("select * from tbl_invoice_details where invoice_id = $id");
                confirm($select);
                while ($item = $select->fetch_object()) {

                    echo '
                  <tr>
                  <td>' . show_productname($item->product_id) . '</td>
                  <td>' . $item->qty . '</td>
                  <td>' . $item->price . '</td>
                  <td>' . $item->price * $item->qty . '</td>
                 </tr>
                    
                  ';
                }
                ?>


                <tr>
                    <td></td>
                    <th colspan="2">SUBTOTAL</th>
                    <th><?php echo number_format($row->subtotal) ?> <b style="font-size: 16px;">&#x17DB </b></th>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">TAX(5%)</td>
                    <td><?php echo number_format($row->tax) ?> <b style="font-size: 16px;">&#x17DB </b></td>

                </tr>
                <tr>
                    <td></td>
                    <th colspan="2">DISCOUNT</th>
                    <th><?php echo number_format($row->discount) ?> <b style="font-size: 16px;">&#x17DB </b></th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2">TOTAL</th>
                    <th><?php echo number_format($row->total) ?> <b style="font-size: 16px;">&#x17DB </b></th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2">នៅខ្វះ</th>
                    <th><?php echo number_format($row->due) ?> <b style="font-size: 16px;">&#x17DB </b></th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2">PAYMENT TYPE</th>
                    <th><?php echo $row->payment_type ?></th>
                </tr>

            </tbody>
        </table>

        <b>Importan Notice:</b> <br>
        <p>No item will be replaced or refunded if you don have the invoice with you. </p>
<br>
        <p class="oder">អ្នកទិញ: </p>
        <p class="sel">អ្នកលក់: </p>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>
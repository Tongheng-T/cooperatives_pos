<?php require_once("../../resources/config.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="../dist/css/stylee.css">
    <link href="../dist/css/print_pro_list.css" rel="stylesheet" media="print">

    <title>បញ្ជីផលិតផលខែ: <?php date_rank(); ?></title>
</head>

<body>
    <div class="my-5 pagelis" size="A4" id="example-table">
        <div class="p-5">
            <section class="top-content bb d-flex justify-content-between">
                <div class="logo">
                    <img src="../productimages/a.png" alt="" class="img-fluid">
                    <!-- <h5>ក្រសួងអប់រំ យុវជន និងកីឡា</h5> -->
                    <br>
                    <h5 class="h5">សហគមន៍កសិកម្មតំបែររុងរឿង</h5>
                </div>
                <div class="top-left">
                    <div class="graphicc-path">

                        <!-- <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                        <h4 class="margino">ជាតិ សាសនា ព្រះមហាក្សត្រ</h4> -->
                        <b>ថ្ងៃទី: <?php echo date('d-m-Y') ?></b>
                    </div>
                </div>
            </section>
            <div class="dddc">
                <h5>បញ្ជីផលិតផលខែ <?php date_rank(); ?></h5>
            </div>

            <section class="product-area mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>Product name</th>
                            <th>Category</th>
                            <th>Purchaseprice</th>
                            <th>Sale Price</th>
                            <th>Profit</th>
                            <th>Stock</th>

                        </tr>
                    </thead>
                    <tbody id="orderlisttable">
                        <?php
                        $select = query("SELECT * from tbl_product");
                        confirm($select);
                        $no = 1;
                        $totallo = 0;
                        $profit = 0;

                        $Sale_Price = 0;
                        $purchaseprice = 0;
                        $total_profit = 0;

                        $sumstock = 0;
                        while ($row = $select->fetch_object()) {
                            $profit = $row->saleprice - $row->purchaseprice;
                            $sumstock += $row->pstock;

                            $Sale_Price += $row->saleprice;
                            $total_profit += $profit;
                            $purchaseprice += $row->purchaseprice;

                            echo '
                                <tr>
                                <td>' . $no . '</td>
                                <td>' . $row->pname . '</td>
                                <td>' . show_name_category_inview($row->category_id) . '</td>
                                <td>' . $row->purchaseprice . '</td>
                                <td>' . $row->saleprice . '</td>
                                <td>' . $profit . '</td>
                                <td>' . $row->pstock . '</td>

                                <tr>
                                ';

                            $no++;
                        }

                        echo '
                        <tr>
                        <td colspan="2"></td>
                        <th>សរុប</th>
                        <th>' . $purchaseprice . ' <b style="font-size: 16px;">&#x17DB</b></th>
                        <th>' . $Sale_Price . ' <b>&#x17DB</b></th>
                        <th>' . $total_profit . ' <b>&#x17DB</b></th>
                        <th>' . $sumstock . ' </th>
                        </tr>';

                        ?>

                    </tbody>
                </table>
            </section>

            <script>

            </script>


        </div>
    </div>


</body>

</html>
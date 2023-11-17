<?php require_once("../../resources/config.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <xsl:attribute name="page-height">200cm</xsl:attribute> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="../dist/css/stylee.css">
    <link href="../dist/css/print.css" rel="stylesheet" media="print">

    <title>របាយការណ៍ការលក់ប្រភេទ <?php echo show_categoryname($_SESSION['category_id']); ?> ប្រចាំខែ: <?php date_rank(); ?></title>
</head>

<body>
    <div class="my-5 page" size="A4" id="example-table">
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
                        <?php $date_1 = $_SESSION['date_1'];
                        $date_2 = $_SESSION['date_2'];
                        $category_id = $_SESSION['category_id'];

                        function show_customer_name()
                        {
                            $id = $_GET['id'];
                            $select = query("select * from tbl_invoice where invoice_id = $id");
                            confirm($select);
                            $row = $select->fetch_object();
                            $customer_name = $row->customer_name;
                            $invoice_id = $row->invoice_id;
                            echo 'N0 ' . $invoice_id . ' _ ' . $customer_name;
                        } ?>
                        <!-- <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                        <h4 class="margino">ជាតិ សាសនា ព្រះមហាក្សត្រ</h4> -->
                        <b>ចាប់ពីថ្ងៃទី: <?php echo date('d-m-Y', strtotime($date_1)) ?><br> ដល់ថ្ងៃទី: <?php echo date('d-m-Y', strtotime($date_2)) ?></b>
                    </div>
                </div>
            </section>
            <div class="dddc">
                <h5>របាយការណ៍ការលក់ប្រភេទ <?php echo show_categoryname($category_id); ?> ប្រចាំខែ <?php date_rank(); ?></h5>
            </div>

            <section class="product-area mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>ឈ្មោះ​អតិថិជន</th>
                            <th>ឈ្មោះ​ទំនិញ</th>
                            <th>ចំនួន</th>
                            <th>តម្លៃឯកតា</th>
                            <th>តម្លៃសរុប</th>
                            <th>Discount</th>
                            <th>សរុប</th>
                            <th>លេខទូរស័ព្</th>
                            <th>ថ្ងៃខែ</th>
                            <th>ប្រភេទការទូទាត់</th>
                        </tr>
                    </thead>
                    <tbody id="orderlisttable">
                        <?php
                        $select = query("SELECT * from tbl_invoice_details where order_date between '$date_1' AND '$date_2' AND  category_id ='$category_id'");
                        confirm($select);
                        $oupu = "";
                        $totall = 0;
                        $no = 1;
                        while ($row = $select->fetch_object()) {
                            $invoice_id = $row->invoice_id;
                            $row_invoice_detaice = query("SELECT * from tbl_invoice where order_date between '$date_1' AND '$date_2' AND invoice_id = '$invoice_id'");
                            confirm($row_invoice_detaice);



                            while ($row_detaice = $row_invoice_detaice->fetch_object()) {
                                $product_name = show_productname($row->product_id);
                                $oupu .= '
                                <tr>
                                <td>' . $no . '</td>
                                <th>' . $row_detaice->customer_name . '</th>';

                                $oupu .= ' 
                                <td>' . $product_name . '</td>
                                <td>' . number_format($row->qty) . '</td>
                                <td>' . number_format($row->price) . '</td>
                                <td>' . number_format($row->price * $row->qty) . '</td>
                                
                                ';
                                $total_cn = $row->price * $row->qty;
                                $discount = $row_detaice->discount;

                                $phone = $row_detaice->phone;
                                $order_date = $row_detaice->order_date;
                                $payment_type = $row_detaice->payment_type;
                            }
                            $oupu .= '

                                <td>' . number_format($discount) . '</td>
                                <th><span class="label label-danger">' . number_format($total_cn) . ' <b style="font-size: 16px;">&#x17DB </b></span></th>
                                <td>' . $phone . '</td>
                                <td>' . date('d-m-Y', strtotime($order_date)) . '</td>
                            ';

                            if ($payment_type == "Cash") {

                                $oupu .=  '<td><span class="label label-primary">' . $payment_type . '</span></td></tr>';
                            } elseif ($payment_type == "Card") {
                                $oupu .=  '<td><span class="label label-warning">' . $payment_type . '</span></td></tr>';
                            } else {
                                $oupu .=  '<td><span class="label label-info">' . $payment_type . '</span></td></tr>';
                            }
                            $no++;
                            $totall += $total_cn;
                        }

                        $oupu .=
                            '<tr>
                        <td colspan="6"></td>
                        <th>សរុប</th>
                        <th>' . number_format($totall) . ' <b style="font-size: 16px;">&#x17DB </b></th>
                        </tr>
                         ';
                        echo $oupu;


                        ?>

                    </tbody>
                </table>
            </section>

            <script>
                window.print();
            </script>


        </div>
    </div>


</body>

</html>
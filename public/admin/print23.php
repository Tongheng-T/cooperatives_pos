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
    <link href="../dist/css/print.css" rel="stylesheet" media="print">

    <title>តារាងពន្ទុប្រចាំខែ: <?php date_rank(); ?></title>
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
                        $date_2 = $_SESSION['date_2']; ?>
                        <!-- <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                        <h4 class="margino">ជាតិ សាសនា ព្រះមហាក្សត្រ</h4> -->
                        <b>ចាប់ពីថ្ងៃទី: <?php echo date('d-m-Y', strtotime($date_1)) ?><br> ដល់ថ្ងៃទី: <?php echo date('d-m-Y', strtotime($date_2)) ?></b>
                    </div>
                </div>
            </section>
            <div class="dddc">
                <h5>របាយការណ៍ការលក់ប្រចាំខែ <?php date_rank(); ?></h5>
            </div>

            <section class="product-area mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>ឈ្មោះ​អតិថិជន</th>
                            <th>ឈ្មោះ​ទំនិញ</th>
                            <th>សរុប</th>
                            <th>Discount</th>
                            <th>សរុប</th>
                
                            
                        </tr>
                    </thead>
                    <tbody id="orderlisttable">
                        <?php
                        $select = query("SELECT * from tbl_invoice where order_date between '$date_1' AND '$date_2'");
                        confirm($select);
                        $oupu = "";
                        $no = 1;
                        while ($row = $select->fetch_object()) {
                            $id_invoice = $row->invoice_id;
                            $row_invoice_detaice = query("SELECT * from tbl_invoice_details where invoice_id ='$id_invoice'");
                            confirm($row_invoice_detaice);



                            while ($row_detaice = $row_invoice_detaice->fetch_object()) {
                                $product_name = $row_detaice->product_name;
                                $oupu .= '
                                <tr>
                                <td>' . $no . '</td>
                                <th>' . $row->customer_name . '</th>';
                                $oupu .= ' 
                                <td>' . $product_name . '</td>
                                <td>' . $row_detaice->qty . '</td>
                                <td>' . $row_detaice->price . '</td>
                                <td>' . $row_detaice->price*$row_detaice->qty . '</td></tr>
                                
                                ';
                               
                                
                            }
                            $oupu .= '
         
                            <td colspan="4"></td>
                            <td>Discount</td>
                            <td>' . $row->discount . '</td>
      
                            <tr>
                            <td colspan="1"></td>
                            ';
                            if ($row->payment_type == "Cash") {

                                $oupu .=  '<td><span class="label label-primary">' . $row->payment_type . '</span></td>';
                            } elseif ($row->payment_type == "Card") {
                                $oupu .=  '<td><span class="label label-warning">' . $row->payment_type . '</span></td>';
                            } else {
                                $oupu .=  '<td><span class="label label-info">' . $row->payment_type . '</span></td>';
                            }
                            $oupu .= '
                            <td>ថ្ងៃខែ</td>
                            <td>' . date('d-m-Y', strtotime($row->order_date)) . '</td>
                            <th>សរុប</th>
                            <th><span class="label label-danger">' . number_format($row->total) . ' <b style="font-size: 16px;">&#x17DB </b></span></th>
      
                            </tr>
                        ';

                            
                            $no++;
                        }
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
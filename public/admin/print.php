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
                            <th>សរុប</th>
                            <th>Discount</th>
                            <th>សរុប</th>
                            <th>ថ្ងៃខែ</th>
                            <th>ប្រភេទការទូទាត់</th>
                        </tr>
                    </thead>
                    <tbody id="orderlisttable">
                        <?php
                        $select = query("SELECT * from tbl_invoice where order_date between '$date_1' AND '$date_2'");
                        confirm($select);
                        $no = 1;
                        while ($row = $select->fetch_object()) {

                            echo '
                                <tr>
                                <td>' . $no . '</td>
                                <td>' . $row->customer_name . '</td>
                                <td>' . $row->subtotal . '</td>
                                <td>' . $row->discount . '</td>
                                <th><span class="label label-danger">' . number_format($row->total) . ' <b style="font-size: 16px;">&#x17DB</b></span></th>
              
                                <td>' . date('d-m-Y', strtotime($row->order_date)) . '</td>
                               

                                ';
                            if ($row->payment_type == "Cash") {

                                echo '<td><span class="label label-primary">' . $row->payment_type . '</span></td>';
                            } elseif ($row->payment_type == "Card") {
                                echo '<td><span class="label label-warning">' . $row->payment_type . '</span></td>';
                            } else {
                                echo '<td><span class="label label-info">' . $row->payment_type . '</span></td>';
                            }
                            $no++;
                            $totallo += $row->total;
                        }

                        echo '
                        <tr>
                        <td colspan="3"></td>
                        <th>សរុប</th>
                        <th>' . $totallo. ' <b style="font-size: 16px;">&#x17DB</b></th>
                        </tr>';

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
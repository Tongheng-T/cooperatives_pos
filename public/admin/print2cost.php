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

    <title>បញ្ជីចំណាយប្រចាំខែ: <?php date_rank() . tt(); ?></title>
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
                        <?php $date_1 = $_SESSION['date_1'];
                        $date_2 = $_SESSION['date_2'];
                        function tt(){
                            $date_1 = $_SESSION['date_1'];
                            echo ' '. date('d-m-Y', strtotime($date_1));
                        }
                        ?>
                        <!-- <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                        <h4 class="margino">ជាតិ សាសនា ព្រះមហាក្សត្រ</h4> -->
                        <b>ចាប់ពីថ្ងៃទី: <?php echo date('d-m-Y', strtotime($date_1)) ?><br> ដល់ថ្ងៃទី: <?php echo date('d-m-Y', strtotime($date_2)) ?></b>
                        <!-- <h4>ព្រះរាជាណាចក្រកម្ពុជា</h4>
                        <h4 class="margino">ជាតិ សាសនា ព្រះមហាក្សត្រ</h4> -->
                    </div>
                </div>
            </section>
            <div class="dddc">
                <h5>បញ្ជីចំណាយប្រចាំខែ <?php date_rank(); ?></h5>
            </div>

            <section class="product-area mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ល.រ</th>
                            <th>Id Cost</th>
                            <th>Name Cost</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Category </th>

                        </tr>
                    </thead>
                    <tbody id="orderlisttable">
                        <?php
                        $select = query("SELECT * from tbl_cost where cost_date between '$date_1' AND '$date_2'");
                        confirm($select);
                        $no = 1;
                        $Sale_Price = 0;

                        while ($row = $select->fetch_object()) {

                            $Sale_Price += $row->qty_cost;


                            echo '
                                <tr>
                                <td>' . $no . '</td>
                                <td>' . $row->id_cost . '</td>
                                <td>' . $row->name_cost . '</td>
                                <td>' . $row->qty_cost . '</td>
                                <td>' . $row->cost_date . '</td>
                                <td>' . show_name_category_inview_cos($row->category_id) . '</td>

                                <tr>
                                ';

                            $no++;
                        }

                        echo '
                        <tr>
                        <td colspan="2"></td>
                        <th>សរុប</th>
                        <th>' . number_format($Sale_Price) . ' <b>&#x17DB</b></th>
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
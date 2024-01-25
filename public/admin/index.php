<?php require_once("../../resources/config.php"); ?>

<?php

if ($_SESSION['role'] == "Admin") {
    include_once(TEMPLATE_BACK . "/header.php");
} else {
    include_once(TEMPLATE_BACK . "/headeruser.php");
}
?>


<?php check_login();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
    header("Location: ../");
}
?>


<div class="content-wrapper">


    <?php

    if ($_SERVER['REQUEST_URI'] == "/admin/" || $_SERVER['REQUEST_URI'] == "/admin/itemt") {

        include(TEMPLATE_BACK . "/dashboard.php");
    }

    if (isset($_GET['dashboard'])) {

        include(TEMPLATE_BACK . "/dashboard.php");
    }
    if (isset($_GET['category'])) {

        include(TEMPLATE_BACK . "/category.php");
    }
    if (isset($_GET['addproduct'])) {

        include(TEMPLATE_BACK . "/addproduct.php");
    }
    if (isset($_GET['productlist'])) {

        include(TEMPLATE_BACK . "/productlist.php");
    }
    if (isset($_GET['createorder'])) {

        include(TEMPLATE_BACK . "/createorder.php");
    }
    if (isset($_GET['orderlist'])) {

        include(TEMPLATE_BACK . "/orderlist.php");
    }
    if (isset($_GET['page'])) {

        include(TEMPLATE_BACK . "/orderlist.php");
    }
    if (isset($_GET['tablerport'])) {

        include(TEMPLATE_BACK . "/tablerport.php");
    }
    if (isset($_GET['graphreport'])) {

        include(TEMPLATE_BACK . "/graphreport.php");
    }
    if (isset($_GET['registration'])) {

        include(TEMPLATE_BACK . "/registration.php");
    }
    if (isset($_GET['changepassword'])) {

        include(TEMPLATE_BACK . "/changepassword.php");
    }
    if (isset($_GET['viewproduct'])) {

        include(TEMPLATE_BACK . "/viewproduct.php");
    }
    if (isset($_GET['editorder'])) {

        include(TEMPLATE_BACK . "/editorder.php");
    }
    if (isset($_GET['editproduct'])) {

        include(TEMPLATE_BACK . "/editproduct.php");
    }
    if (isset($_GET['cost'])) {

        include(TEMPLATE_BACK . "/cost.php");
    }
    if (isset($_GET['edit_cost'])) {

        include(TEMPLATE_BACK . "/edit_cost.php");
    }
    if (isset($_GET['reportbycategory'])) {

        include(TEMPLATE_BACK . "/reportbycategory.php");
    }

    if (isset($_GET['exchange'])) {

        include(TEMPLATE_BACK . "/exchange.php");
    }
    if (isset($_GET['add_stock'])) {

        include(TEMPLATE_BACK . "/add_stock.php");
    }
    ?>



</div>


<!-- /#page-wrapper -->
<?php include(TEMPLATE_BACK . "/footer.php"); ?>
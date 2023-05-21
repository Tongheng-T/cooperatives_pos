<?php
$upload_directory = "uploads";

// helper function

function last_id()
{
    global $connection;
    return mysqli_insert_id($connection);
}

function set_message($msg)
{
    if (!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}
function actr($path)
{
    if (isset($_GET[$path])) {
        $active = "active";
        echo $active;
    }
}

function redirect($location)
{
    header("Location: $location");
}

function query($sql)
{
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result)
{
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function escape_string($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}


function fetch_array($result)
{

    return ($row = mysqli_fetch_array($result));
}

/*********************************FRONT END FUNCTIONS************************************/

function login_user()
{
    if (isset($_POST['btn_login'])) {

        $useremail = $_POST['txt_email'];
        $password = $_POST['txt_password'];

        $query = query("SELECT * from tbl_user where useremail='$useremail' AND password='$password' and role ='Admin'");
        confirm($query);

        if (mysqli_num_rows($query) == 0) {
            $query2 = query("SELECT * from tbl_user where useremail='$useremail' AND password='$password' and role ='User'");
            confirm($query2);
            if (mysqli_num_rows($query2) == 0) {
                set_message('<script type="text/javascript">
                jQuery(function validation(){
                swal({
                  title: "EMAIL OR PASSWORD IS ERONG!",
                  text: "Details Not Matched",
                  icon: "error",
                  button: "Ok",
                });
              });
              </script>');
                redirect("");
            } else {
                $row =  $query2->fetch_assoc();
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['useremail'] = $row['useremail'];
                $_SESSION['role'] = $row['role'];

                echo '<script type="text/javascript">
                jQuery(function validation(){
                swal({
                  title: "Good job! ' . $_SESSION['username'] . '",
                  text: "Details Matched",
                  icon: "success",
                  button: "Loading......",
                });
              });
              </script>';

                header('refresh:2;user');
            }
        } else {
            $row =  $query->fetch_assoc();
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['useremail'] = $row['useremail'];
            $_SESSION['role'] = $row['role'];

            set_message('<script type="text/javascript">
          jQuery(function validation(){
            swal({
              title: "Good job! ' . $_SESSION['username'] . '",
              text: "Details Matched",
              icon: "success",
              button: "Loading......",
            });
          });
          </script>');

            header('refresh:1;admin');
        }
    }
}
// ===========================check_login==============
function check_login()
{
    if (isset($_SESSION['userid'])) {

        $id = $_SESSION['userid'];
        $query = query("SELECT * from tbl_user where userid = '$id' limit 1");

        if ($query && mysqli_num_rows($query) > 0) {

            $user_data = mysqli_fetch_assoc($query);
            return $user_data;
        }
    }

    //redirect to login
    header("Location: ../");
    die;
}
function name_user()
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query =  query("SELECT * FROM users WHERE user_id =  $id ");
        confirm($query);
        while ($row = fetch_array($query)) {

            $name = <<<DELIMETER
        {$row['username']}

        DELIMETER;
        }
        echo $name;
    } else {
        echo "Hello";
    }
}






/*********************************BACK END FUNCTIONS************************************/




/************************************Admin products ******************* */

function display_image($picture)
{

    global $upload_directory;
    return $upload_directory . DS . $picture;
}


function display_users()
{

    $category_query = query("SELECT * FROM users");
    confirm($category_query);

    while ($row = fetch_array($category_query)) {

        $id = $row['id'];
        $username = $row['username'];
        $img = $row['img'];

        $password = $row['password'];

        $user = <<<DELIMETER

        <tr>
        <td>{$id}</td>
        <td>{$username} </td>
        <td><img width='60' src="../imguser/{$img}"></td>
        <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['id']}" ><span class="glyphicon glyphicon-trash"></span></a></td>
        <td><a class="btn btn-primary" href="itemth?edit_user&id={$row['id']}" ><span class="glyphicon glyphicon-edit"></span></a></td>
        
        </tr>

        <script>
        $('.btn-danger').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href')
            Swal.fire({
                text: "លុបអ្នកចូលប្រើប្រាស់!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        })

        </script>

        DELIMETER;
        echo $user;
    }
}

function update_user()
{

    if (isset($_POST['update_user'])) {

        $username = escape_string($_POST['username']);
        $phone = escape_string($_POST['phone']);
        $password = escape_string($_POST['password']);
        $user_photo = escape_string($_FILES['file']['name']);
        $image_temp_location = escape_string($_FILES['file']['tmp_name']);

        $password = md5($password);

        if (empty($user_photo)) {
            $ger_pic = query("SELECT img FROM users WHERE id =" . escape_string($_GET['id']) . "");
            confirm($ger_pic);
            while ($pic = fetch_array($ger_pic)) {

                $user_photo = $pic['img'];
            }
        }
        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY_UDER . DS . $user_photo);
        $query = "UPDATE users SET ";
        $query .= "username      = '{$username}'     , ";
        $query .= "phone         = '{$phone}'        , ";
        $query .= "password      = '{$password}'     , ";
        $query .= "img           = '{$user_photo}'    ";
        $query .= "WHERE id=" . escape_string($_GET['id']);

        $send_update_query = query($query);
        confirm($send_update_query);
        $alert = <<<DELIMETER

        <script>
 
        Swal.fire(
            'បានកែប្រែ!',
            'ទិន្នន័យបានកែប្រែ',
        )
        </script>
        DELIMETER;
        echo $alert;
        set_message($alert);
        redirect("itemth?users");
    }
}

function update_change()
{

    if (isset($_POST['change'])) {

        $riel = ($_POST['riel']);
        $query = query("UPDATE exchange SET riel ='$riel' WHERE id=2");
        confirm($query);
        $alert = <<<DELIMETER

        <script>

        Swal.fire(
            'បានកែប្រែ!',
            'បានកែប្រែអត្រាប្ដូរប្រាក់',
        )
        </script>
        DELIMETER;
        echo $alert;
        set_message($alert);
        redirect("itemt?exchange");
    }
}


function add_user()
{

    if (isset($_POST['add_user'])) {

        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);
        $password = md5($password);
        $user_id = random_num(20);


        //    move_uploaded_file($photo_temp,  UPLOAD_DIRECTORY . DS . $user_photo);

        $query = query("INSERT INTO users(user_id,username,password) VALUES('{$user_id}','{$username}','{$password}')");
        $last_id = last_id();
        confirm($query);
        $alert = <<<DELIMETER

       <script>

       Swal.fire(
           'បានបន្ថែម!',
           'អ្នកប្រើប្រាស់ថ្មីដែលមានលេខសម្គាល់ {$last_id} ត្រូវបានបន្ថែម',
           
       )
       </script>
       DELIMETER;
        echo $alert;
        set_message($alert);
        redirect("itemth?users");
    }
}
function exchange()
{
    $category_query = query("SELECT * FROM exchange");
    confirm($category_query);

    while ($row = fetch_array($category_query)) {

        $id = $row['id'];
        $riel = $row['riel'];
        echo $riel;
    }
}

function random_num($length)
{

    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        # code...

        $text .= rand(0, 9);
    }

    return $text;
}





// ///////////////////////////////////////////////////////////////////////////////////////////////////////


function fill_product()
{
    $output = '';
    $select = query("SELECT * from tbl_product order by pname asc");
    confirm($select);

    foreach ($select as $row) {
        $output .= '<option value="' . $row["pid"] . '">' . $row["pname"] . '</option>';
    }
    echo $output;
}

function fill_productt($pid)
{
    $output = '';
    $select = query("SELECT * from tbl_product order by pname asc");
    confirm($select);

    foreach ($select as $row) {
        $output .= '<option value="' . $row["pid"] . '"';
        if ($pid == $row['pid']) {
            $output .= 'selected';
        }
        $output .= '>' . $row["pname"] . '</option>';
    }
    return $output;
}

function convert_month_kh($value)
{
    $kh_month =
        '{
            "01": "មករា",
            "1": "មករា",
            "02": "កុម្ភៈ",
            "2": "កុម្ភៈ",
            "03": "មិនា",
            "3": "មិនា",
            "04": "មេសា",
            "4": "មេសា",
            "05": "ឧសភា",
            "5": "ឧសភា",
            "06": "មិថុនា",
            "6": "មិថុនា",
            "07": "កក្កដា",
            "7": "កក្កដា",
            "08": "សីហា",
            "8": "សីហា",
            "09": "កញ្ញា",
            "9": "កញ្ញា",
            "10": "តុលា",
            "11": "វិចិ្ឆកា",
            "12": "ធ្នូ"
        }';


    $month = json_decode($kh_month);
    return $month->$value;
}

function date_rank()
{


    if (isset($_POST['btnrank'])) {
        $date = $_POST['date'];
        $monthly = date('m', strtotime($date));
        echo convert_month_kh($monthly);
    } else {
        $date = $_SESSION['date'];
        $monthly = date('m', strtotime($date));
        echo convert_month_kh($monthly);
    }
}



function get_products()
{
    $select = query("SELECT * from tbl_invoice order by invoice_id desc");
    confirm($select);
    $query =  query("SELECT * FROM tbl_invoice");
    confirm($query);

    $rows = mysqli_num_rows($query);

    if (isset($_GET['page'])) {

        $page = preg_replace('#[^0-9]#', '', $_GET['page']);
    } else {

        $page = 1;
    }

    $perPage = 15;
    $lastPage = ceil($rows / $perPage);
    if ($page < 1) {
        $page = 1;
    } elseif ($page > $lastPage) {

        $page = $lastPage;
    }

    $middleNumbers = '';
    $sub1 = $page - 1;
    $sub2 = $page - 2;
    $add1 = $page + 1;
    $add2 = $page + 2;

    if ($page == 1) {

        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $add1 . ' ">' . $add1 . '</a></li>';
    } elseif ($page == $lastPage) {

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $sub1 . ' ">' . $sub1 . '</a></li>';

        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';
    } elseif ($page > 2 && $page < ($lastPage - 1)) {

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $sub2 . ' ">' . $sub2 . '</a></li>';

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $sub1 . ' ">' . $sub1 . '</a></li>';

        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $add1 . ' ">' . $add1 . '</a></li>';

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $add2 . ' ">' . $add2 . '</a></li>';
    } elseif ($page > 1 && $page < $lastPage) {

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $sub1 . ' ">' . $sub1 . '</a></li>';

        $middleNumbers .= '<li class="page-item active"><a>' . $page . '</a></li>';

        $middleNumbers .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $add1 . ' ">' . $add1 . '</a></li>';
    }

    $limit = 'LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;

    $query2 =  query("SELECT * FROM tbl_invoice order by invoice_id desc $limit ");
    confirm($query2);

    $outputPagination = "";

    if ($page != 1) {
        $prev = $page - 1;
        $outputPagination .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $prev . ' ">Back</a></li>';
    }

    $outputPagination .= $middleNumbers;

    if ($page != $lastPage) {
        $next = $page + 1;
        $outputPagination .= '<li class="page-item "><a class="page-link" href="orderlist?page=' . $next . ' ">Next</a></li>';
    }



    $product = "";
    $no = 1;
    while ($row = $query2->fetch_object()) {

        $product .= '
        <tr>
        <td>' . $no . '</td>
        <td>' . $row->invoice_id . '</td>
        <td>' . $row->customer_name . '</td>
        <td>' . $row->order_date . '</td>
        <td>' . $row->total . '</td>
        <td>' . $row->paid . '</td>
        <td>' . $row->due . '</td>
        <td>' . $row->payment_type . '</td>
       
        <td>
        <a href="invoice_80mm_1.php?id=' . $row->invoice_id . '" class="btn btn-warning" role="button" target=_blank><span class="glyphicon glyphicon-print" style="color:#ffffff" data-toggle="tooltip" title="Print Invoice"></span></a>
        </td>

        <td>
        <a href="itemt?editorder&id=' . $row->invoice_id . '" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>
        </td>

        <td>
        <button id=' . $row->invoice_id . ' class="btn btn-danger btndelete"> <span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
        </td>
  
        </tr>
        ';
        $no++ ;
    }

    $product .= '                         
     </tbody>
     </table>
     </div>
     </div>';

    echo $product;
    echo "<div class='text-center'><ul class='pagination'>{$outputPagination}</ul></div>";
}

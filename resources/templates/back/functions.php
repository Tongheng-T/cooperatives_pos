<?php 
$upload_directory = "uploads";

// helper function

function last_id(){
    global $connection;
    return mysqli_insert_id($connection);
}

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] =$msg;
    }else{
        $msg = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset( $_SESSION['message']);
    }
}

function redirect($location){
    header("Location: $location");
}

function query($sql){
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;
    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}   

function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}


function fetch_array($result){

    return ($row = mysqli_fetch_array($result));
}

/*********************************FRONT END FUNCTIONS************************************/

function login_user()
{
    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);
        // $password = md5($password);


        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'  ");
        confirm($query);

        if (mysqli_num_rows($query) == 0){

            set_message("<div class='alert alert-danger text-center'>
            Your Password or Username are wrong! </div>");
           redirect("");
        }else {
            $row =  $query->fetch_assoc();
            $user_data = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_data;
            redirect("admin");
        }
       }
}
// ===========================check_login==============
function check_login()
{
	if(isset($_SESSION['user_id']))
	{

		$id = $_SESSION['user_id'];
		$query = query("select * from users where user_id = '$id' limit 1");

		if($query && mysqli_num_rows($query) > 0)
		{

			$user_data = mysqli_fetch_assoc($query);
			return $user_data;
		}
	}

	//redirect to login
	header("Location: ../");
	die;

}
function name_user(){
    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];
        $query =  query("SELECT * FROM users WHERE user_id =  $id ");
        confirm($query);
        while ($row = fetch_array($query)) {
            
        $name = <<<DELIMETER
        {$row['username']}

        DELIMETER;
    } echo $name;
    
    
    }else{
        echo "Hello";
    }
}






/*********************************BACK END FUNCTIONS************************************/




/************************************Admin products ******************* */

function display_image($picture){

    global $upload_directory;
    return $upload_directory.DS.$picture;
}


function display_users() {

    $category_query = query("SELECT * FROM users");
    confirm($category_query);

    while($row = fetch_array($category_query)){

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

function update_user(){
    
    if(isset($_POST['update_user'])){

        $username = escape_string($_POST['username']);
        $phone = escape_string($_POST['phone']);
        $password = escape_string($_POST['password']);
        $user_photo = escape_string($_FILES['file']['name']);
        $image_temp_location = escape_string($_FILES['file']['tmp_name']);

        $password = md5($password);
 
        if(empty($user_photo)) {
            $ger_pic = query("SELECT img FROM users WHERE id =" .escape_string($_GET['id']). "");
            confirm($ger_pic);
            while($pic = fetch_array($ger_pic)){
                
             $user_photo = $pic['img'];
            }
        }
        move_uploaded_file($image_temp_location  , UPLOAD_DIRECTORY_UDER . DS . $user_photo);
        $query = "UPDATE users SET ";
        $query .="username      = '{$username}'     , ";
        $query .="phone         = '{$phone}'        , ";
        $query .="password      = '{$password}'     , ";
        $query .="img           = '{$user_photo}'    ";
        $query .="WHERE id=" . escape_string($_GET['id']);
     
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

function update_change(){
    
    if(isset($_POST['change'])){

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

function total_auto(){

}
function add_user() {
 
    if(isset($_POST['add_user'])){

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
function exchange(){
    $category_query = query("SELECT * FROM exchange");
    confirm($category_query);

    while($row = fetch_array($category_query)){

    $id = $row['id'];
    $riel = $row['riel'];
        echo $riel;

   }
}

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
}

?>
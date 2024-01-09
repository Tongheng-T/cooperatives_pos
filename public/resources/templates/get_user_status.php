
	<?php
	require_once("../../../resources/config.php");
	$time = new DateTime('now', new DateTimeZone('Asia/bangkok'));
	$datee =  $time->format('Y-m-d H:i:s');
	$time = time();
	$select = query("SELECT * from tbl_user ");
	confirm($select);

	$admin = 'Admin';
	$user = 'User';
	while ($row = $select->fetch_assoc()) {
		
		if ($row['role'] == $admin or $row['role'] == $user) {
			$password = "********";
		} else {
			$password = $row['password'];
		}
		if ($row['useremail'] == "bibben5016@gmail.com") {
			$delete = '';
		} else {
			$delete = '<a href="../resources/templates/back/delete.php?id=' . $row['userid'] . '" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>';
		}

		$date = date($row['last_login']);
		$timeago = timeago($date);
		$status = $timeago;
		$class = "text-danger";

		if ($row['login_online'] > $time) {
			$status = 'Online';
			$class = "text-success";
		}
		echo '
		 <tr>
            <td>' . $row['userid'] . '</td>
            <td> <img height="50" src="../resources/userpic/' . $row['img'] . '" alt=""> ' . $row['username'] . '<p class="' . $class . '"><i class="fas fa-signal"></i>  ' . $status . ' </p></td>
            <td>' . $row['useremail'] . '</td>
            <td>' . $password . '</td>  
            <td>' . $row['role'] . '</td>
            <td><button type="submit" class="btn btn-primary" value="' . $row['userid'] . '" name="btnedit">Edit</button></td>
            <td>' . $delete . '</td>
            </tr>';
	}
	?>

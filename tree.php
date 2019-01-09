<?php


function connect(){
	$conn = new mysqli('localhost','root','','tree_function');
	if (!$conn) {
		die('Database Connection Failed');
	}
	return $conn;
}


function person_info($id){
	$conn = connect();
	$person_query = "SELECT * FROM `table1` WHERE `id`= $id";	
	$person = mysqli_query($conn,$person_query);
	$person = mysqli_fetch_array($person);
	return $person;
}

function spous($id,$type){
	$conn = connect();
	$spous_query = "SELECT * FROM `table1` WHERE `s_id` = $id";
	$spous = mysqli_query($conn,$spous_query);
	// $r = mysqli_fetch_array($spous);
	// print_r($r);
	// print_r("<br>".$r['name']);
	if ($type == "table") {
		$s='';
	while($r = mysqli_fetch_array($spous)) {
		$s .= '<tr>';
		$s .= '<td>'.$r['id'].'</td>';
		$s .= '<td>'.$r['name'].'</td>';
		$s .= '<td>'.($r['gender'] == "m" ? "Husband" : "Wife").'</td>';
		$s .= '<td>'.$r['p_id'].'</td>';
		$s .= '<td>'.$r['s_id'].'</td>';
		$s .= '<td>'.$r['gender'].'</td>';
		$s .= '</tr>';
	}
	return $s;
	}else{
		$r = mysqli_fetch_array($spous);
		return $r;
	}
}

function sibling($id){
	$conn = connect();
	$p_id_query = "SELECT `p_id` FROM `table1` WHERE `id`= $id";
	$p_id = mysqli_query($conn,$p_id_query);
	$p_id = mysqli_fetch_array($p_id);
	$p_id = $p_id['p_id'];
	$sibling_query = "SELECT * FROM `table1` WHERE `p_id`= '$p_id' && `id` != $id";
	$sibling = mysqli_query($conn,$sibling_query);
	if (mysqli_num_rows($sibling) > 0) {
		// print_r($sibling);
		$s='';
		while($r = mysqli_fetch_array($sibling)) {
			$s .= '<tr>';
			$s .= '<td>'.$r['id'].'</td>';
			$s .= '<td>'.$r['name'].'</td>';
			$s .= '<td>Brother</td>';
			$s .= '<td>'.$r['p_id'].'</td>';
			$s .= '<td>'.$r['s_id'].'</td>';
			$s .= '<td>'.$r['gender'].'</td>';
			$s .= '</tr>';
		}
	}else{
		$s = '';
	}	
	return $s;

}


// Children
function children($id,$firstChild,$x){
	// echo "<br>".$x;
	$conn = connect();
	$user_sql = "SELECT * FROM `table1` WHERE `id`= $id";
	$user = mysqli_query($conn,$user_sql);
	$u = mysqli_fetch_assoc($user);
	if ($u['gender'] == "m") {
		
		$s_id = $u['s_id'];
		$child_query = "SELECT * FROM `table1` WHERE `p_id`= '$s_id'";
	}else{
		$child_query = "SELECT * FROM `table1` WHERE `p_id`= $id";
	}
	// echo "<br>".$x;
	$child = mysqli_query($conn,$child_query);
	// print_r($r = mysqli_fetch_array($child));
	$c='';
	$gc='';
	while($r = mysqli_fetch_array($child)) {
		if ($firstChild != $u['p_id'] or $firstChild != spous($id,"data")['p_id']) {
			$x = $x;
		}else{
			$x = 0;
		}
		$c .= '<tr>';
		$c .= '<td>'.$x.'</td>';
		$c .= '<td>'.$r['name'].'</td>';
		$c .= '<td>'.gen_base_rel($x,$r['gender']).'</td>';
		$c .= '<td>'.$r['p_id'].'</td>';
		$c .= '<td>'.$r['s_id'].'</td>';
		$c .= '<td>'.$r['gender'].'</td>';
		$c .= '</tr>';
		$id = $r['id'];
		// $c .= spous($id,"table");
		$new_id = $r['id'];
		$x++;
		$gc .=children($new_id,$firstChild,$x);
	}
	
	return $c.$gc;
	
}

function gen_base_rel($x,$gender)
{
	$rel = '';
	if ($x == 0) {
		if ($gender == "m") {
			$rel = "Son";
			
		}else{
			$rel = "Doughter";
			
		}
	}
	if ($x == 1) {
		if ($gender == "m") {
			$rel = "Grand Son";
		}else{
			$rel = "Grand Doughter";
		}	
	}
	if ($x > 1) {
		if ($gender == "m") {
			$rel = "Great Grand Son";
		}else{
			$rel = "Great Grand Doughter";
		}
	}
	return $rel;
}
<?php 
include_once('db_connection.php');

class DbOperation{
	private $con;
	function __construct(){
	    $obj = new Dbconnect();
		$this->con = $obj->returnobject();
	}
		function sign_in_user($email,$password){
				 		$products = array(); 

					$sql ="select * from users where user_email = '$email' and user_pwd = '$password'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['user_id'] =$row['user_id'];
					        $temp['user_name'] =$row['user_name'];
					        $temp['user_image'] =$row['user_image'];
					        $temp['user_email'] =$row['user_email'];
					    array_push($products, $temp);

					}
					echo json_encode($products);
					

					}
					else {
						echo '00';
					}
					
					
			
		}
		function branch_details(){
			$products = array(); 

					$sql ="select * from brnches";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['branch_id'] =$row['branch_id'];
					        $temp['branch_image'] ="http://192.168.43.126/ExamscorerApp/".$row['branch_image'];
					        $temp['branch_heading'] =$row['branch_heading'];
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
	}
	function sem_details(){
		$products = array(); 

					$sql ="select * from semester limit 4";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['sem_id'] =$row['sem_id'];
					          $temp['sem_title'] =$row['sem_title'];
					        $temp['sem_image'] ="http://192.168.43.126/ExamscorerApp/".$row['sem_images'];
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
	

	}
	function sub_details($branch_id,$sem_id){
		$products = array(); 
		if ($sem_id ==1 || $sem_id == 2) {
			$sql ="SELECT * FROM first_second_sem WHERE  sem_id =$sem_id";

			
		}
		if ($sem_id >2) 
		 	
		  {
			$sql ="SELECT * FROM subjects WHERE brnch_id =$branch_id AND sem_id =$sem_id";
			
		}

					
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['sub_heading'] =$row['sub_heading'];
					          $temp['sub_name'] =$row['sub_name'];
					          $temp['sub_code'] =$row['sub_code'];

					        
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
				

	}
	function papers_details($sub_code){
			$products = array(); 

					$sql ="select * from papers where sub_code ='$sub_code'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

	}
	function set_fav($user_id,$paper_id){
		$sql1 ="select * from favourites where user_id = $user_id && paper_id = $paper_id";
		$result1 = mysqli_query($this->con,$sql1);
		$num_rows = mysqli_num_rows($result1);
		if ($num_rows ==1) {
			return 1;
		}
		else {
			$sql ="INSERT INTO favourites(user_id,paper_id) VALUES ($user_id,$paper_id)";
			$result = mysqli_query($this->con,$sql);
			if ($result) {
				return 0;
			// Product is not in whishlist
			
		}

	}

}
function remove_fav($user_id,$paper_id){
	$sql ="DELETE FROM favourites WHERE paper_id =$paper_id && user_id =$user_id";
	$result1 = mysqli_query($this->con,$sql);
		if ($result1) {
			return 0;
		}

}
function run_time_fav($user_id,$paper_id){
		$sql1 ="select * from favourites where user_id = $user_id && paper_id = $paper_id";
		$result1 = mysqli_query($this->con,$sql1);
		$num_rows = mysqli_num_rows($result1);
		if ($num_rows ==1) {
			return 1;
		}


}
function fetch_fav($user_id){
	$products = array(); 

					$sql ="SELECT * FROM papers INNER JOIN favourites ON favourites.user_id = $user_id AND favourites.paper_id =papers.paper_id";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}
function fav_count($user_id){
	$sql ="SELECT COUNT(paper_id) AS total FROM favourites WHERE user_id=$user_id";
	$result = mysqli_query($this->con,$sql);
	$row = mysqli_fetch_assoc($result);
     $count = $row['total'];
      echo $count;

}
function search_res($keyoword,$selected_option){
	$products = array(); 
	if ($selected_option =="Subject") {
			$sql ="SELECT * FROM papers WHERE paper_title LIKE '%$keyoword%'
";
			$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
		
	}
	if ($selected_option == "Subject code") {
				$sql ="SELECT * FROM papers WHERE sub_code = '$keyoword'";
				$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
		
	}
				
					
			
}
function update_profile($user_id,$user_name,$profile_pic){
	$string = str_replace(' ', '', $user_name);
	$s =$string.$user_id.".jpg";
	$sql ="UPDATE users SET user_name ='$user_name',user_image ='$s' WHERE user_id =$user_id";
	$upload_path="Uploads/".$s;
	if (mysqli_query($this->con,$sql)) {
		file_put_contents($upload_path, base64_decode($profile_pic));
		echo 1;
		
	}
	else {
		echo 0;
	}

}
function fetch_profile($user_id){
	$products =array();
	$sql ="SELECT * FROM users WHERE user_id =$user_id";
	$result = mysqli_query($this->con,$sql);
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0) {
		while ($row =$result->fetch_assoc()) {
	 					$temp = array();
	 					$temp['user_email'] =$row['user_email'];
	 					$temp['user_name'] =$row['user_name'];
	 					$temp['user_profile_pic'] ="http://192.168.43.126/ExamscorerApp/API/Uploads/".$row['user_image'];
	 					array_push($products, $temp);

	 		    
	 		}
	 					echo json_encode($products);

}

}
function update_name($user_id,$user_name){
	$sql ="UPDATE users SET user_name ='$user_name' WHERE user_id =$user_id";
	
	if (mysqli_query($this->con,$sql)) {
	
		echo 1;
		
	}
	else {
		echo 0;
	}



}
function forgot_pwd($email,$user_pwd){
	$sql ="select * from users where user_email = '$email'";

		$result = mysqli_query($this->con,$sql);
		if ($result) {
		 	$num =mysqli_num_rows($result);
		 	if ($num ==1) {

		 				$sql ="UPDATE users SET user_pwd ='$user_pwd', user_conf_pwd ='$user_pwd' WHERE user_email = '$email'";
				if (mysqli_query($this->con,$sql)) {
					echo 1;
					
				}
				else {
					echo 'string';
				}
}
if ($num ==0) {
	echo 0;

}
}
}

function reappear_papers(){
	$products = array(); 

					$sql ="select * from supply_papers";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['reappear_title'] =$row['sp_title'];
					          $temp['reappear_link'] =$row['sp_link'];
					          $temp['reappear_code'] =$row['sp_code'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}
function notes_cat(){
		$products = array(); 

	$sql ="select * from notes_cat";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['notes_cat_id'] =$row['notes_cat_id'];
					          $temp['notes_cat_image'] ="http://192.168.43.126/ExamscorerApp/Notes_Cat_Image/".$row['notes_cat_image'];
					          $temp['notes_cat_title'] =$row['notes_cat_title'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}
function notes_subcat($notes_id){
			$products = array(); 

	$sql ="select * from notes_sub_cat where notes_catid = '$notes_id'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['notes_sub_id'] =$row['notes_sub_id'];
					       $temp['notes_catid'] =$row['notes_catid'];
					          $temp['notes_subcat_image'] ="http://192.168.43.126/ExamscorerApp/Notes_Subcat_Image/".$row['notes_subcat_image'];
					          $temp['notes_subcat_title'] =$row['notes_sub_cat_title'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}

function ppt_and_pdf($cat_id,$subcat_id){

			$products = array(); 

	$sql ="select * from notes where notes_cat_id = '$cat_id'  && notes_subcat_id = '$subcat_id'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['notes_sub_id'] =$row['notes_sub_id'];
					       $temp['notes_catid'] =$row['notes_catid'];
					          $temp['notes_subcat_image'] ="http://192.168.43.126/ExamscorerApp/Notes_Subcat_Image/".$row['notes_subcat_image'];
					          $temp['notes_subcat_title'] =$row['notes_sub_cat_title'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}
}

?>
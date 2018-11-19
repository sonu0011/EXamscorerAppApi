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
					       $temp['branch_title'] =$row['branch_title'];
					        $temp['branch_image'] ="http://192.168.43.126/ExamscorerApp/".$row['branch_image'];
					        $temp['branch_heading'] =$row['branch_heading'];
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
	}
	function sem_details(){
		$products = array(); 

					$sql ="select * from semester";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array(); 
					    if (!empty($row['sem_images'])) {

					       $temp['sem_id'] =$row['sem_id'];
					          $temp['sem_title'] =$row['sem_title'];
					        $temp['sem_image'] ="http://192.168.43.126/ExamscorerApp/".$row['sem_images'];
					  array_push($products, $temp);
					    	
					    }
					    

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
			$sql ="SELECT * FROM subjects WHERE sem_id =$sem_id  AND brnch_id =$branch_id  ";
			
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
	function papers_details($sub_code,$branch_title){
			$products = array(); 

					$sql ="select * from papers where sub_code ='$sub_code'  && branch_name = '$branch_title' order by year";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					          $temp['year'] =$row['year'];
					        
					  
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
					          $temp['branch_name'] =$row['branch_name'];
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
		$query ="SELECT * FROM papers WHERE paper_title LIKE '%$keyoword%'  ORDER BY branch_name";


			//$sql ="SELECT * FROM papers WHERE paper_title LIKE '%$keyoword%'";
			$result = mysqli_query($this->con,$query);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					          $temp['branch_name'] =$row['branch_name'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
				else {
					return 0;
				}
		
	}
	if ($selected_option == "Subject code") {
				$sql ="SELECT * FROM papers WHERE sub_code = '$keyoword' ORDER BY branch_name";
				$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					    $temp['paper_title'] =$row['paper_title'];
					     $temp['paper_link'] =$row['paper_link'];
					      $temp['paper_id'] =$row['paper_id'];
					          $temp['branch_name'] =$row['branch_name'];


					          					         

					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
				else {
					return 0;
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

		 				$sql ="UPDATE users SET user_pwd ='$user_pwd' WHERE user_email = '$email'";
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



	$sql =" select nc.notes_cat_id,nc.notes_cat_image,nc.notes_cat_title,nc.notes_cat_image,COUNT(nc.notes_cat_id) as notes_count from notes_cat as nc inner join notes as n on nc.notes_cat_id = n.notes_cat_id 
		GROUP BY nc.notes_cat_id,nc.notes_cat_image,nc.notes_cat_title,nc.notes_cat_image";


// select nc.notes_cat_id,nc.notes_cat_image,nc.notes_cat_title,nc.notes_cat_image,COUNT(n.notes_cat_id) from notes_cat as nc LEFT JOIN notes as n on nc.notes_cat_id = n.notes_cat_id GROUP BY nc.notes_cat_id,nc.notes_cat_image,nc.notes_cat_title,nc.notes_cat_image

		// $sql ="select * from notes_cat";
						$result = mysqli_query($this->con,$sql);
						if ($result) {
						while ($row =mysqli_fetch_assoc($result)) {
						    $temp = array();
						       $temp['notes_cat_id'] =$row['notes_cat_id'];
						          $temp['notes_cat_image'] ="http://192.168.43.126/ExamscorerApp/Notes_Cat_Image/".$row['notes_cat_image'];
						          $temp['notes_cat_title'] =$row['notes_cat_title'];
						          $temp['notes_count'] =$row['notes_count'];
						        
						  
						    array_push($products, $temp);

						}
						// $products['imagescount'] =$numrows;
						echo json_encode($products);
			
					}

}
function notes_subcat($notes_id){
			$products = array(); 

	$sql ="select ns.notes_sub_id,ns.notes_catid,ns.notes_subcat_image,ns.notes_sub_cat_title, COUNT(ns.notes_sub_id) as count_subcat from notes_sub_cat as ns inner join notes as nt on ns.notes_sub_id = nt.notes_subcat_id WHERE ns.notes_catid = '$notes_id' GROUP BY ns.notes_sub_id,ns.notes_catid,ns.notes_subcat_image,ns.notes_sub_cat_title
";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['notes_sub_id'] =$row['notes_sub_id'];
					       $temp['notes_catid'] =$row['notes_catid'];
					          $temp['notes_subcat_image'] ="http://192.168.43.126/ExamscorerApp/Notes_Subcat_Image/".$row['notes_subcat_image'];
					          $temp['notes_subcat_title'] =$row['notes_sub_cat_title'];
					          $temp['count_subcat'] =$row['count_subcat'];
					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}

function ppt_and_pdf($cat_id){

			$products = array(); 

	$sql ="select * from notes where notes_cat_id = '$cat_id'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       
					          $temp['notes_download_link'] ="http://192.168.43.126/ExamscorerApp/PDF_PPT/".$row['notes_download_link'];
					        $temp['notes_download_title'] =$row['notes_download_title'];
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}

function images_details($cat_id,$subcat_id){

			$products = array(); 
			$a ="http://192.168.43.126/ExamscorerApp/Notes_Images/";
			if ($subcat_id ==2) {

				$a =$a."computer_graphics/";
			}
			if ($subcat_id == 1) {

								$a =$a."dbms/";

			}

	$sql ="select * from notes where notes_cat_id = '$cat_id' && notes_subcat_id = '$subcat_id'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       
					          $temp['notes_download_link'] =$a.$row['notes_download_link'];	
					          $temp['notes_download_title'] =$row['notes_download_link'];				  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}

}
function feedback_message($email,$message){
	$sql ="INSERT INTO feeddback_form(feedback_email,feedback_message) VALUES ('$email','$message')";
	 $result = mysqli_query($this->con,$sql);
					if ($result) {
						echo '1';
					}
					else {
						echo 'error';
					}
				


}

// function cse3rdsem(){
// 	$newarray =array();
// 	$sql1 ="SELECT * FROM subjects WHERE brnch_id = 1 AND sem_id =3";
// 			$result = mysqli_query($this->con,$sql1);
// 					if ($result) {
// 					while ($row =mysqli_fetch_assoc($result)) {
// 					    $temp = array();

// 						       	  $temp['sub_heading'] =$row['sub_heading'];
// 						          $temp['sub_name'] =$row['sub_name'];
// 						          $temp['sub_code'] =$row['sub_code'];
// 					      array_push($newarray,$temp);
// 					  }
// 										         echo json_encode($newarray);
// 										         //.json_last_error_msg();


				
// 				}
					 
			

// }
function intro_details(){
	$products =array();
	$sql ="select * from  intro_details";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					  
					          $temp['intro_image'] ="http://192.168.43.126/ExamscorerApp/images/".$row['intro_image'];
					        $temp['intro_heading'] =$row['intro_heading'];

							$temp['intro_desc'] =$row['intro_desc'];					        
					  
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}


}
function papers_details_year($subcode ,$year,$branch_name){
		$products = array(); 

					$sql ="select * from papers where sub_code ='$subcode' && year = '$year' && branch_name = '$branch_name'";
					$result = mysqli_query($this->con,$sql);
					if ($result) {
					while ($row =mysqli_fetch_assoc($result)) {
					    $temp = array();
					       $temp['paper_title'] =$row['paper_title'];
					          $temp['paper_link'] =$row['paper_link'];
					          $temp['paper_id'] =$row['paper_id'];
					          $temp['subcode'] =$row['sub_code'];
					    array_push($products, $temp);

					}
					echo json_encode($products);
		
				}
}
function AllUrls(){
		$products = array();


					$sql ="select * from AllUrls";
					$result = mysqli_query($this->con,$sql);
					if ($result) {

					$row =mysqli_fetch_assoc($result) ;
		
					 array_push($products, $row);


				
					echo json_encode($products);
		
				}
			}


}

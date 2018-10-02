<?php 
include_once 'db_operations.php';
$con =new DbOperation();
if ($_SERVER['REQUEST_METHOD'] =='POST') {
	//Login User

		if (isset($_POST['login_user'])) {
			$res = $con->sign_in_user($_POST['user_email'],$_POST['user_pwd']);
			echo $res;
			}
		//Branch Details
		if (isset($_POST['Branch_Details'])) {

			$res = $con->branch_details();
			echo $res;
		}
		//Semester Details
		if (isset($_POST['Sem_details'])) {

			$res = $con->sem_details();
			echo $res;
		}
		//subjects details
		if (isset($_POST['Subject_details'])) {

			$res = $con->sub_details($_POST['branch_id'],$_POST['sem_id']);
			echo $res;
		}
		//papers details
		if (isset($_POST['papers_details'])) {
			$res = $con->papers_details($_POST['sub_code']);
			echo $res;
			
		}
		//set favourites
		if (isset($_POST['set_fav'])) {
			$res = $con->set_fav($_POST['user_id'],$_POST['paper_id']);
			echo $res;
		}
		//remove fav
		if (isset($_POST['removed_fav'])) {
			$res = $con->remove_fav($_POST['user_id'],$_POST['paper_id']);
			echo $res;
			
		}
		//set fav run time
		if (isset($_POST['run_time_fav'])) {
			$res = $con->run_time_fav($_POST['user_id'],$_POST['paper_id']);
			echo $res;

			
		}
		//fav details 
		if (isset($_POST['fav_details'])) {

			$res = $con->fetch_fav($_POST['user_id']);
			echo $res;
		}
		//favourite count
		if (isset($_POST['fav_count'])) {

			$res = $con->fav_count($_POST['user_id']);
			echo $res;
		}
		//searched results
		if (isset($_POST['seachedresult'])) {
			$res = $con->search_res($_POST['keyword'],$_POST['selectedoption']);
			echo $res;
			
		}
		//update profile
		if (isset($_POST['UpdateProfile'])) {

			$res = $con->update_profile($_POST['user_id'],$_POST['user_name'],$_POST['profile_pic']);
			echo $res;
		}
		//fetch profile details
		if (isset($_POST['fetchprofiledetails'])) {
			$res = $con->fetch_profile($_POST['user_id']);
			echo $res;
			
		}
		//updata name
		if (isset($_POST['UpdateName'])) {
			$res = $con->update_name($_POST['user_id'],$_POST['user_name']);
			echo $res;
			
		}
		//forgot password
		if (isset($_POST['forgot_password'])) {
			$res = $con->forgot_pwd($_POST['user_email'],$_POST['user_pwd']);
			echo $res;

			
		}//Reappear Papers
		if (isset($_POST['reappears_details'])) {
			$res = $con->reappear_papers();
			echo $res;

			
		}
		//notes category
		if (isset($_POST['notes_cat_details'])) {
			$res = $con->notes_cat();
			echo $res;
			
		}
		//notes subcategory deatails
		if (isset($_POST['notes_subcat_details'])) {

			$res = $con->notes_subcat($_POST['notes_id']);
			echo $res;
		}
		//ppt and pdf details
		if (isset($_POST['pdf_pdf_details'])) {

			$res = $con->ppt_and_pdf($_POST['cat_id']);
			echo $res;
		}
		//images details
		if (isset($_POST['images_details'])) {
			$res = $con->images_details($_POST['cat_id'],$_POST['subcat_id']);
			echo $res;
			
		}
		//feedback message
		if (isset($_POST['feedback_details'])) {
			$res = $con->feedback_message($_POST['email_address'],$_POST['message']);
			echo $res;
			
		}
	
}

?>
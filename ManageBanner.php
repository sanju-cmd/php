<?php 

	require '../init.php';
	$flag=$_REQUEST['flag'];

	switch ($flag) 
	{
        case 'Add':
			$name = $_POST['title'];
			$description=$_POST['description'];
		
			$image=date('YHis').rand(1000,9999).'.'.pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			
			if(empty($image) || empty($name)){
				echo json_encode(array('res' =>'error' ,'msg'=>'Data require'));
			}else{
				$sel=$source->Query("INSERT INTO `tbl_banner` (`title`,`description`,`image`,`date`,`time`) VALUES ('$name','$description','$image','$date','$time')");	
				if($sel){
					 move_uploaded_file($_FILES['image']['tmp_name'],"../upload/banner/".$image);
					 echo json_encode(array('res' =>'success' ,'msg'=>'Added Success','url'=>'AddBanner'));
				}else{
					echo json_encode(array('res' =>'error' ,'msg'=>'Something went wrong'));
				}
			}


		break;		

		case 'Update':
		
			$id = $_POST['id'];
			$name = $_POST['title'];
			$description=$_POST['description'];
			if(empty($id)){
				echo json_encode(array('res' =>'error' ,'msg'=>'Data require'));
			}else{
				$res=$source->Query("UPDATE `tbl_banner` SET `title`=?,`description`=?, `date`=?, `time`=? WHERE `id`=?",[$name,$description,$date,$time,$id]);
				
				if($res){
						if(!empty($_FILES['image']['name'])){
                        $image=date('YHis').rand(1000,9999).'.'.pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES['image']['tmp_name'],"/upload/banner/".$image);
                        $source->Query("UPDATE `banner` SET `image`='$image' WHERE `id`='$id'");
						}
						
					echo json_encode(array('res' =>'success' ,'msg'=>'Updated Success','url'=>'ManageBanner'));
				}else{
					echo json_encode(array('res' =>'error' ,'msg'=>'Something went wrong!'));
				}
				
			}


		break;			
		
		default:
			# code...
			break;
    }
    ?>	
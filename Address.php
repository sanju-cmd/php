<?php
	    require "connect.php";
	
		if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
	   // $flag="Get";
		switch($flag){
			case 'Add':
			 $user_id=$_POST['user_id'];
			 $pincode=$_POST['pincode'];
			 $address=$_POST['address'];
			 $city=$_POST['city'];
			 $state=$_POST['state'];
			 $mobile=$_POST['mobile'];
			 $name=$_POST['name'];
			 $email=$_POST['email'];
			 $address_type=$_POST['address_type'];
			//$id='3';
			$result=[];
			if(empty($pincode)||empty($address)||empty($city)||empty($state)||empty($mobile)){
				$output['res']='error';
				$output['msg']='Field Required';
			}else{
				
					$check=mysqli_query($conn,"select * from address where user_id='$user_id' and type='$address_type'");
					if(mysqli_num_rows($check)>0){
						$output['res']='error';
						$output['msg']=$address_type.' Address Already Exist !';
					}else{
						$query="insert into address (user_id,name,mobile,email,type,address,city,state,pincode,date,time) values ('$user_id','$name','$mobile','$email','$address_type','$address','$city','$state','$pincode','$date','$time')";
					
						if(mysqli_query($conn,$query)){
							$output['res']='success';
							$output['msg']='Address Added';
						}else{
							$output['res']='error';
							$output['msg']='Address Not Added';
						}
					}
				
			}
				echo json_encode($output);
				break;
				case 'Update':
			 $address_id=$_POST['address_id'];
			 $pincode=$_POST['pincode'];
			 $address=$_POST['address'];
			 $city=$_POST['city'];
			 $state=$_POST['state'];
			 $mobile=$_POST['mobile'];
			 $name=$_POST['name'];
			 $email=$_POST['email'];
			 $address_type=$_POST['address_type'];
			//$id='3';
			$result=[];
		
				
				  $res=mysqli_query($conn,"select * from address where id='$address_id'");
				
				if(mysqli_num_rows($res)>0){
					
					$query="update address set pincode='$pincode',city='$city',state='$state',address='$address',name='$name',email='$email',mobile='$mobile',type='$address_type' where id='$address_id'";
					if(mysqli_query($conn,$query)){
						$output['res']='success';
						$output['msg']='Address Updated';
						$output['data']=[];
						echo json_encode($output);
					}else{
						$output['res']='error';
						$output['msg']='Address Not Updated';
						$output['data']=[];
						echo json_encode($output);
					}
				}else{
					    $output['res']='error';
						$output['msg']='Address Not Exits';
						$output['data']=[];
				}
			
				
				break;
			case 'Get':
			$id=$_POST['user_id'];
			$result=[];
			$sel="select * from address where user_id='$id'";
			$res=mysqli_query($conn,$sel);
			if(mysqli_num_rows($res)>0)
			{          
			    while($row=mysqli_fetch_assoc($res))
				{
					
					array_push($result,$row);
				}
				$output['res']='success';
				$output['msg']='data found';
				$output['data']=$result;
			}
			else
			{
				$output['res']='error';
				$output['msg']='data not found';
				$output['data']=[];
			}
			echo json_encode($output);
			break;
			case 'Delete':
			$user_id=$_POST['address_id'];
			$result=[];
			$sel="delete from address where id='$user_id'";
			$res=mysqli_query($conn,$sel);
			if($res)
			{
				
				$output['res']='success';
				$output['msg']='data Deleted';
				$output['data']=[];
			}
			else
			{
				$output['res']='error';
				$output['msg']='data not found';
				$output['data']=[];
			}
			echo json_encode($output);
			break;
			
		}
    }else{
		$output['res']='error';
		$output['msg']='Flag Required';
		echo json_encode($output);
	}
	
?>
	
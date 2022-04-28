<?php
	require 'connect.php';
	
	if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
		// $flag="UpdateLocation";
		switch($flag){
			case 'Register':
            $name=$_POST['name'];
            $email=$_POST['email'];
            $mobile=$_POST['mobile'];
            $password=$_POST['password'];
            $token=$_POST['token'];
			$fb_id="ZPSDB";
			$otp="123456";//rand(000000,999999);
			
			if(empty($name) or empty($password)or empty($email)or empty($mobile)){
                $output['res']='error';
				$output['msg']='Field Required';
            }
            else{
				$query="SELECT * FROM `tbl_deliveryboy` WHERE `mobile`='$mobile'";
				$result=mysqli_query($conn,$query);
				if(mysqli_num_rows($result)>0){

							$output['res']='error';
							$output['msg']='Mobile Number is already register';
				}
				else
				{   
			        
					$result=mysqli_query($conn,"insert into tbl_deliveryboy (name,email,mobile,password,otp,otp_status,wallet,status,delete_status,date,time,token) values ('$name','$email','$mobile','$password','$otp','false','0','false','false','$date','$time','$token')");
						if($result){
							
							$query12="SELECT * FROM `tbl_deliveryboy` WHERE `mobile`='$mobile'";
							$result12=mysqli_query($conn,$query12);
							if(mysqli_num_rows($result12)>0){
								$row=mysqli_fetch_assoc($result12);
								$fb_id=$fb_id."".$row['id'];
								$query2="update `tbl_deliveryboy` set sponsorID='$fb_id' WHERE `mobile`='$mobile'";
							   $result2=mysqli_query($conn,$query2);
							   // sendsms($mobile,$otp);
								$output['res']='success';
								$output['msg']='Registration Successfully';
							}
						}
						else{
							$output['res']='error';
							$output['msg']='Something went wrong';
						}
				
				}
                
            }
			echo json_encode($output);
            
            break;
			case 'VerifyOTP':
			$mobile=$_POST['mobile'];
			$otp=$_POST['otp'];
			if(empty($mobile)||empty($otp)){
				$output['res']='error';
				$output['msg']='Field Required';
			
			}else{
				$check=mysqli_query($conn,"select * from tbl_deliveryboy where mobile='$mobile'");
				if(mysqli_num_rows($check)>0){
					$values=mysqli_fetch_assoc($check);
					if($otp==$values['otp']){
						$update=mysqli_query($conn,"update tbl_deliveryboy set  otp_status='true',status='true', date='$date', time='$time' where mobile='$mobile'");
						// var_dump($conn);
						if($update){
							$check=mysqli_query($conn,"select * from tbl_deliveryboy where mobile='$mobile'");
							$values=mysqli_fetch_assoc($check);
							$output['res']='success';
							$output['msg']='Otp Verified';
							$output['data']=$values;
						}else{
							$output['res']='error';
							$output['msg']='Something went wrong';
						}
					}else{
						    $output['res']='error';
							$output['msg']='Invalid OTP';
					}
				}else{
					
						$output['res']='error';
						$output['msg']='Invalid User';
					
				}
			}
			
			echo json_encode($output);
			break;
			case 'updateProfile':
				$user_id=$_POST['id'];
				$image=$_POST['image'];
				$image_str=$_POST['str_image'];
				$adhar=$_POST['adhar'];
				$address=$_POST['address'];
				$result=[];
				$sel="select * from tbl_deliveryboy where id='$user_id'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					$UserImage = str_replace('data:image/png;base64,', '', $_POST['image']);
					$UserImage = str_replace(' ', '+', $UserImage);
					$data1 = base64_decode($UserImage);
					$UserImage1="Driver_".date('YHis').rand(1000,9999). '.jpg';
					$file1 = 'uploads/Driver/' . $UserImage1;
					file_put_contents($file1, $data1);
					$UserImage1=$UserImage1;
					
					
					$UserImage12 = str_replace('data:image/png;base64,', '', $_POST['str_image']);
					$UserImage12 = str_replace(' ', '+', $UserImage12);
					$data11 = base64_decode($UserImage12);
					$UserImage11="Driver_".date('YHis').rand(1000,9999). '.jpg';
					$file11 = 'uploads/Driver/' . $UserImage11;
					file_put_contents($file11, $data11);
					$UserImage11=$UserImage11;
					
					
					
					$check=mysqli_query($conn,"update tbl_deliveryboy set document_image='$UserImage1', image='$UserImage11',  document_no='$adhar', address='$address' where id='$user_id'");
					if($check){
					$output['res']='success';
					$output['msg']='Profile Updated';
					}else{
						$output['res']='error';
					$output['msg']='Prifile Not Updated';
					}
				}
				else
				{
					$output['res']='error';
					$output['msg']='User not Exits';
					$output['data']=[];
				}
				echo json_encode($output);
				break;
			case 'Login':
			$mobile=$_POST['mobile'];
			$password=$_POST['password'];
			if(empty($mobile)||empty($password)){
				$output['res']='error';
				$output['msg']='Field Required';
			
			}else{
				$check=mysqli_query($conn,"select * from tbl_deliveryboy where mobile='$mobile' and password='$password'");
				if(mysqli_num_rows($check)>0){
					$values=mysqli_fetch_assoc($check);
					if($values['otp_status']=='true'){
							
								$output['res']='success';
								$output['msg']='Login Successfull !';
								$output['data']=$values;
					
							
					
					}else{
						    $output['res']='error';
							$output['msg']='OTP not verified';
					}
					
				}else{
					        $output['res']='error';
							$output['msg']='Invalid Username or password';
				}
			}
			
			echo json_encode($output);
			break;
			
			case 'getUser':
				$user_id=$_POST['user_id'];
				$result=[];
				$sel="select * from tbl_deliveryboy where id='$user_id'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					$row=mysqli_fetch_assoc($res);
					$output['res']='success';
					$output['msg']='data found';
					$output['data']=$row;
				}
				else
				{
					$output['res']='error';
					$output['msg']='data not found';
					$output['data']=[];
				}
				echo json_encode($output);
				break;
				
				case 'UpdateLocation':
				$lat=$_POST['lat'];
				$long=$_POST['long'];
				$id=$_POST['id'];
			
				$check=mysqli_query($conn,"update tbl_deliveryboy set lat='$lat' , longi='$long' where id='$id'");
				// var_dump($conn);
				if($check){
					$output['res']='success';
		            $output['msg']='Location Updated !';
					
				}else{
				$output['res']='error';
		        $output['msg']='Not Updated';	
				}
	
			echo json_encode($output);
			break;
			case 'UpdateToken':
				$id=$_POST['id'];
				$token=$_POST['token'];
			
				$check=mysqli_query($conn,"update tbl_deliveryboy set token='$token' where id='$id'");
				// var_dump($conn);
				if($check){
					$output['res']='success';
		            $output['msg']='Location Updated !';
					
				}else{
				$output['res']='error';
		        $output['msg']='Not Updated';	
				}
	
			echo json_encode($output);
			break;
			case 'ResetPassword':
				$user_id=$_POST['id'];
				$oldPass=$_POST['password'];
				$newPass=$_POST['npassword'];
				if(empty($user_id) or empty($oldPass) or empty($newPass)){
					$output['res']='error';
					$output['msg']='Fill Required';
					echo json_encode([$output]);
				}
				else{
						$check=mysqli_query($conn,"select * from tbl_deliveryboy where id='$user_id'");
						if(mysqli_num_rows($check)>0){
							$values=mysqli_fetch_assoc($check);
							if($oldPass==$values['password']){
								if($newPass!=$values['password']){
									$query="UPDATE tbl_deliveryboy SET password='$newPass' where id='$user_id'";
					
										if(mysqli_query($conn,$query)){
											$output['res']='success';
											$output['msg']='Password Change';
											echo json_encode($output);
										}
										else{
											$output['res']='error';
											$output['msg']='Password not Change';
											echo json_encode($output);
										}
								}else{
											$output['res']='error';
											$output['msg']='New Password can not be same as current';
											echo json_encode($output);
										}
							}else{
											$output['res']='error';
											$output['msg']='Old Password Not Match';
											echo json_encode($output);
										}
						}else{
											$output['res']='error';
											$output['msg']='User not exist';
											echo json_encode($output);
										}
				}
				break;
				
				case 'updateDetails':
				$user_id=$_POST['id'];
				$name=$_POST['name'];
				$email=$_POST['email'];
				$image=$_POST['image'];
				$address=$_POST['address'];
				$adharcard=$_POST['adharcard'];
				$result=[];
				$sel="select * from tbl_deliveryboy where id='$user_id'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					$check="";
					if($image!=""){
						$UserImage = str_replace('data:image/png;base64,', '', $_POST['image']);
						$UserImage = str_replace(' ', '+', $UserImage);
						$data1 = base64_decode($UserImage);
						$UserImage1="Driver_".date('YHis').rand(1000,9999). '.jpg';
						$file1 = 'uploads/Driver/' . $UserImage1;
						file_put_contents($file1, $data1);
						$UserImage1=$UserImage1;
						
						$check=mysqli_query($conn,"update tbl_deliveryboy set  email='$email', image='$UserImage1',  name='$name',adharcard='$adharcard', address='$address' where id='$user_id'");
					}else{
						
						$check=mysqli_query($conn,"update tbl_deliveryboy set  email='$email', name='$name',adharcard='$adharcard',  address='$address' where id='$user_id'");
					}
					
					if($check){
					$output['res']='success';
					$output['msg']='Profile Updated';
					}else{
						$output['res']='error';
					$output['msg']='Profile Not Updated';
					}
				}
				else
				{
					$output['res']='error';
					$output['msg']='User not Exits';
					$output['data']=[];
				}
				echo json_encode($output);
				break;
				
				case 'ReferralCode':
				$user_id=$_POST['user_id'];
				$code=$_POST['code'];
				$result=[];
				     $sel21="select * from tbl_referral";
				     $res21=mysqli_query($conn,$sel21);
					 $data0=mysqli_fetch_assoc($res21);
					 $amount=$data0['amount'];
				$sel="select * from tbl_deliveryboy where sponsorID='$code'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
						$sel66="select * from tbl_deliveryboy where referral_id='$code'";
				     $res66=mysqli_query($conn,$sel66);
					$num=mysqli_num_rows($res66);
					
					 $data=mysqli_fetch_assoc($res);
					 $id=$data['id'];
					 
					 $sel22="select * from tbl_deliveryboy where id='$id'";
				     $res22=mysqli_query($conn,$sel22);
					 $data1=mysqli_fetch_assoc($res22);
					 $amount1=$data1['wallet'];
					 
					 $sel23="select * from tbl_deliveryboy where id='$user_id'";
				     $res23=mysqli_query($conn,$sel23);
					 $data2=mysqli_fetch_assoc($res23);
					 $amount2=$data2['wallet'];
					 
					 if($num<2){
					 $amount1=(int)$amount+(int)$amount1;
					 }
					 $amount2=(int)$amount+(int)$amount2;
					 
						$check=mysqli_query($conn,"update tbl_deliveryboy set  wallet='$amount2', referral_id='$code' where id='$user_id'");
						
						$check=mysqli_query($conn,"update tbl_deliveryboy set  wallet='$amount1' where id='$id'");
						
						$msg="Your wallet is credited of ₹".$amount." For Reffer & Earn!";
						if($num<2){
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$id','$amount','$msg','Credit','Driver','$date','$time')");
						}
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount','$msg','Credit','Driver','$date','$time')");
					
					$output['res']='success';
					$output['msg']='Profile Updated';
					$output['amount']=$amount;
					
				}
				else
				{
					// $check="select * from referal where code='$code'";
					// $rescheck=mysqli_query($conn,$check);
					
					// if(mysqli_num_rows($rescheck)>0)
					// {
						 // $data=mysqli_fetch_assoc($rescheck);
						 // $price=$data['price'];
						 
						  // $sel23="select * from tbl_deliveryboy where id='$user_id'";
				     // $res23=mysqli_query($conn,$sel23);
					 // $data2=mysqli_fetch_assoc($res23);
					 // $amount2=$data2['wallet'];
					 
					
					 // $amount2=(int)$price+(int)$amount2;
					 
						// $check=mysqli_query($conn,"update tbl_deliveryboy set  wallet='$amount2', referral_id='$code' where id='$user_id'");
						
						// $msg="Your wallet is credited of ₹".$price." For Reffer & Earn!";
						
						// $check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$price','$msg','Credit','User','$date','$time')");
						 // $output['res']='success';
					     // $output['msg']='Code Valid';
					     // $output['amount']=$price;
					// }else{
						$output['res']='error';
					    $output['msg']='Code is not Valid';
					// }
				}
				echo json_encode($output);
				break;
			default:
			$output['res']='error';
			$output['msg']='Flag Not Match';
			echo json_encode($output);
			break;
			
			
			
			}
	
	}
	else{
		$output['res']='error';
		$output['msg']='Flag Required';
		echo json_encode($output);
	}
?>
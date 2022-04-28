<?php
	require 'connect.php';
	if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
		// $flag="ReferralCode";
		switch($flag){
			case 'Register':
            // $name=$_POST['name'];
            $name=$_POST['name'];
            $email=$_POST['email'];
            $mobile=$_POST['mobile'];
            $password=$_POST['password'];
            $token=$_POST['token'];
			$sponsorID="ZPSUSER";
			$otp="123456";//mt_rand(100000,999999); 
			$subject="OTP Verification";
			$msg = "Your OTP Verification Code is <span style='font-weight:bold;color:#000;font-size:22px'>".$otp."</span>. Do not share it with anyone.";
			$user_img="Avatar-Transparent-Background-PNG.png";
			if( empty($mobile)){
                $output['res']='error';
				$output['msg']='Field Required';
            }
            else{
				$query="SELECT * FROM `tbl_user` WHERE `mobile`='$mobile'";
				$result=mysqli_query($conn,$query);
				if(mysqli_num_rows($result)>0){

					$result=mysqli_query($conn,"update tbl_user set name='$name', email='$email', password='$password', otp='$otp',token='$token' where mobile ='$mobile'");
					if($result){
						
						$output['res']='success';
						$output['msg']='OTP Send to your mobile number';
					}else{
						$output['res']='error';
						$output['msg']='OTP not sent !';
					}
				}
				else
				{
					$result=mysqli_query($conn,"insert into tbl_user (name,email,password,mobile,image,otp,otp_status,wallet,commission,status,delete_status,date,time,token) values ('$name','$email','$password','$mobile','$user_img','$otp','false','0','0','false','false','$date','$time','$token')");
						if($result){
							
							$query12="SELECT * FROM `tbl_user` WHERE `mobile`='$mobile'";
							$result12=mysqli_query($conn,$query12);
							if(mysqli_num_rows($result12)>0){
								$row=mysqli_fetch_assoc($result12);
								$sponsorID=$sponsorID."".$row['id'];
								$query2="update `tbl_user` set sponsorID='$sponsorID' WHERE `mobile`='$mobile'";
							   $result2=mysqli_query($conn,$query2);
								$output['res']='success';
								$output['msg']='OTP Send to your Mobile Number';
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
				$check=mysqli_query($conn,"select * from tbl_user where mobile='$mobile'");
				if(mysqli_num_rows($check)>0){
					$values=mysqli_fetch_assoc($check);
					if($otp==$values['otp']){
						$update=mysqli_query($conn,"update tbl_user set  otp_status='true', status='true', date='$date', time='$time' where mobile='$mobile'");
						// var_dump($conn);
						if($update){
							$check=mysqli_query($conn,"select * from tbl_user where mobile='$mobile'");
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
			
			case 'Login':
			$mobile=$_POST['mobile'];
			$password=$_POST['password'];
			if(empty($mobile)||empty($password)){
				$output['res']='error';
				$output['msg']='Field Required';
			
			}else{
				$check=mysqli_query($conn,"select * from tbl_user where mobile='$mobile' and password='$password' and status='true'");
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
				$sel="select * from tbl_user where id='$user_id'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					$row=mysqli_fetch_assoc($res);
					
					// $val111=mysqli_query($conn,"SELECT * FROM `address` WHERE `user_id`='$user_id' order by id desc limit 1");
					// if(mysqli_num_rows($val111)>0){
						// $val1111=mysqli_fetch_assoc($val111);
						// $row['address']=$val1111;
						// $row['address_status']="yes";
					// }else{
						// $row['address']=[];
						// $row['address_status']="no";
					// }
					// $data21=array_merge($val1111,$row);	
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
				case 'GetReferral':
				$user_id=$_POST['user_id'];
				$result=[];
				$sel="select * from tbl_user where referral_id='$user_id'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					while($row=mysqli_fetch_assoc($res)){
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
				
				case 'UpdateLocation':
				$lat=$_POST['lat'];
				$long=$_POST['long'];
				$id=$_POST['id'];
			
				$check=mysqli_query($conn,"update tbl_user set lat='$lat' , longi='$long' where id='$id'");
				// var_dump($conn);
				if($check){
					$output['res']='success';
		            $output['msg']='Membership Successfull !';
					
				}else{
				$output['res']='error';
		        $output['msg']='Not Updated';	
				}
	
			echo json_encode($output);
			break;
			case 'Membership':
				$id=$_POST['id'];
			
				$check=mysqli_query($conn,"update tbl_user set m_status='true' where id='$id'");
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
			case 'updateProfile':
				$user_id=$_POST['user_id'];
				$image=$_POST['image'];
				$name=$_POST['name'];
				$email=$_POST['email'];
				$result=[];
				$sel="select * from tbl_user where id='$user_id'";
				$res=mysqli_query($conn,$sel);
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					$check="";
					if($image!=""){
						$UserImage = str_replace('data:image/png;base64,', '', $_POST['image']);
						$UserImage = str_replace(' ', '+', $UserImage);
						$data1 = base64_decode($UserImage);
						$UserImage1="User_".date('YHis').rand(1000,9999). '.jpg';
						$file1 = 'uploads/user/' . $UserImage1;
						file_put_contents($file1, $data1);
						$UserImage1=$UserImage1;
						$check=mysqli_query($conn,"update tbl_user set image='$UserImage1', name='$name', email='$email' where id='$user_id'");
					}else{
						$check=mysqli_query($conn,"update tbl_user set  name='$name', email='$email' where id='$user_id'");
					}
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
				case 'ResetPassword':
				$user_id=$_POST['id'];
				$oldPass=$_POST['password'];
				$newPass=$_POST['npassword'];
				if(empty($user_id) or empty($oldPass) or empty($newPass)){
					$output['res']='error';
					$output['msg']='Fill Required';
					echo json_encode($output);
				}
				else{
						$check=mysqli_query($conn,"select * from tbl_user where id='$user_id'");
						if(mysqli_num_rows($check)>0){
							$values=mysqli_fetch_assoc($check);
							if($oldPass==$values['password']){
								if($newPass!=$values['password']){
									$query="UPDATE tbl_user SET password='$newPass' where id='$user_id'";
					
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
				
				
				case 'ReferralCode':
				
				
				$user_id=$_POST['user_id'];
				$code=$_POST['code'];
				// $user_id='6';
				// $code='ZPSUSER1';
				
				$result=[];
				$sel21="select * from tbl_referral";
				$res21=mysqli_query($conn,$sel21);
				$data0=mysqli_fetch_assoc($res21);
				$amount=$data0['amount'];
				$amount="50";
				$sel="select * from tbl_user where sponsorID='$code'";
				$res=mysqli_query($conn,$sel); 
				$data21=array();
				if(mysqli_num_rows($res)>0)
				{
					/*function referral($friend_code)
					{
						global $conn;
						$sql = mysqli_query($conn,"SELECT * FROM tbl_user WHERE referral_id='$friend_code' order by id desc");
						$data =mysqli_fetch_assoc($sql);
						if($data==false)
						{
							return $friend_code;
						}
						$sql = mysqli_query($conn,"SELECT * FROM tbl_user WHERE referral_id='$friend_code' order by id desc");
						$referral_1 = array();
						$i=0;
						while($row=mysqli_fetch_assoc($sql)) {
							$ref=$row['sponsorID'];
							$sql1 = mysqli_query($conn,"SELECT * FROM tbl_user WHERE referral_id='$ref'");
							$data1 = mysqli_fetch_assoc($sql1);
							$total_ref_1=mysqli_num_rows($sql1);
							$total_ref=array('count'=>$total_ref_1,'user_id'=>$row['id']);
							array_push($referral_1, $total_ref);
						}
						
						$ist=$referral_1[0]['count'];
						$id=$referral_1[0]['user_id'];
						
						for($j=0;$j<count($referral_1);$j++)
						{
							if($ist<$referral_1[$j]['count'])
							{
								$ist=$ist;
								$id=$id;
							}
							else
							{
								$ist=$referral_1[$j]['count'];
								$id=$referral_1[$j]['user_id'];
							}
						}
						
						
						$sql2 = mysqli_query($conn,"SELECT * FROM tbl_user WHERE id='$id'");
						$data2 = mysqli_fetch_assoc($sql2);
						
						$sql9 = mysqli_query($conn,"SELECT * FROM tbl_user WHERE referral_id='".$data2['sponsorID']."'");
						$data9 = mysqli_num_rows($sql9);
						
						if($data9<10) 
						{
							return $data2['sponsorID'];
						}
						else
						{
							return referral($data2['sponsorID']);
						}
					}
					$sql = mysqli_query($conn,"SELECT id FROM tbl_user WHERE referral_id='$code'");
					$total_ref=mysqli_num_rows($sql);	
					if($total_ref<10)
					{
						$code = $_POST['code'];
					}
					else
					{
						$code = referral($code);
					}*/
					// echo $code;
					$code = $_POST['code'];
					$sel66="select * from tbl_user where referral_id='$code'";
				    $res66=mysqli_query($conn,$sel66);
					$num=mysqli_num_rows($res66);
					
					 $data=mysqli_fetch_assoc($res);
					 $id=$data['user_id'];
					 
					 $sel22="select * from tbl_user where id='$id'";
				     $res22=mysqli_query($conn,$sel22);
					 $data1=mysqli_fetch_assoc($res22);
					 $amount1=$data1['wallet'];
					 
					 $sel23="select * from tbl_user where id='$user_id'";
				     $res23=mysqli_query($conn,$sel23);
					 $data2=mysqli_fetch_assoc($res23);
					 $amount2=$data2['wallet'];
					 
					 if($num<2){
					 $amount1=(int)$amount+(int)$amount1;
					 }
					 $amount2=(int)$amount+(int)$amount2;
					 
						$check=mysqli_query($conn,"update tbl_user set  wallet='$amount2', referral_id='$code' where id='$user_id'");
						
						$check=mysqli_query($conn,"update tbl_user set  wallet='$amount1' where id='$id'");
						
						$msg="Your wallet is credited of ₹".$amount." For Reffer & Earn!";
						if($num<2){
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$id','$amount','$msg','Credit','User','$date','$time')");
						}
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount','$msg','Credit','User','$date','$time')");
					
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
						 
						  // $sel23="select * from tbl_user where id='$user_id'";
				     // $res23=mysqli_query($conn,$sel23);
					 // $data2=mysqli_fetch_assoc($res23);
					 // $amount2=$data2['wallet'];
					 
					
					 // $amount2=(int)$price+(int)$amount2;
					 
						// $check=mysqli_query($conn,"update tbl_user set  wallet='$amount2', referral_id='$code' where id='$user_id'");
						
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
				case 'UpdateToken':
				$id=$_POST['id'];
				$token=$_POST['token'];
			
				$check=mysqli_query($conn,"update user set token='$token' where id='$id'");
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
			
			case 'get_refferal_list':
				
				$user_id=$_POST['user_id'];
				if(!empty($user_id)){
					$sel=mysqli_query($conn,"SELECT sponsorID FROM tbl_user where id='$user_id' ");
					$data=mysqli_fetch_assoc($sel);
					if($data){
						$sponsorID=$data['sponsorID'];
						$result=[];
						$sel=mysqli_query($conn,"SELECT * FROM tbl_user where referral_id='$sponsorID' ");
						$count=mysqli_num_rows($sel);
						if($count>0){
							while($data=mysqli_fetch_assoc($sel)){
								array_push($result,$data);
							}
							$output['res']='success';
							$output['msg']='Data found';	
							$output['data']=$result;
						}else{
							$output['res']='error';
							$output['msg']='Data not found';		
						}
					}else{
						$output['res']='error';
						$output['msg']='Data not found';	
					}
					
				}else{
					$output['res']='error';
					$output['msg']='Data are require';
				}
				echo json_encode($output);
				
				
			break;
				case 'AddUser':
            $m_id=$_POST['m_id'];
            $name=$_POST['name'];
            $email=$_POST['email'];
            $mobile=$_POST['mobile'];
            $password=$_POST['password'];
           
			$sponsorID="ZPSUSER";
			$otp="123456";//mt_rand(100000,999999); 
			
			$user_img="Avatar-Transparent-Background-PNG.png";
			if( empty($mobile)){
                $output['res']='error';
				$output['msg']='Field Required';
            }
            else{
				$query="SELECT * FROM `tbl_user` WHERE `mobile`='$mobile'";
				$result=mysqli_query($conn,$query);
				if(mysqli_num_rows($result)>0){

					
						$output['res']='error';
						$output['msg']='Mobile Number Already Exist !';
					
				}
				else
				{
					 $query="SELECT * FROM `tbl_user` WHERE `id`='$m_id'";
				  $result1=mysqli_query($conn,$query);
				  $dat=mysqli_fetch_assoc($result1);
				  
				  $sp_id=$dat['sponsorID'];
				  
					$result=mysqli_query($conn,"insert into tbl_user (name,email,password,mobile,referral_id,image,otp,otp_status,wallet,commission,status,delete_status,date,time) values ('$name','$email','$password','$mobile','$sp_id','$user_img','$otp','true','0','0','true','false','$date','$time')");
						if($result){
							
							$query12="SELECT * FROM `tbl_user` WHERE `mobile`='$mobile'";
							$result12=mysqli_query($conn,$query12);
							if(mysqli_num_rows($result12)>0){
								$row=mysqli_fetch_assoc($result12);
								$sponsorID=$sponsorID."".$row['id'];
								$query2="update `tbl_user` set sponsorID='$sponsorID' WHERE `mobile`='$mobile'";
							   $result2=mysqli_query($conn,$query2);
								$output['res']='success';
								$output['msg']='OTP Send to your Mobile Number';
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
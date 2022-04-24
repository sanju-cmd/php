<?php 

	require '../init.php';
	$flag=$_REQUEST['flag'];

	switch ($flag) 
	{
		
		case 'Login':
			$email=$_POST['email'];
			$password=$_POST['password'];
			$pwd=sha1($password);
			if(empty($email) or empty($password))
			{
				echo json_encode(array('res' =>'error' ,'msg'=>'All field required'));
			}
			else
			{
			$source->Query("SELECT * From `admin` WHERE  `email`='$email' and `password`='".$pwd."' ");
			$data=$source->Single();
			if($data){
				if($data->password==$pwd){
					$id=$data->id;
					$LogTime=$date.' '.$time;
					$query=$source->Query("UPDATE `admin` SET `date`=? WHERE `id`=?",[$LogTime,$id]);
	                if($query)
	                {
	                 
                      $_SESSION['email']=$email;
					  $_SESSION['name']=$data->name;
					  $_SESSION['mobile']=$data->mobile;
	                  $id=$data->id;
	                  
						$output = array('res' => 'success', 'msg'=>'Successfully login '. $data->name,'url'=>'Dashboard');
						echo json_encode($output);
					}
					else{
						$output = array('res' => 'error', 'msg'=>'Something went wrong');
						echo json_encode($output);		
					}
				}else{
					echo json_encode(array('res' =>'error' ,'msg'=>'Invalid password'));
				}
			}else{
				echo json_encode(array('res' =>'error' ,'msg'=>'Invalid username or email'));
			}
			}
			break;

			case 'ChangePassword1':
			$oldp=$_POST['op'];
			$newp=$_POST['np'];
			$conp=$_POST['cnp'];

			if (empty($oldp) or empty($newp) or empty($conp)) {
				$output = array('res' => 'error', 'msg'=>'All fields are required');
				echo json_encode($output);
			}
			else{
				$username=$_SESSION['email'];
				$source->Query("SELECT * FROM admin where  `email`=? ",[$username]);
				$data=$source->Single();
				if (sha1($oldp)==$data->password) {
					if ($newp==$conp) {
						if ($newp==$oldp) {
							$output = array('res' => 'error', 'msg'=>'Your new password must be different from your previous password.');
							echo json_encode($output);	
						}else{
						$query=$source->Query("UPDATE `admin` SET `password`=?  WHERE `email`=?",[sha1($newp),$data->email]);
						$_SESSION['password']=$newp;
							$output = array('res' => 'success', 'msg'=>'Success! Your Password has been changed!','url'=>'Logout');
							echo json_encode($output);	
						}
					}else{
						$output = array('res' => 'error', 'msg'=>'New password and confirmation password do not match.');
						echo json_encode($output);	
					}
				}else{
					$output = array('res' => 'error', 'msg'=>'The old password you have entered is incorrect');
					echo json_encode($output);	
				}
			}

			break;
			case 'UpdateProfileDetails':

				$name=$_POST['name'];
				$email=$_POST['email'];
				$mobile=$_POST['mobile'];
				

				if (empty($name)  or empty($email) or empty($mobile)) {
						$output = array('res' => 'error', 'msg'=>'All fields are required');
						echo json_encode($output);
				}
				else{	
					if(!empty($_FILES['image']['name'])){
						$image=date('YHis').rand(1000,9999).'.'.pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
						move_uploaded_file($_FILES['image']['tmp_name'],"../upload/banner/".$image);
						$source->Query("UPDATE `admin` SET `profile_pic`='$image' WHERE `id`='1'");
			         }	
					$query=$source->Query("UPDATE `admin` SET `name`=? ,`email`=? ,`mobile`=?  WHERE `id`=?",[$name,$email,$mobile,1]);
					if($query){
					$output = array('res' => 'success', 'msg'=>'Success! Your Profile has been changed!','url'=>'UpdateProfile');
							echo json_encode($output);
					}
					
				}
				break;
				case 'UpdateProfile':
					$username=$_SESSION['user_name'];
					$source->Query("SELECT * FROM user where `user_name`=? or `email`=? ",[$username,$username]);
					$data=$source->Single();

					if(empty($_FILES['file']['name']))
					{
						$profile = $_FILES['BgFile']['name'];
			            $profile_pic_temp=$_FILES['BgFile']['tmp_name'];
			            $profile_pic_size=$_FILES["BgFile"]["size"];
			            
			             if(empty($profile)){
				                echo json_encode(array("res"=>"Error","msg"=>"Select any profile image"));
				            }else{
				            	$ext1=explode(".",$profile);
				                $ext=end($ext1);
				                //Rename Pic
				                $profile_pic=date("Ymdhis").".".$ext;
				                $path="../img/".$profile_pic;
	             				$allow=array("jpeg","jpg","png","gif");
	             				   if(in_array($ext,$allow) && $profile_pic_size<5000000){
				                  	$res=$source->Query("UPDATE `user` SET `bgimg`=?  WHERE `id`=?",[$profile_pic,$data->id]);
				                    if($res){
				                        move_uploaded_file($profile_pic_temp,$path);
				                      
				                        echo json_encode(array("res"=>"success","msg"=>"Success! Your profile pic has been changed"));
				                    }
				                    else{
				                       echo json_encode(array("res"=>"error","msg"=>"Error! Something went wrong"));
				                    }
				                }
				                else{
				                     echo json_encode(array("res"=>"error","msg"=>"Invalid Profile Pic(Ex-jpg,png and less then 2MB)"));
				                }
				            }
						}
					else{
					$profile = $_FILES['file']['name'];
		            $profile_pic_temp=$_FILES['file']['tmp_name'];
		            $profile_pic_size=$_FILES["file"]["size"];
		            
		             if(empty($profile)){
			                echo json_encode(array("res"=>"Error","msg"=>"Select any profile image"));
			            }else{
			            	$ext1=explode(".",$profile);
			                $ext=end($ext1);
			                //Rename Pic
			                $profile_pic=date("Ymdhis").".".$ext;
			                $path="../img/".$profile_pic;
             				$allow=array("jpeg","jpg","png","gif");
             				   if(in_array($ext,$allow) && $profile_pic_size<5000000){
			                  	$res=$source->Query("UPDATE `user` SET `img`=?  WHERE `id`=?",[$profile_pic,$data->id]);
			                    if($res){
			                        move_uploaded_file($profile_pic_temp,$path);
			                      
			                        echo json_encode(array("res"=>"success","msg"=>"Success! Your profile pic has been changed"));
			                    }
			                    else{
			                       echo json_encode(array("res"=>"error","msg"=>"Error! Something went wrong"));
			                    }
			                }
			                else{
			                     echo json_encode(array("res"=>"error","msg"=>"Invalid Profile Pic(Ex-jpg,png and less then 2MB)"));
			                }
			            }
			        }

					break;

						

					// ForgetPassword

					case 'ForgetPassword':
							$userName=$_POST['email'];
							if(empty($userName))
							{
								echo json_encode(array('res' =>'error' ,'msg'=>'All field required'));
							}
							else
							{
								$source->Query("SELECT * FROM `user` WHERE `email`=?",[$userName]);
								$loginData=$source->Single();
								// var_dump($loginData);
								if($loginData){
									if(empty($_POST['SelectLogin'])){
										echo json_encode(array('res' =>'otp' ,'msg'=>'Enter OTP '.'1234','otp'=>$userName));
									}else{
										$otp=$_POST['otp'];
										if($otp=='1234'){
											$value = array('userName' =>$userName);
											$_SESSION['PwdNew']=$value;
											echo json_encode(array('res' =>'newPwd' ,'msg'=>'Enter a new password','url'=>"NewPwd"));
										}else{
											echo json_encode(array('res' =>'error' ,'msg'=>'Enter a currect OTP'));
										}
									}
								}else{
									echo json_encode(array('res' =>'error' ,'msg'=>'Enter a currect UserName or email or password'));
								}
							}
						break;
					case 'NewPwd':
						$userName=$_SESSION['PwdNew'];
						$userName=$userName['userName'];
						$NewPwd=$_POST['NewPwd'];
						$ConPwd=$_POST['ConPwd'];
						if(empty($NewPwd) or empty($ConPwd))
						{
							echo json_encode(array('res' =>'error' ,'msg'=>'All field required'));
						}
						else
						{
							if($NewPwd==$ConPwd){
									$password=sha1($NewPwd);
									$source->Query("UPDATE `user` SET `password`=? WHERE  `email`=? ",[$password,$userName]);
									echo json_encode(array('res' =>'success' ,'msg'=>'password updated Successfully','url'=>'Login'));
							}else{
								echo json_encode(array('res' =>'error' ,'msg'=>'Please enter a same password'));
							}
						}
					break;	

			case 'UpdateP':
            $name=$_POST['name'];
			$email=$_POST['email'];
			$mobile=$_POST['mobile'];
			$address=$_POST['address'];
            if(empty($name) or empty($email) or empty($mobile) or empty($address)){
                $output = array('res' => 'error', 'msg'=>'All field require ');
				echo json_encode($output);
            }
            else{
				$res=$source->Query("UPDATE `admin` SET `name`='$name', `email`='$email', `mobile`='$mobile', `address`='$address' WHERE `id`='1'");
                if($res){
					if(!empty($_FILES['image']['name'])){
                        $image=md5(time().rand(10,99)).'.'.pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES['image']['tmp_name'],"../upload/admin/".$image);
                        //unlink_data('admin',$id,'image');
                        $source->Query("UPDATE `admin` SET `image`='$image' WHERE `id`='1'");
                    }
                    $output = array('res' => 'success', 'msg'=>'Profile has been Updated');
					echo json_encode($output);
                }
                else{
                    $output = array('res' => 'error', 'msg'=>'Failed ');
					echo json_encode($output);
                }
            }
			
            break;
			
			case 'ChangePassword':
                // Receive value
                $opass=$_POST['opass'];
                $npass=$_POST['npass'];
                $cpass=$_POST['cpass'];
                if(empty($opass)){
					 $output = array('res' => 'error', 'msg'=>'Enter Current Password ');
					echo json_encode($output);
                }
                else if(empty($npass)){
					$output = array('res' => 'error', 'msg'=>'Enter New Password ');
					echo json_encode($output);
                }
                else if(empty($cpass)){
					$output = array('res' => 'error', 'msg'=>'Enter Confirm Password ');
					echo json_encode($output);
                }
                else if(strlen($npass)<5){
					$output = array('res' => 'error', 'msg'=>'New Password minimum 6 character ');
					echo json_encode($output);
                }
                else if($npass!=$cpass){
					$output = array('res' => 'error', 'msg'=>'New & Confirm Password Not Match ');
					echo json_encode($output);
                }
                else{
					$source->Query("SELECT * FROM `admins` WHERE `id`=?",[1]);
					$data=$source->Single();
					
                    if($data->password==$opass){
                        if($data->password!=$npass){
                              $res=$source->Query("UPDATE `admins` SET `password`='$npass' WHERE `id`='1'");
                                if($res){
                                    $output = array('res' => 'success', 'msg'=>'Password Changed Successfully ');
									echo json_encode($output);
                                }
                                else{
									$output = array('res' => 'error', 'msg'=>'Password not Changed');
									echo json_encode($output);
                                }

                            }
                        else{
                           echo json_encode(array("res"=>"Error","msg"=>"New & Current Password are same."));
                        }
                    }
                    else{
                        echo json_encode(array("res"=>"Error","msg"=>"Invalid Current Password"));
                    }
                }
                break;

				case 'ChangeStatus':
			
					$id=$_POST['id'];
					$sms=$_POST['sms'];
					
					
				
					if(empty($sms)){
						$output = array('res' => 'error', 'msg'=>'All field require ');
						echo json_encode($output);
					}
					else{
						$res=$source->Query("update tbl_lead set status='$sms' where id='$id'");
						if($res){
							
							$output = array('res' => 'success', 'msg'=>'Status Changed successfully','url'=>'ManageLead');
							echo json_encode($output);
						}
						else{
							$output = array('res' => 'error', 'msg'=>'Failed ');
							echo json_encode($output);
						}
					}
					
					
					
					break;

					case 'Logout':
						// $LogOut=$date.' '.$time;
						// $query=$source->Query("UPDATE `admin` SET `logout_time`=?  WHERE `id`=?",[$LogOut,'1']);
			            // unset($_SESSION['name']);
			            // unset($_SESSION['password']);
			            header("location:../logout");
						break;

		default:
			# code...
			break;
	}



 ?>
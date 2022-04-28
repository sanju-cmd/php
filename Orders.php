<?php
	    require "connect.php";
	    // require "Functions.php";
		
		if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
	   // $flag="Details";
		switch($flag){
			 case 'Order':
			 $user_id=$_POST['user_id'];
			 $address_id=$_POST['address_id'];
			 $product_id=$_POST['product_id'];
			 $varient_id=$_POST['variant_id'];
			 $vendor_id=$_POST['vendor_id'];
			 $buy=$_POST['buy'];
			 $qty=$_POST['qty'];
			 $total_price=$_POST['total_price'];
			 $order_id=$_POST['order_id'];
			 $order_type=$_POST['order_type'];
			 $coupon_id=$_POST['coupon_id'];
			 $d_charge=$_POST['d_charge'];
			 $c_discount=$_POST['c_discount'];
			  $pay_status="false";
			 if($order_type=='CASH'){
			   $pay_status="true";
			 }else if($order_type=='WALLET'){
			   $pay_status="true";
			 }else if($order_type=='WALLETCASH'){
			   $pay_status="true";
			 }else if($order_type=='RazorPay'){
			   $pay_status="false";
			 }else if($order_type=='Paytm'){
			   $pay_status="false";
			 }else if($order_type=='WALLETONLINE'){
			   $pay_status="false";
			 }
			 
			 $orderResponse=0;
			 
			 if(empty($total_price)||empty($user_id)){
				$output['res']='error';
				$output['msg']='Feild Required';
				$output['data']=[];
			}else{
				$total=0;
				
				$sel="select * from tbl_cart where user_id='$user_id'";
				$res=mysqli_query($conn,$sel);
				if(mysqli_num_rows($res)>0)
				{    
					$OID=rand()+time()+mt_rand().'-'.date('dmY');
					if($order_type=='WALLET'){
						$order_iddd="WAL-".$OID;
					}else if($order_type=='CASH'){
						$order_iddd="COD-".$OID;
					}else if($order_type=='WALLETCASH'){
						$order_iddd="WALC-".$OID;
					}else if($order_type=='WALLETONLINE'){
						$order_iddd="WALO-".$OID;
					}else{
						$order_iddd="ONL-".$OID;
					}	
					
					// Address
					
					$ad="select * from address where id='$address_id'";
					$res_ad=mysqli_query($conn,$ad);
				    $add=mysqli_fetch_assoc($res_ad);
					$address_full=json_encode($add);
				    
					$discount=0;
					while($dataCart=mysqli_fetch_assoc($res))
					{
						$product_id=$dataCart['product_id'];
						$vendor_id=$dataCart['vendor_id'];
						$varient_id=$dataCart['variant_id'];
						$qty=$dataCart['qty'];
						
						
						$sql_1=mysqli_query($conn,"SELECT * FROM tbl_product_details WHERE id='$varient_id'");
						$data_variant=mysqli_fetch_assoc($sql_1);
						
						if(!empty($coupon_id)){
							$sql_2=mysqli_query($conn,"SELECT * FROM coupon WHERE id='$coupon_id'");
							$coupon_data=mysqli_fetch_assoc($sel_2);
							$discount=$coupon_data['discount'];
						} 
						
						$Amount=$data_variant['price']*$qty;
						$discount_Amount=$Amount*$discount/100;
						$payAmount=$Amount-$discount_Amount;	
						
						
						 $query_for_id="insert into Orders (user_id,address_id,vendor_id,delivery_boy,product_id,variant_id,qty,total_price,order_id,order_type,coupon_id,c_discount,shipping_charge,pay_status,delivery_boy_status,date,time,status) values ('$user_id','$address_full','$vendor_id','','$product_id','$varient_id','$qty','$payAmount','$order_iddd','$order_type','$coupon_id','$discount_Amount','$d_charge','$pay_status','false','$date','$time','0')";
			      
				        $response=mysqli_query($conn,$query_for_id);
						
						
					}

					if($order_type=='WALLET'){
							
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						$sel23="select * from tbl_user where id='$user_id'";
						$res23=mysqli_query($conn,$sel23);
						$data2=mysqli_fetch_assoc($res23);
						$amount2=$data2['wallet'];
						 
						$amount2=(int)$amount2-(int)$total_price;
				 
						mysqli_query($conn,"update tbl_user set  wallet='$amount2' where id='$user_id'");
						$msg="Your wallet is debited of ₹".$total_price." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$total_price','$msg','Debit','User','$date','$time')");
						
					}else if($order_type=='CASH'){
						 $vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
					}else if($order_type=='WALLETCASH'){
						
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						 
						$sel23="select * from tbl_user where id='$user_id'";
						$res23=mysqli_query($conn,$sel23);
						$data2=mysqli_fetch_assoc($res23);
						$amount2=$data2['wallet'];
						
						mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
						$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
					
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
					
					}else if($order_type=='WALLETONLINE'){
						
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						$sel23="select * from tbl_user where id='$user_id'";
						$res23=mysqli_query($conn,$sel23);
						$data2=mysqli_fetch_assoc($res23);
						$amount2=$data2['wallet'];
						
						mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
						$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
					
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
					}


					$output['order_id']=$order_iddd;
					$output['res']='success';
					$output['msg']='Order Placed Successfully !';











			
			           // $checkOrder="select * from Orders where user_id='$user_id'";
						// $checkRes=mysqli_query($conn,$checkOrder);
						
						// if(mysqli_num_rows($checkRes)==0){
							// $orderResponse=1;
						// }
			            
						  
						  // $pro_id=explode(",",$product_id);
						  // $idd=$pro_id[0];
						  // $pdddd="select * from product where id='$idd'";
						  // $res_pro=mysqli_query($conn,$pdddd);
				          // $pro=mysqli_fetch_assoc($res_pro);
						  
						  // $ven_id=$pro['vendor_id'];
						  // var_dump($pro);
						  // $address_full=json_encode($add);
			             // $query_for_id="insert into Orders (user_id,address_id,vendor_id,delivery_boy,product_id,variant_id,qty,total_price,order_type,coupon_id,c_discount,shipping_charge,pay_status,delivery_boy_status,date,time,status) values ('$user_id','$address_full','$ven_id','','$product_id','$varient_id','$qty','$total_price','$order_type','$coupon_id','$c_discount','$d_charge','$pay_status','false','$date','$time','0')";
			      
				        // $response=mysqli_query($conn,$query_for_id);
						// var_dump($conn);
						
						// $sel="select * from Orders where user_id='$user_id' order by id desc limit 1";
						// $res=mysqli_query($conn,$sel);
						// $order_idd='';
						/*if($order_type=='WALLET'){
							
							$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
							 $sel23="select * from tbl_user where id='$user_id'";
							 $res23=mysqli_query($conn,$sel23);
							 $data2=mysqli_fetch_assoc($res23);
							 $amount2=$data2['wallet'];
							 
							 $amount2=(int)$amount2-(int)$total_price;
					 
					 
								mysqli_query($conn,"update tbl_user set  wallet='$amount2' where id='$user_id'");
								$msg="Your wallet is debited of ₹".$total_price." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$total_price','$msg','Debit','User','$date','$time')");
						
						 }else if($order_type=='CASH'){
							 $vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						 }else if($order_type=='WALLETCASH'){
							
							$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
							 
							  $sel23="select * from tbl_user where id='$user_id'";
							 $res23=mysqli_query($conn,$sel23);
							 $data2=mysqli_fetch_assoc($res23);
							 $amount2=$data2['wallet'];
							 
							 // $amount2=(int)$total_price-(int)$amount2;
					 
								mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
								$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
						
						 }else if($order_type=='WALLETONLINE'){
							
							 
							$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
							 
							  $sel23="select * from tbl_user where id='$user_id'";
							 $res23=mysqli_query($conn,$sel23);
							 $data2=mysqli_fetch_assoc($res23);
							 $amount2=$data2['wallet'];
							 
							 // $amount2=(int)$total_price-(int)$amount2;
					 
								mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
								$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
					   }
						
						*/
						// if(mysqli_num_rows($res)>0)
						// {
							// $data=mysqli_fetch_assoc($res);
							
							// $output['order_id']=$data['id'];
							// $order_idd=$data['id'];
							// $dates=str_replace("-","",$dat);
							// $order_iddd="";
							// if($order_type=='WALLET'){
							// $order_iddd="WAL-".$dates."-".$order_idd;
							// }else if($order_type=='CASH'){
								// $order_iddd="COD-".$dates."-".$order_idd;
							// }else if($order_type=='WALLETCASH'){
								// $order_iddd="WALC-".$dates."-".$order_idd;
							// }else if($order_type=='WALLETONLINE'){
								// $order_iddd="WALO-".$dates."-".$order_idd;
							// }else{
								// $order_iddd="ONL-".$dates."-".$order_idd;
							// }
							// mysqli_query($conn,"update Orders set order_id='$order_iddd' where id='$order_idd'");
						// }
						
						// send notification
						// require '../../Admin/code/app-token.php';
						// $username=mysqli_query($conn,"SELECT name from user where id='$user_id'");
						// $userdata=mysqli_fetch_array($username);
						// $User_name=$userdata['name'];
						// $shop=mysqli_query($conn,"SELECT token from shop where id='$ven_id'");
						// $shopdata=mysqli_fetch_array($shop);
						// $shopToken[]=$shopdata['token'];
						// $description= $User_name." has created a order of ₹".$total_price;
						// $title='New Order';
						// send_notification_multiple($description,$title,$img_url,$shopToken);
						// end notification
						
						
						
						
						
						
					
				}else{
					if($buy=='true'){
						
						$OID=rand()+time()+mt_rand().'-'.date('dmY');
					if($order_type=='WALLET'){
						$order_iddd="WAL-".$OID;
					}else if($order_type=='CASH'){
						$order_iddd="COD-".$OID;
					}else if($order_type=='WALLETCASH'){
						$order_iddd="WALC-".$OID;
					}else if($order_type=='WALLETONLINE'){
						$order_iddd="WALO-".$OID;
					}else{
						$order_iddd="ONL-".$OID;
					}	
					
					// Address
					
					$ad="select * from address where id='$address_id'";
					$res_ad=mysqli_query($conn,$ad);
				    $add=mysqli_fetch_assoc($res_ad);
					$address_full=json_encode($add);
				    
					$discount=0;
					// while($dataCart=mysqli_fetch_assoc($res))
					// {
						// $product_id=$dataCart['product_id'];
						// $vendor_id=$dataCart['vendor_id'];
						// $varient_id=$dataCart['variant_id'];
						// $qty=$dataCart['qty'];
						
						
						$sql_1=mysqli_query($conn,"SELECT * FROM tbl_product_details WHERE id='$varient_id'");
						$data_variant=mysqli_fetch_assoc($sql_1);
						
						if(!empty($coupon_id)){
							$sql_2=mysqli_query($conn,"SELECT * FROM coupon WHERE id='$coupon_id'");
							$coupon_data=mysqli_fetch_assoc($sel_2);
							$discount=$coupon_data['discount'];
						} 
						
						$Amount=$data_variant['price']*$qty;
						$discount_Amount=$Amount*$discount/100;
						$payAmount=$Amount-$discount_Amount;	
						
						
						 $query_for_id="insert into Orders (user_id,address_id,vendor_id,delivery_boy,product_id,variant_id,qty,total_price,order_id,order_type,coupon_id,c_discount,shipping_charge,pay_status,delivery_boy_status,date,time,status) values ('$user_id','$address_full','$vendor_id','','$product_id','$varient_id','$qty','$payAmount','$order_iddd','$order_type','$coupon_id','$discount_Amount','$d_charge','$pay_status','false','$date','$time','0')";
			      
				        $response=mysqli_query($conn,$query_for_id);
						
						
					// }

					if($order_type=='WALLET'){
							
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						$sel23="select * from tbl_user where id='$user_id'";
						$res23=mysqli_query($conn,$sel23);
						$data2=mysqli_fetch_assoc($res23);
						$amount2=$data2['wallet'];
						 
						$amount2=(int)$amount2-(int)$total_price;
				 
						mysqli_query($conn,"update tbl_user set  wallet='$amount2' where id='$user_id'");
						$msg="Your wallet is debited of ₹".$total_price." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$total_price','$msg','Debit','User','$date','$time')");
						
					}else if($order_type=='CASH'){
						 $vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
					}else if($order_type=='WALLETCASH'){
						
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						 
						$sel23="select * from tbl_user where id='$user_id'";
						$res23=mysqli_query($conn,$sel23);
						$data2=mysqli_fetch_assoc($res23);
						$amount2=$data2['wallet'];
						
						mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
						$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
					
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
					
					}else if($order_type=='WALLETONLINE'){
						
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
						$sel23="select * from tbl_user where id='$user_id'";
						$res23=mysqli_query($conn,$sel23);
						$data2=mysqli_fetch_assoc($res23);
						$amount2=$data2['wallet'];
						
						mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
						$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
					
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
					}


					$output['order_id']=$order_iddd;
					$output['res']='success';
					$output['msg']='Order Placed Successfully !';

				     }else{
					$output['res']='error';
					$output['msg']='No product in cart !';
					 }
				}
			}
			echo json_encode($output);
			break;
			case 'AdminOrder':
			 $user_id=$_POST['user_id'];
			 $address_id=$_POST['address_id'];
			 $product_id=$_POST['product_id'];
			 $total_price=$_POST['total_price'];
			 $order_id=$_POST['order_id'];
			 $order_type=$_POST['order_type'];
			  $pay_status="false";
			 if($order_type=='CASH'){
			   $pay_status="true";
			 }else if($order_type=='WALLET'){
			   $pay_status="true";
			 }else if($order_type=='WALLETCASH'){
			   $pay_status="true";
			 }else if($order_type=='RazorPay'){
			   $pay_status="false";
			 }else if($order_type=='Paytm'){
			   $pay_status="false";
			 }else if($order_type=='WALLETONLINE'){
			   $pay_status="false";
			 }
			 
			 $orderResponse=0;
			 
			 if(empty($total_price)||empty($user_id)){
				$output['res']='error';
				$output['msg']='Feild Required';
				$output['data']=[];
			}else{
				$total=0;
				
			            $ad="select * from address where id='$address_id'";
						$res_ad=mysqli_query($conn,$ad);
				          $add=mysqli_fetch_assoc($res_ad);
						  
					
						  $pdddd="select * from seller_product where id='$product_id'";
						  $res_pro=mysqli_query($conn,$pdddd);
				          $pro=mysqli_fetch_assoc($res_pro);
						  
						  $address_full=json_encode($add);
			             $query_for_id="insert into admin_orders (user_id,address_id,product_id,total_price,order_type,pay_status,date,time,status) values ('$user_id','$address_full','$product_id','$total_price','$order_type','$pay_status','$date','$time','0')";
			      
				        $response=mysqli_query($conn,$query_for_id);
						// var_dump($conn);
						
						$sel="select * from admin_orders where user_id='$user_id' order by id desc limit 1";
						$res=mysqli_query($conn,$sel);
						$order_idd='';
						if($order_type=='WALLET'){
							
						
							 $sel23="select * from tbl_user where id='$user_id'";
							 $res23=mysqli_query($conn,$sel23);
							 $data2=mysqli_fetch_assoc($res23);
							 $amount2=$data2['wallet'];
							 
							 $amount2=(int)$amount2-(int)$total_price;
					 
					 
								mysqli_query($conn,"update tbl_user set  wallet='$amount2' where id='$user_id'");
								$msg="Your wallet is debited of ₹".$total_price." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$total_price','$msg','Debit','User','$date','$time')");
						
						 }else if($order_type=='WALLETCASH'){
							
							
							  $sel23="select * from tbl_user where id='$user_id'";
							 $res23=mysqli_query($conn,$sel23);
							 $data2=mysqli_fetch_assoc($res23);
							 $amount2=$data2['wallet'];
							 
							 // $amount2=(int)$total_price-(int)$amount2;
					 
								mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
								$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
						
						 }else if($order_type=='WALLETONLINE'){
							
							 
							$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$user_id'");
							 
							  $sel23="select * from tbl_user where id='$user_id'";
							 $res23=mysqli_query($conn,$sel23);
							 $data2=mysqli_fetch_assoc($res23);
							 $amount2=$data2['wallet'];
							 
							 // $amount2=(int)$total_price-(int)$amount2;
					 
								mysqli_query($conn,"update tbl_user set  wallet='0' where id='$user_id'");
								$msg="Your wallet is debited of ₹".$amount2." For Order Products !";
						
						$check=mysqli_query($conn,"insert into txn_tbl (txn_id,user_id,amount,msg,txn_type,user_type,date,time) values ('1234567890','$user_id','$amount2','$msg','Debit','User','$date','$time')");
					   }
						
						
						if(mysqli_num_rows($res)>0)
						{
							$data=mysqli_fetch_assoc($res);
							
							$output['order_id']=$data['id'];
							
							$order_idd=$data['id'];
							$dates=str_replace("-","",$dat);
							$order_iddd="";
							if($order_type=='WALLET'){
							$order_iddd="WAL-".$dates."-".$order_idd;
							}else if($order_type=='CASH'){
								$order_iddd="COD-".$dates."-".$order_idd;
							}else if($order_type=='WALLETCASH'){
								$order_iddd="WALC-".$dates."-".$order_idd;
							}else if($order_type=='WALLETONLINE'){
								$order_iddd="WALO-".$dates."-".$order_idd;
							}else{
								$order_iddd="ONL-".$dates."-".$order_idd;
							}
							mysqli_query($conn,"update admin_orders set order_id='$order_iddd' where id='$order_idd'");
						}
						
						mysqli_query($conn,"update tbl_user set  m_status='true' where id='$user_id'");
						$output['res']='success';
						$output['msg']='Order Placed Successfully !';
					
			}
			echo json_encode($output);
			break;
			case 'MyOrders';
			$user_id=$_POST['user_id'];
			$result=[];
			$sel="select * from Orders where user_id='$user_id' and  (order_type='CASH' OR order_type='WALLET' or (order_type='RozarPay' and pay_status='true') or (order_type='Paytm' and pay_status='true')) order by id desc";
			$res=mysqli_query($conn,$sel);
			// var_dump($conn);
			if(mysqli_num_rows($res)>0)
			{
			
				while($row=mysqli_fetch_assoc($res))
				{      
			       $p_id=$row['product_id'];
				   $id=explode(',',$p_id);
			       $sel1="select * from product_images where product_id='$p_id' limit 1";
			       $res1=mysqli_query($conn,$sel1);
				   $dat=mysqli_fetch_assoc($res1);
				   $row['image']=$dat['image'];
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
			}
			echo json_encode($output);
			break;
				case 'MyUpgradeOrders';
			$user_id=$_POST['user_id'];
			$result=[];
			$sel="select * from admin_orders where user_id='$user_id' and  pay_status='true' order by id desc";
			$res=mysqli_query($conn,$sel);
			// var_dump($conn);
			if(mysqli_num_rows($res)>0)
			{
			
				while($row=mysqli_fetch_assoc($res))
				{      
			       $p_id=$row['product_id'];
				   $boy_id=$row['delivery_boy'];
				   $delivery_boy_status=$row['delivery_boy_status'];
				   // $id=explode(',',$p_id);
				if($boy_id!=''){
				    $check="select * from tbl_deliveryboy where id='$boy_id'";
			       $rescheck=mysqli_query($conn,$check);
				   $data=mysqli_fetch_assoc($rescheck);
				    $row['del_name']=$data['name'];
				    $row['del_mobile']=$data['mobile'];
			    }else{
					 $row['del_name']="";
				}
			       $sel1="select * from seller_product where id='$p_id'";
			       $res1=mysqli_query($conn,$sel1);
				   $dat=mysqli_fetch_assoc($res1);
				   $row['name']=$dat['name'];
				   $row['image']=$dat['image'];
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
			}
			echo json_encode($output);
			break;
			case 'Details';
			$order_id=$_POST['order_id'];
			$user_id=$_POST['user_id'];
			$result=[];
			$sel="select * from Orders where id='$order_id'";
			$res=mysqli_query($conn,$sel);
			if(mysqli_num_rows($res)>0){
						$data=mysqli_fetch_array($res);
						//var_dump($data);
						$output['res']='success';
						$output['msg']='Data 100% Loaded';
						$i=0;
						$p=$data['product_id'];
						$v=$data['variant_id'];
						$c_id=$data['coupon_id'];
						$q=$data['qty'];
						$u_id=array();
						$qty=array();
					    $u_id=explode(",",$p);
					    $qty=explode(",",$q);
					    $v_id=explode(",",$v);
					    
						$output['details']=$data;
						
						$boy_id=$data['delivery_boy'];
						$slot=$data['slots'];
						if($slot!=""){
						$slots=explode("Date",$slot);
						$slot_id=$slots[1];
						// $sel12="select * from vendor where id='$vendor_id'";
						// $ressss2=mysqli_query($conn,$sel12);
						// if(mysqli_num_rows($ressss2)>0){
							// $vendor=mysqli_fetch_array($ressss2);
							// $follow='false';
							// $sel123="select * from tbl_follow where user_id='$user_id' and friend_id='$vendor_id'";
						    // $ressss23=mysqli_query($conn,$sel123);
							// if(mysqli_num_rows($ressss23)>0){
								// $follow='true';
							// }
							// $vendor['follow']=$follow;
							// $output['vendor']=$vendor;
						// }else{
							// $output['vendor']="";
						// }
						
						$slo="select * from slot where id='$slot_id'";
						$re=mysqli_query($conn,$slo);
						if(mysqli_num_rows($re)>0){
							
							$sl=mysqli_fetch_array($re);
							$output['slot_data']=$sl['order_from']." To ".$sl['order_to'];
						}
						
						}else{
							$output['slot_data']="";
						}
						
						$sel123="select * from tbl_deliveryboy where id='$boy_id'";
						$ressss23=mysqli_query($conn,$sel123);
						$delivery_boy=array();
						if(mysqli_num_rows($ressss23)>0){
							
							$delivery_boy=mysqli_fetch_array($ressss23);
							$output['delivery_details']=$delivery_boy;
							$output['delivery_status']="yes";
						}else{
							$output['delivery_status']="no";
							$output['delivery_details']=[];
						}
						
						$sel1="select * from coupon where id='$c_id'";
						$ressss=mysqli_query($conn,$sel1);
						$delivery=array();
						if(mysqli_num_rows($ressss)>0){
							
							$delivery=mysqli_fetch_array($ressss);
							$output['coupon_details']=$delivery;
							$output['coupon_status']="yes";
						}else{
							$output['coupon_status']="no";
							$output['coupon_details']=[];
						}
						
			           $data1=array();
						while($i<sizeof($u_id)){
							$value=(int)$i;
							$p=$u_id[$value];
							$q=$qty[$value];
							$v_ids=$v_id[$value];
							
							$val=mysqli_query($conn,"SELECT * FROM product where id ='$p'");
							$val1=mysqli_fetch_assoc($val);
							
							$subCat="select * from tbl_subcategory where id='".$val1['sub_category']."'";
							$subCatRes=mysqli_query($conn,$subCat);
							$subCatData=mysqli_fetch_assoc($subCatRes);
					
							$taxQ="select * from tbl_tax where id='".$subCatData['tax_id']."'";
							$taxR=mysqli_query($conn,$taxQ);
							
							if(mysqli_num_rows($taxR)>0){
								$taxD=mysqli_fetch_assoc($taxR);
								$val1['tax_percentage']=$taxD['percentage']."";
								$val1['tax_name']=$taxD['title']."";
							}else{
								$val1['tax_percentage']="no";
								$val1['tax_name']="no";
							}
					
					
							$img=mysqli_query($conn,"SELECT * FROM product_images where product_id ='$p' limit 1");
							$img1=mysqli_fetch_assoc($img);
							
							$detail=mysqli_query($conn,"SELECT * FROM tbl_product_details where product_id ='$p' and id='$v_ids'");
							$detail1=mysqli_fetch_assoc($detail);
							
								$unit_id=$detail1['unit'];
                    					$sel22="select * from tbl_unit where id='$unit_id'";
                    			        $res22=mysqli_query($conn,$sel22);
                    					$dat22=mysqli_fetch_assoc($res22);
					
					
					$detail1['unit']=$dat22['name'];
					
							$val1['image']=$img1['image'];
							$val1['qty']=$q;
							$data1=array_merge($detail1,$val1);
							$output['data'][$i]=$data1;
							$i++;
						}
						echo json_encode($output);
			}
			else
			{
				$output['res']='error';
				$output['msg']='data not found';
				$output['data']=[];
				
			echo json_encode($output);
			}
			break;
			case 'Cancel';
			$order_id=$_POST['order_id'];
			$user_id=$_POST['user_id'];
			$type=$_POST['type'];
			$result=[];
			$sel="";
			if($type=="admin"){
				$sel="select * from admin_orders where id='$order_id'";
			}else{
			$sel="select * from Orders where id='$order_id'";
			}
			$res=mysqli_query($conn,$sel);
			if(mysqli_num_rows($res)>0)
			{
				$s="";
				if($type=="admin"){
				$s=mysqli_query($conn,"Update admin_orders set status='2' where id='$order_id'");
				mysqli_query($conn,"update tbl_user set  m_status='false' where id='$user_id'");
				}else{
					$s=mysqli_query($conn,"Update Orders set status='2' where id='$order_id'");
				}
				if($s){
					
				$output['res']='success';
				$output['msg']='Order Cancelled';
				$output['data']=$result;
				}else{
				$output['res']='error';
				$output['msg']='Something went wrong';
				$output['data']=$result;
				}
				
			}
			else
			{
				$output['res']='error';
				$output['msg']='You can not cancel this items';
				$output['data']=[];
			}
			echo json_encode($output);
			break;
			
			case 'ChangeStatus';
			$user_id=$_POST['order_id'];
			$u_id=$_POST['user_id'];
			$type=$_POST['type'];
			$result=[];
			$sel="";
			if($type=='upgrade'){
			$sel="select * from admin_orders where id='$user_id'";
			}else{
			 $sel="select * from Orders where id='$user_id'";
			}
			$res=mysqli_query($conn,$sel);
			
			if(mysqli_num_rows($res)>0)
			{
				if($type=='upgrade'){
					$s=mysqli_query($conn,"Update admin_orders set pay_status='true' where id='$user_id'");
					$output['res']='success';
						$output['msg']='Order Sucess';
						$output['data']=$result;
				}else{
					
				
					$s=mysqli_query($conn,"Update Orders set pay_status='true' where id='$user_id'");
					if($s){
						$vol=mysqli_query($conn,"delete from tbl_cart where user_id='$u_id'");
						
					
						$output['res']='success';
						$output['msg']='Order Sucess';
						$output['data']=$result;
				     }else{
					$output['res']='error';
					$output['msg']='Something went wrong';
					$output['data']=$result;
					}
				}
				
			}
			else
			{
				$output['res']='error';
				$output['msg']='Order Not Found';
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
	
<?php
	    require "connect.php";
	
		if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
		// $flag="Get";
	   
		switch($flag){
			case 'Add':
			$user_id=$_POST['user_id'];
			$product_id=$_POST['product_id'];
			$varient_id=$_POST['variant_id'];
			$qty=$_POST['qty'];
			
			//$id='3';
			$result=[];
			if(empty($user_id)){
				$output['res']='error';
				$output['msg']='Field Required';
				$output['data']=[];
			}else{
				$check=mysqli_query($conn,"select * from tbl_cart where  user_id='$user_id' and product_id='$product_id'  and variant_id='$varient_id'");
				
				$sel=mysqli_query($conn,"SELECT * FROM `tbl_product_details` where product_id='$product_id' and id='$varient_id'");
				$data=mysqli_fetch_assoc($sel);
				$stock=$data['stock'];
				// var_dump($stock);
				if(mysqli_num_rows($check)>0){
					
					if($qty=='0'){
						$res1="delete from `tbl_cart` WHERE `user_id`='$user_id' and product_id='$product_id'  and variant_id='$varient_id' ";
						if(mysqli_query($conn,$res1)){
							$output['res']='success';
							$output['msg']='Cart Data Updated';
							$output['data']=[];
						}else{
							$output['res']='error';
							$output['msg']='Item Not Updated';
							$output['data']=[];
						}
					}else{
						if($stock>=$qty){
							// $order_limit=$data['order_limit'];
							// if($order_limit>=$qty){
								$res1="UPDATE `tbl_cart` SET `qty`='$qty' WHERE `user_id`='$user_id' and product_id='$product_id'  and variant_id='$varient_id'";
								if(mysqli_query($conn,$res1)){
									$output['res']='success';
									$output['msg']='Cart Data Updated';
									$output['data']=[];
								}else{ 
									$output['res']='error';
									$output['msg']='Item Not Updated';
									$output['data']=[];
								}
							// }else{
								// $output['res']='error';
								// $output['msg']='Maximum '.$order_limit.' Qty Allowed in Shopping Cart';
								// $output['data']=[];
							// }
						}else{
							$output['res']='error';
							$output['msg']=$varient_id;
							$output['data']=[];
						}
					}
				}else{
					
					if($stock>=$qty){
						$query="insert into tbl_cart (user_id,product_id,variant_id,qty) values ('$user_id','$product_id','$varient_id','$qty')";
						// var_dump($query);
						if(mysqli_query($conn,$query)){
							$output['res']='success';
							$output['msg']='Item Added to Cart';
							$output['data']=[];
						}else{
							$output['res']='error';
							$output['msg']='Item Not Added';
							$output['data']=[];
						}
					}else{
						$output['res']='error';
						$output['msg']=$varient_id;
						$output['data']=[];
					}
				}
			}
			echo json_encode($output);
			break;
			
			case 'Get':
			$user_id=$_POST['user_id'];
			$result=[];
			$sel="select * from tbl_cart where user_id='$user_id'";
			$res=mysqli_query($conn,$sel);
			// var_dump($res);
			if(mysqli_num_rows($res)>0)
			{       
				$output['res']='success';
				$output['msg']='Data 100% Loaded';
				$i=0;
				$data1=array();
				
				while($row=mysqli_fetch_assoc($res))
				{   $data=$row;
					$l_id=$data['product_id'];
					$v_id=$data['variant_id'];
					
					$val=mysqli_query($conn,"SELECT * FROM `product` WHERE `id`='$l_id'");
					
					if($val){
						$val1=mysqli_fetch_assoc($val);
					
						$c_id=$val1['category'];
					$sub_id=$val1['sub_category'];
					$brand_id=$val1['brand'];
					$p_id=$val1['id'];
					$sel1="select * from tbl_category where id='$c_id'";
			        $res1=mysqli_query($conn,$sel1);
					$dat=mysqli_fetch_assoc($res1);
					
					$row['category_name']=$dat['name'];
					
					$sel00="select * from tbl_subcategory where id='$sub_id'";
			        $res00=mysqli_query($conn,$sel00);
					$dat00=mysqli_fetch_assoc($res00);
					$row['sub_category']=$dat00['name'];
					
					$sel000="select * from tbl_brands where id='$brand_id'";
			        $res000=mysqli_query($conn,$sel000);
					$dat000=mysqli_fetch_assoc($res000);
					$row['brand']=$dat000['name'];
					
					$taxQ="select * from tbl_tax where id='".$dat00['tax_id']."'";
			        $taxR=mysqli_query($conn,$taxQ);
					
					if(mysqli_num_rows($taxR)>0){
						$taxD=mysqli_fetch_assoc($taxR);
						$row['tax_percentage']=$taxD['percentage']."";
						$row['tax_name']=$taxD['title']."";
					}else{
						$row['tax_percentage']="no";
						$row['tax_name']="no";
					}
					$sel0000="select * from tbl_product_details where id='$v_id'";
			        $res0000=mysqli_query($conn,$sel0000);
					$dat0000=mysqli_fetch_assoc($res0000);
					
					$unit_id=$dat0000['unit'];
					$sel22="select * from tbl_unit where id='$unit_id'";
			        $res22=mysqli_query($conn,$sel22);
					$dat22=mysqli_fetch_assoc($res22);
					
					$row['model']=$dat0000['model'];
					$row['quantity']=$dat0000['quantity'];
					$row['unit']=$dat22['name'];
					$row['stock']=$dat0000['stock'];
					$row['mrp']=$dat0000['mrp'];
					$row['price']=$dat0000['price'];
					$row['discount']=$dat0000['discount'];
					$row['tax']=$dat0000['tax'];
					
					$sel0000="select * from product_images where product_id='$l_id' limit 1";
			        $res0000=mysqli_query($conn,$sel0000);
					$resul=[];
					// var_dump($res0000);
					if(mysqli_num_rows($res0000)>0){
						$rows=mysqli_fetch_assoc($res0000);
						$row['image']=$rows['image'];
					}
					
					
					$sel00000="select * from tbl_attribute where product_id='$l_id'";
			        $res00000=mysqli_query($conn,$sel00000);
					$resultt=[];
					if(mysqli_num_rows($res00000)>0){
						while($rows=mysqli_fetch_assoc($res00000)){
						array_push($resultt,$rows);
					   }
					}
					$row['attribute']=$resultt;
						
						$data1=array_merge($row,$val1);
						$output['data'][$i]=$data1;
						$i++;
					}					
				}
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
			$user_id=$_POST['id'];
			$result=[];
			$sel="delete from tbl_cart where c_id='$user_id'";
			$res=mysqli_query($conn,$sel);
			if($res)
			{
				
				$output['res']='success';
				$output['msg']='data Deleted';
				$output['data']=$result;
			}
			else
			{
				$output['res']='error';
				$output['msg']='data not deleted';
			}
			echo json_encode($output);
			break;
			case 'DeleteCart':
			$user_id=$_POST['id'];
			$result=[];
			$sel="delete from tbl_cart where user_id='$user_id'";
			$res=mysqli_query($conn,$sel);
			if($res)
			{
				
				$output['res']='success';
				$output['msg']='data Deleted';
				$output['data']=$result;
			}
			else
			{
				$output['res']='error';
				$output['msg']='data not deleted';
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
	
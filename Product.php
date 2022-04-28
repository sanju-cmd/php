<?php
	require 'connect.php';
	
	if(isset($_POST['flag'])){
		$flag=$_POST['flag'];  
		
		switch($flag){
			
			case 'product_details':
				$id=$_POST['id'];
				if(!empty($id)){
					$sql=mysqli_query($conn,"SELECT * FROM `product` WHERE id='$id' ");
					$data=mysqli_fetch_assoc($sql);
					if($data){
						$output['res']='success';
						$output['msg']='Data List';
						$output['data']=$data;
					}else{
						$output['res']='error';
						$output['msg']='Empty Data';
					}
				}else{
					$output['res']='error';
					$output['msg']='Empty Id';
				}
			echo json_encode($output);
			break;
			
			
			case 'product_variant':
				 $id=$_POST['id']; 
				$result=[]; 
				if(!empty($id)){
					$sql=mysqli_query($conn,"SELECT * FROM `tbl_product_details` WHERE product_id='$id' ");
					 $data=mysqli_num_rows($sql);
					if($data>0){
						while($list=mysqli_fetch_assoc($sql)){
							array_push($result,$list);
						}
						$output['res']='success';
						$output['msg']='Data List';
						$output['data']=$result;
					}else{
						$output['res']='error';
						$output['msg']='Empty Data';
					}
				}else{
					$output['res']='error';
					$output['msg']='Empty Id';
				}
			echo json_encode($output);
			break;
			case 'product_images':
				$id=$_POST['id'];
				$result=[];
				if(!empty($id)){
					$sql=mysqli_query($conn,"SELECT * FROM `product_images` WHERE product_id='$id' ");
					$data=mysqli_num_rows($sql);
					if($data>0){
						while($list=mysqli_fetch_assoc($sql)){
							array_push($result,$list);
						}
						$output['res']='success';
						$output['msg']='Data List';
						$output['data']=$result;
					}else{
						$output['res']='error';
						$output['msg']='Empty Data';
					}
				}else{
					$output['res']='error';
					$output['msg']='Empty Id';
				}
			echo json_encode($output);
			break;
			case 'product_details_update':
				$id=$_POST['id'];
				$name=$_POST['name'];
				$category=$_POST['category'];
				$sub_category=$_POST['sub_category'];
				$brand=$_POST['brand'];
				$meta_tag_title=$_POST['meta_tag_title'];
				$meta_tag_description=$_POST['meta_tag_description'];
				$meta_tag_keywords=$_POST['meta_tag_keywords'];
				$product_tags=$_POST['product_tags'];
				$sdescription=$_POST['sdescription'];
				if(!empty($id) and !empty($name) and !empty($category) and !empty($sub_category) and !empty($brand) and !empty($meta_tag_title) and !empty($meta_tag_description) and !empty($meta_tag_keywords) and !empty($product_tags) and !empty($sdescription)){
					$sql=mysqli_query($conn,"UPDATE `product` SET `name`='$name',`category`='$category',`sub_category`='$sub_category',`brand`='$brand',`meta_tag_title`='$meta_tag_title',`meta_tag_description`='$meta_tag_description',`meta_tag_keywords`='$meta_tag_keywords',`product_tags`='$product_tags',`sdescription`='$sdescription',`del_status`='false',`status`='true',`date`='$date',`time`='$time' WHERE id='$id'");
					if($sql){
						$output['res']='success';
						$output['msg']='Update Successfully';
					}else{
						$output['res']='error';
						$output['msg']='Network Problem';
					}
				}else{
					$output['res']='error';
					$output['msg']='Empty Data';
				}
				echo json_encode($output);
			break;
			
			case 'product_variant_update':
				$id=$_POST['id'];
				$product_id=$_POST['product_id'];
				$model=$_POST['model'];
				$quantity=$_POST['quantity'];
				$unit=$_POST['unit'];
				$stock=$_POST['stock'];
				$mrp=$_POST['mrp'];
				$price=$_POST['price'];
				$discount=$_POST['discount'];
				$tax=$_POST['tax'];
				$order_limit=$_POST['order_limit'];
				
					if(!empty($id) and !empty($product_id) and !empty($model) and !empty($quantity) and !empty($unit) and !empty($stock) and !empty($mrp) and !empty($price) and !empty($discount) and !empty($tax) and !empty($order_limit)){
					
					$sql=mysqli_query($conn,"UPDATE `tbl_product_details` SET `model`='$model',`quantity`='$quantity',`unit`='$unit',`stock`='$stock',`mrp`='$mrp',`price`='$price',`discount`='$discount',`tax`='$tax',`order_limit`='$order_limit',`date`='$date',`time`='$time' WHERE id='$id' and product_id='$product_id'");
					if($sql){
						$output['res']='success';
						$output['msg']='Update Successfully';
					}else{
						$output['res']='error';
						$output['msg']='Network Problem';
					}
					
				}else{
					$output['res']='error';
					$output['msg']='Empty Data';
				}
				echo json_encode($output);
				
			break;	
			
			case 'product_images_update':
				$id=$_POST['id'];
				$product_id=$_POST['product_id'];
				$image=$_POST['image'];
				if(!empty($id) and !empty($product_id)){
					
					$id=explode(",",$id);
					$product_id=explode(",",$product_id);
					$images=explode("ZPS",$image);
					
					for($i=0;$i<sizeof($images);$i++){
						
						// $UserImage = str_replace('data:image/png;base64,', '',$images[$i] );
						// $UserImage = str_replace(' ', '+', $UserImage);
						// $data1 = base64_decode($UserImage);
						// $UserImage1="Product_".date('YHis').rand(1000,9999). '.jpg';
						// $file1 = 'uploads/products/' . $UserImage1;
						// file_put_contents($file1, $data1);
						
						$sql=mysqli_query($conn,"DELETE  FROM `product_images`WHERE id='".$id[$i]."' and product_id='".$product_id[$i]."'");
						
					}
					
					$output['res']='success';
					$output['msg']='Update Successfully';
					
				}else{
					$output['res']='error';
					$output['msg']='Empty Data';
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
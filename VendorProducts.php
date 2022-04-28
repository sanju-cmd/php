<?php
	require 'connect.php';
	
	if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
		// $flag="getKYC";
		switch($flag){
			case 'AddProduct':
			$result=[];
			$id=$_POST['id'];
			$c_id=$_POST['c_id'];
			$sub_category=$_POST['sub_category'];
			$name=$_POST['name'];
			$short_description=$_POST['short_description'];
			$meta_tag_title=$_POST['meta_tag_title'];
			$meta_tag_description=$_POST['meta_tag_description'];
			$meta_tag_keywords=$_POST['meta_tag_keywords'];
			$product_tags=$_POST['product_tags'];
			$brand=$_POST['brand'];
			
			$numb=rand(00000,999999);
			
			if(empty($id)){
                $output['res']='error';
				$output['msg']='Field Required';
            }
            else{
				
					
				$sel="insert into product (vendor_id,name,category,sub_category,brand,meta_tag_title,meta_tag_description,meta_tag_keywords,product_tags,sdescription,del_status,status,date,time) values ('$id','$name','$c_id','$sub_category','$brand','$meta_tag_title','$meta_tag_description','$meta_tag_keywords','$product_tags','$short_description','false','true','$date','$time')";
				$res=mysqli_query($conn,$sel);
				if($res)
				{
					$query="SELECT * FROM `product` order by id desc limit 1";
					$resss=mysqli_query($conn,$query);
					if(mysqli_num_rows($resss)>0){
						$idd=mysqli_fetch_assoc($resss);
						$id=$idd['id'];
						
						$catCheck="SELECT * FROM `tbl_category` where id='$c_id'";
					    $catRes=mysqli_query($conn,$catCheck);
						$catData=mysqli_fetch_assoc($catRes);
						
						$SubCheck="SELECT * FROM `tbl_subcategory` where id='$sub_category'";
					    $SubRes=mysqli_query($conn,$SubCheck);
						$SubData=mysqli_fetch_assoc($SubRes);
					
					    $code=strtoupper($catData['name'][0])."".strtoupper($SubData['name'][0]).$numb.$id;
						
						$update="update `product` set product_code='$code' where id='$id'";
					    mysqli_query($conn,$update);
						
						$output['res']='success';
						$output['msg']='data found';
						$output['id']=$id;
					}else{
						$output['res']='success';
						$output['msg']='data found';
						$output['id']=$id;
					}
				}
				else
				{
					$output['res']='error';
					$output['msg']='data not found';
					$output['data']=[];
				}
			}
			echo json_encode($output);
			break;
			case 'AddProduct1':
			$result=[];
			$id=$_POST['id'];
			$model=$_POST['model'];
			$order_limit=$_POST['order_limit'];
			$quantity=$_POST['quantity'];
			$unit=$_POST['unit'];
			$stock=$_POST['stock'];
			$mrp=$_POST['mrp'];
			$price=$_POST['price'];
			$discount=$_POST['discount'];
			$tax=$_POST['tax'];
			$image=$_POST['images'];
			
			
			if(empty($id)){
                $output['res']='error';
				$output['msg']='Field Required';
            }
            else{
				
					
				$sel="insert into tbl_product_details (product_id,model,quantity,unit,stock,mrp,price,discount,tax,order_limit,date) values ('$id','$model','$quantity','$unit','$stock','$mrp','$price','$discount','$tax','$order_limit','$date')";
				$res=mysqli_query($conn,$sel);
				if($res)
				{
					
					$output['res']='success';
					$output['msg']='data found';
					$output['id']="";
				
				}
				else
				{
					$output['res']='error';
					$output['msg']='data not found';
					$output['data']=[];
				}
			}
			echo json_encode($output);
			break;
			case 'img_upload':
				$id=$_POST['id'];
				$image=$_POST['images'];
				$images=explode('ZPS',$image);
				$img="";
				// var_dump($images);
				for($i=0;$i<sizeof($images);$i++){
					$UserImage = str_replace('data:image/png;base64,', '',$images[$i] );
					$UserImage = str_replace(' ', '+', $UserImage);
					$data1 = base64_decode($UserImage);
					$UserImage1="Product_".date('YHis').rand(1000,9999). '.jpg';
					$file1 = 'uploads/products/' . $UserImage1;
					file_put_contents($file1, $data1);
					
					$sel="insert into product_images (product_id,image,date) values ('$id','$UserImage1','$date')";
					$res=mysqli_query($conn,$sel);
				}
				$output['res']='success';
				$output['msg']='data found';
				$output['id']="";
				echo json_encode($output);
			break;
			case 'AddProduct2':
			$result=[];
			$id=$_POST['id'];
			$name=$_POST['name'];
			$text=$_POST['text'];
		
			
			
			if(empty($id)){
                $output['res']='error';
				$output['msg']='Field Required';
            }
            else{
				
				
					$names=explode('ZPS',$name);
					$texts=explode('ZPS',$text);
					$img="";
					// var_dump($images);
					for($i=0;$i<sizeof($names);$i++){
						
						$sel="insert into tbl_attribute (product_id,name,text,date) values ('$id','$names[$i]','$texts[$i]','$date')";
						$res=mysqli_query($conn,$sel);
					}
						$output['res']='success';
						$output['msg']='data found';
						$output['id']="";
				
				
			}
			echo json_encode($output);
			break;
			
			case 'UpdateProduct':
			$result=[];
			$id=$_POST['id'];
			$c_id=$_POST['c_id'];
			$sub_category=$_POST['sub_category'];
			$name=$_POST['name'];
			$short_description=$_POST['short_description'];
			$image=$_POST['image'];
			$price=$_POST['price'];
			$offer_price=$_POST['offer_price'];
			$discount=$_POST['discount'];
			$stock=$_POST['stock'];
			$weight=$_POST['weight'];
			$unit=$_POST['unit'];
			$brand=$_POST['brand'];
			
			$sel="";
				if($image!=""){
					$images=explode('SHOPKIRANA',$image);
					$img="";
					// var_dump($images);
					for($i=0;$i<sizeof($images);$i++){
						$UserImage = str_replace('data:image/png;base64,', '',$images[$i] );
						$UserImage = str_replace(' ', '+', $UserImage);
						$data1 = base64_decode($UserImage);
						$UserImage1="Product_".date('YHis').rand(1000,9999). '.jpg';
						$file1 = 'uploads/products/' . $UserImage1;
						file_put_contents($file1, $data1);
						$UserImage1=$UserImage1;
						if($i==0){
							$img=$UserImage1;
						}else{
							$img=$img."SHOPKIRANA".$UserImage1;
						}
					}
					
					$sel="update product set name='$name',category='$c_id',sub_category='$sub_category',brand='$brand',mrp='$price',discount='$discount',price='$offer_price',stock='$stock',quantity='$weight',unit='$unit',sdescription='$short_description',del_status='false',image='$img',date='$date',time='$time' where id='$id'";
				}else{
						
					$sel="update product set name='$name',category='$c_id',sub_category='$sub_category',brand='$brand',mrp='$price',discount='$discount',price='$offer_price',stock='$stock',quantity='$weight',unit='$unit',sdescription='$short_description',del_status='false',date='$date',time='$time' where id='$id'";
				}
				$res=mysqli_query($conn,$sel);
				if($res)
				{
					$output['res']='success';
					$output['msg']='data found';
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
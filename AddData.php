<?php
	require 'connect.php';
	
	if(isset($_POST['flag'])){
		$flag=$_POST['flag'];
		// $flag="Wishlist";
		switch($flag){
			case 'Wishlist':
			$result=[];
			
			$user_id=$_POST['user_id'];
			$p_id=$_POST['product_id'];
			$check="select * from wishlist where user_id='$user_id' and product_id='$p_id'";
			$checkres=mysqli_query($conn,$check);
			
			if(mysqli_num_rows($checkres)>0){
				$sel="delete from wishlist where user_id='$user_id' and product_id='$p_id'";
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
			}else{
				$sel="insert into wishlist(user_id,product_id,date_time) values ('$user_id','$p_id','$date')";
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
			}
			echo json_encode($output);
			break;
			
			case 'Category':
			$result=[];
			$sel="select * from category  where del_status='false' ORDER BY `id` DESC";
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
			
			case 'Vendors':
			$result=[];
			$sel="select * from shop  where otp_status='true' and status='true' and del_status='false' ORDER BY `id` DESC";
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
			
			case 'Products':
			$result=[];
			$cat_id=$_POST['c_id'];
			$sel="";
			if($cat_id=='All'){
				$sel="select * from product  where   del_status='false' and status='approved' ORDER BY `id` DESC";
			}else{
			$sel="select * from product  where   category = '$cat_id' and del_status='false' and status='approved' ORDER BY `id` DESC";
			}
			$res=mysqli_query($conn,$sel);
			if(mysqli_num_rows($res)>0)
			{
				while($row=mysqli_fetch_assoc($res))
				{
					$c_id=$row['c_id'];
					$sel1="select * from category ORDER BY `id` DESC";
			        $res1=mysqli_query($conn,$sel1);
					$dat=mysqli_fetch_assoc($res1);
					$row['category']=$dat['name'];
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
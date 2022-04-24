<?php 

	require '../init.php';
	error_reporting(0);
	$flag=$_REQUEST['flag'];

	switch ($flag) 
	{
		
		
			
			case 'Delete':
            $id = $_POST['id'];
            $column = $_POST['column'];
            $value = $_POST['value'];
            $table = $_POST['table'];
            if(empty($id) or empty($column) or empty($value) or empty($table)){
                echo json_encode(array('res' =>'error' ,'msg'=>'Data require'));
            }
            else{
                $res=$source->Query("UPDATE `$table` SET `$column`=? WHERE `id`=?",[$value,$id]);
               
                if($res){
                    echo "Success";
                }
                else{
                    echo "Failed";
                }
            }
            break;
            case 'Update':
                $id = $_POST['id'];
                $column = $_POST['column'];
                $value = $_POST['value'];
                $table = $_POST['table'];
                if(empty($id) or empty($column) or empty($value) or empty($table)){
                    echo json_encode(array('res' =>'error' ,'msg'=>'Data require'));
                }
                else{
                    $res=$source->Query("UPDATE `$table` SET `$column`=? WHERE `id`=?",[$value,$id]);
                   
                    if($res){
                        echo "Success";
                    }
                    else{
                        echo "Failed";
                    }
                }
                break;
			
           
                case 'Status':
                    $id = $_POST['id'];
                    $column = $_POST['column'];
                    $value = $_POST['value'];
                    $table = $_POST['table'];
                    if(empty($id) or empty($column) or empty($value) or empty($table)){
                        echo "Success";
                    }
                    else{
                       
                        $res=$source->Query("UPDATE `$table` SET `$column`='$value' WHERE `id`='$id'");
                        if($res){
                            echo "Success";
                        }
                        else{
                            echo "Falied";
                        }
                    }
                break;
		

		default:
			# code...
			break;
	}







 ?>
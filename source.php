<?php 
class source extends db {

    public $Query;
    
    public function Query($query, $param = [])
    {
        if(empty($param))
        {
            $this->Query = $this->db->prepare($query);
            return $this->Query->execute();
        }
        else 
        {
            $this->Query = $this->db->prepare($query);
            return $this->Query->execute($param);
        }
    }


    public function CountRows()
    {
        return $this->Query->rowCount();
    }

    public function LastId()
    {
        return $this->db->lastInsertId();
    }

    
    public function FetchAll()
    {
        return $this->Query->fetchAll(PDO::FETCH_OBJ);
    }

    
    public function Single()
    {
        return $this->Query->fetch(PDO::FETCH_OBJ);
    }


    public $Query1;
    public function Query1($query, $param = [])
    {
        if(empty($param))
        {
            $this->Query1 = $this->db->prepare($query);
            return $this->Query1->execute();
        }
        else 
        {
            $this->Query1 = $this->db->prepare($query);
            return $this->Query1->execute($param);
        }
    }

    public function NumRows()
    {
        return $this->Query1->rowCount();
    }

    public function LastInset()
    {
        return $this->db->lastInsertId();
    }

    
    public function FetchAllData()
    {
        return $this->Query1->fetchAll(PDO::FETCH_OBJ);
    }

    
    public function SingleData()
    {
        return $this->Query1->fetch(PDO::FETCH_OBJ);
    }
	
	 public $Query2;
    public function Query2($query, $param = [])
    {
        if(empty($param))
        {
            $this->Query2 = $this->db->prepare($query);
            return $this->Query2->execute();
        }
        else 
        {
            $this->Query2 = $this->db->prepare($query);
            return $this->Query2->execute($param);
        }
    }

    public function NumRows1()
    {
        return $this->Query2->rowCount();
    }

    public function LastInset1()
    {
        return $this->db->lastInsertId();
    }

    
    public function FetchAllData1()
    {
        return $this->Query2->fetchAll(PDO::FETCH_OBJ);
    }

    
    public function SingleData1()
    {
        return $this->Query2->fetch(PDO::FETCH_OBJ);
    }



}

?>
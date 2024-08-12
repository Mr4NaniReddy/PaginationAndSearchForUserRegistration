<?php 

require_once 'Database.php';

class User extends Database{
    protected $tableName = 'newusers';

    // funtion to add users

    public function add($data){
        if(!empty($data)){
            $fileds = $placeholders = [];
            foreach ($data as $field => $value){
                $fileds[] = $field;
                $placeholders[] = ":{$field}"; 
            }
        }

        $sql = "INSERT INTO {$this->tableName} (".implode(',',$fileds).") VALUES (". implode(',',$placeholders).")";

        $stmt = $this->conn->prepare($sql);

        try{
            $this->conn->beginTransaction();
            $stmt->execute($data);
            $lastInsertedId = $this->conn->lastInsertId();
            $this->conn->commit();
            return $lastInsertedId;
            
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
            $this->conn->rollBack();
        }
    
    }




    // function to get rows
    public function getRows($start=0, $limit=5){
        $sql = "SELECT * FROM {$this->tableName} ORDER BY id DESC LIMIT {$start}, {$limit}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else{
            $results = [];
        }
        return $results;

    }


    // function to get single row
    public function getRow($field, $value) {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = :value";
        $stmt = $this->conn->prepare($sql);
        // $stmt->bindParam(':value', $value);
        // $stmt->execute();
        $stmt->execute([':value' => $value]);

    
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;
    }
    
    

    // function to count number of rows

    public function getCount(){
        $sql = "SELECT count(*) as pcount FROM {$this->tableName}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pcount'];
    }

    // function to update

    public function update($data, $id){
        if(!empty($data)){
            $fields = "";
            $x = 1;
            $fieldsCount = count($data);
            foreach($data as $field => $value){
                $fields.= "{$field}=:{$field}";
                if($x<$fieldsCount){
                    $fields .= ",";
                }
                $x++;
            }
        }
        $sql = "UPDATE {$this->tableName} SET {$fields} where id=:id";

        $stmt = $this->conn->prepare($sql);
        try{
            $this->conn->beginTransaction();
            $data['id'] = $id;
            $stmt->execute($data);
            $this->conn->commit();
            
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
            $this->conn->rollBack();
        }
    }






    // function to delete
    public function deleteRow($id){
        $sql = "DELETE FROM {$this->tableName} WHERE id= :id";
        $stmt = $this->conn->prepare($sql);
        try{
            $stmt->execute([':id' => $id]);
            if($stmt->rowCount()>0){
                return true;
            }
        } catch(PDOException $e){
            echo 'Error'. $e->getMessage();
            return false;
        }
    }

    // function for search
    public function searchuser($searchText, $current_id, $start=0, $limit = 100){
        $colname = '';
        if($current_id == 'searchinputbyfirstname'){
            $colname = 'firstname';
        }else if($current_id == 'searchinputbylastname'){
            $colname = 'lastname';
        }else if($current_id == 'searchinputbyemail'){
            $colname = 'email';
        } else if($current_id =='searchinputbymobile'){
            $colname = 'mobile';
        }
        $sql = "SELECT * FROM {$this->tableName} 
        WHERE {$colname} LIKE :search 
        ORDER BY id DESC 
        LIMIT {$start}, {$limit}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':search'=> "{$searchText}%"]);
        if($stmt->rowCount()> 0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            $results = [];
        }
        return $results;
    }

    

    public function getRowToCheckEmailexist($field, $value, $userid) {
        $sql = "SELECT * FROM {$this->tableName} WHERE {$field} = :value and id != :userid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':value' => $value, ':userid' => $userid]);

    
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;
    }

    public function emailExists($email){
        $result = $this->getRow("email", $email);
        return !empty($result);
    }
    public function emailExistforupdate($email, $userid){
        $result = $this->getRowToCheckEmailexist("email", $email, $userid);
        return !empty($result);
    }

}

?>
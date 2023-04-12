<?php

class ItemManager {
	
    private $databaseConnection  = NULL;
    private $itemsTable  = '';

	function __construct($databaseConnection, $itemsTable)
	{
		$this->databaseConnection = $databaseConnection;
        $this->itemsTable = $itemsTable;
	}
    
//ajoute un nouvel élément à la table de base de données 
    public function addItemToDb($name, $description){		
		
        $stmt = $this->databaseConnection->prepare("
		INSERT INTO ".$this->itemsTable."(`name`, `description`)
		VALUES(?,?)");
	
        $stmt->bind_param("ss", $name, $description);
        
        if($stmt->execute()){
            return true;
        }
    
        return false;		 
    } 
    public function getAllItems(){		
		
        $stmt = $this->databaseConnection->prepare("
		SELECT * FROM ".$this->itemsTable);
        $rows = array();

        if($stmt->execute())
        {
            $res = mysqli_stmt_get_result($stmt);
            while ($r = mysqli_fetch_array($res, MYSQLI_NUM)){
                $rows[] = ["id" => $r[0], "name" => $r[1], "description" => $r[2]];
            }
        }

        return json_encode($rows);
       	 
    } 

    //requête préparée pour mettre à jour un élément existant dans la base de données
    public function modifyItemToDb($id, $name, $description)
    {
       
            $stmt = $this->databaseConnection->prepare("
                UPDATE " . $this->itemsTable . "
                SET `name`=?, `description`=?
                WHERE `id`=?");
        
            // Bind the input parameters to the prepared statement
            $stmt->bind_param("ssi", $name, $description, $id);
        
            // Execute the prepared statement and check if it was successful
            if ($stmt->execute()) {
                return true;
            }
        
            // If the execution failed, return false
            return false;
        
        
    }
    
    public function removeItemToDb($id)
    {
        //to implement ---> suppression item	
    }	

    
    
}
?>
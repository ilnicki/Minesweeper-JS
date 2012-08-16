<?php

Class MinesweeperProcessor
{
    private $db;
    private $todolist;
    private $pressedKey;
    private $data;
    private $coord;
    
    public $msg;
    
    public $fieldWidth = 5;
    public $fieldHeight = 5;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function putKey($key)
    {
        $this->pressedKey = $key;
        $this->todolist = new ToDoList();
    }
    
    public function calcResult()
    {
        $this->getPosition();
        
        $this->doCommand($this->pressedKey);
        
        $this->setPosition();
        
        $this->data['msg'] = $this->msg;
        $this->data['todo'] = $this->todolist->getList();
    }
    
    private function getPosition()
    {
        $result = $this->db->query("SELECT x_coord, y_coord FROM field WHERE changed=1");
        $this->coord = $result->fetch_assoc();
    }
    
    private function setPosition()
    {
        $this->db->query("UPDATE field SET changed =  '0' WHERE changed =  '1'");
        $this->db->query("UPDATE field SET changed =  '1'  WHERE x_coord = '".$this->coord['x_coord']."' AND y_coord = '".$this->coord['y_coord']."';");
    }
    
    private function switchFlag()
    {
        $cell = $this->db->query("SELECT status FROM field WHERE changed =  '1'")->fetch_assoc();
        
        if($cell['status'] == 0)
        {
            $this->db->query("UPDATE field SET status = '1' WHERE changed =  '1'");
            $this->todolist->addTask($this->coord['x_coord'], $this->coord['y_coord'], 'putFlag');
        }
        elseif($cell['status'] == 1)
        {
            $this->clearCell();
        }
        else
        {
            $this->msg .= '[WARNING]: Can not put flag into this cell.] '."\n";
        }
    }
    
    private function digCell()
    {
        $cell = $this->db->query("SELECT status FROM field WHERE changed =  '1'")->fetch_assoc();
        
        if($cell['status'] == 0 or $cell['status'] == 1)
        {
            $this->db->query("UPDATE field SET status = '2' WHERE changed =  '1'");
            $this->todolist->addTask($this->coord['x_coord'], $this->coord['y_coord'], 'digCell');
        }
    }
    
    private function doCommand($direction)
    {
        switch($direction)
        {
            case 'up':
                if(($this->coord['y_coord'] + 1) <= $this->fieldHeight)
                {
                    $this->coord['y_coord']++;
                }
                break;
                
            case 'down':
                if(($this->coord['y_coord'] - 1) > 0)
                {
                    $this->coord['y_coord']--;
                }
                break;
                
            case 'right':
                if(($this->coord['x_coord'] + 1) <= $this->fieldWidth)
                {
                    $this->coord['x_coord']++;
                }
                break;
                
            case 'left':
                if(($this->coord['x_coord'] - 1) > 0)
                {
                    $this->coord['x_coord']--;
                }
                break;
                
            case 'flag':
                $this->switchFlag();
                break;
            
            case 'dig':
                $this->digCell();
                break;
                
            case 'reset':
                $this->resetField();
                break;
                
            case 'refresh':
                $this->refreshAllCells();
                break;
                
            case 'load':
                $this->loadChangedCells();
                break;
                
            default:
                break;          
        }
        $this->todolist->addTask($this->coord['x_coord'], $this->coord['y_coord'], 'movePointer');
    }
    
    private function clearCell()
    {
        $this->db->query("UPDATE field SET status = '0' WHERE changed =  '1'");
        
        $this->todolist->addTask($this->coord['x_coord'], $this->coord['y_coord'], 'clearCell');
    }
    
    private function refreshAllCells()
    {
        $result = $this->db->query("SELECT x_coord, y_coord, status FROM  field LIMIT 0 , ".$this->fieldWidth * $this->fieldHeight);
        
        while($cell = $result->fetch_array(MYSQLI_ASSOC))
        {
            switch($cell['status'])
            {
                case 0:
                   $this->todolist->addTask($cell['x_coord'], $cell['y_coord'], 'clearCell');  
                   break;
                case 1:
                   $this->todolist->addTask($cell['x_coord'], $cell['y_coord'], 'putFlag');  
                   break;
            }
        }
    }
    
    private function loadChangedCells()
    {
        $result = $this->db->query("SELECT x_coord, y_coord, status FROM  field WHERE status != 0");
        
        while($cell = $result->fetch_array(MYSQLI_ASSOC))
        {
            switch($cell['status'])
            {
                case 1:
                   $this->todolist->addTask($cell['x_coord'], $cell['y_coord'], 'putFlag');  
                   break;
            }
        }
    }
    
    public function getResult()
    {
        return $this->data;
    }
    
    private function resetField()
    {
        $this->db->query("UPDATE field SET status = '0' WHERE status != '0'");
    }
    
    private function createFieldTable($width, $height)
    {
        for($i = $height; $i >= 1; $i--)
        {
            for($j = 1; $j <= $width; $j++)
            {
                $this->db->query("INSERT INTO `field` (`x_coord`, `y_coord`, `changed`, `status`) VALUES ('$j', '$i', '0', '0');");
            }
        }
    }

}
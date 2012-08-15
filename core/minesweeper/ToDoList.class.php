<?php

class ToDoList
{
    private $todolist;
    
    public function addTask($x, $y, $taskName, $additionalData = null)
    {
        $this->todolist[] = Array('x' => $x, 'y' => $y, 'taskName' => $taskName, 'data' => $additionalData,);
    }
    
    public function getList()
    {
        return $this->todolist;
    }
}
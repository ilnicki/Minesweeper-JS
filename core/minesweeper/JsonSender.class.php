<?php

Class JsonSender
{
    private $data;
    
    public function __construct()
    {
        header('Content-type: application/json');
    }
    
    public function putData($data)
    {
        $this->data = $data;
    }
    
    private function encode()
    {
        return json_encode($this->data);
    }
    
    public function send()
    {
        echo $this->encode();
    }
}
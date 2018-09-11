<?php
class ViewOptionModel {
    public function __construct($title, $class, $action){
        $this->title = $title;
        $this->class = $class;
        $this->action = $action;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getClass(){
        return $this->class;
    }

    public function getAction(){
        return $this->action;
    }
    
    private $title;
    private $class;
    private $action;
}
?>
<?php

class PreviousWork
{
    private $description;
     function __construct($desc)
    {
        $this->description = $desc;
    }
    public function getDescription()
    {
        return $this->description;
    }
}
?>
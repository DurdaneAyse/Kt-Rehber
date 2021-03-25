<?php


class PythonMailler
{
    public function __construct($userEmail,$activationLink)
    {
        exec("python python.py ".$userEmail." ".$activationLink."");
    }
}
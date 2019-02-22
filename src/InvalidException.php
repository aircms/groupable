<?php
namespace aircms\groupable;

use Exception;

class InvalidException extends Exception
{
    public static function GroupNotExist(){
        throw new static("group not exist");
    }
}

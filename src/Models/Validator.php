<?php

class Validator
{
    public static function stringLength($string, $maxLength)
    {
         if(strlen($string) <= $maxLength)
         {
             return true;
         }

         return false;
    }
}
<?php
namespace Model\Utilities;

class CodeGenerator
{
    /**
     * Function specially designed to work with 6 digit alphanumeric codes of the kind AAAA00.
     * It gets the current code, which its first 4 characters must be letters, and the last 2 numbers, and
     * returns the next code in the series. If you're wondering for the amount of possibly generated codes,
     * the exact amount is 1,190,676,776.
     * @param string $currentCode
     * 
     * @return string
     */
    public static function SequentialAlphaNumCode(string $currentCode)
    {        
        $alphabeticPart = substr($currentCode, 0, 4);
                
        $numericPart = substr($currentCode, 4);
                
        if($numericPart == '99')
        {            
            $alphabeticPart++;
            $numericPart = '00';
        }
        else
        {
            
            $numericPart++;
        }        

        $newCode = $alphabeticPart . sprintf('%02d', $numericPart);
        
        return $newCode;
    }

    /**
     * Generates a random alphanumeric code. If the lenght is not passed down, the default lenght is 5.
     * @param int|null $length
     * 
     * @return string
     */
    public static function RandomAlphaNumCode(int $length = null)
    {
        $len  = 5;
        if($length != null)
        {
            $len = $length;
        }
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';
        for ($i = 0; $i < $len; $i++)
        {
            $randomCode .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomCode;
    }
}
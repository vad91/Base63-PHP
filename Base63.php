<?php 

final class Base63 {
    
    private static $_charset = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','_');
    
    private static function _bigInt($numb, $base = 10) {
        if (class_exists('Math_BigInteger')) {
            return new Math_BigInteger($numb, $base);
        } else {
            throw new Exception('Math_BigInteger class was not declared');
        }
    }
    
    public static function encode($int, $base) {
        $big_int_base = self::_bigInt(count(self::$_charset));
        $str = '';
        $int = self::_bigInt($int, $base);
        $r = $int->divide($big_int_base);
        do {
            $big_int = $r[0];
            $str .= self::$_charset[$r[1]->toString()];
            $r = $big_int->divide($big_int_base);
            if ($r[0]->compare(self::_bigInt(1)) == -1) {
                $str .= self::$_charset[$r[1]->toString()];
                break;
            }
        } while (true);
        
        return strrev($str);
    }
    
    public static function decode($str) {
        $length = strlen($str);
        $result = self::_bigInt(0);
        $m = self::_bigInt(1);
        for ($i = 0; $i < $length; $i++) {
            $c = $str[$length - 1 - $i];
            if ($c == '_') {
                $tmp = self::_bigInt(62);
                $result = $result->add($tmp->multiply($m));
            } else if ($c <= '9') {
                $tmp = self::_bigInt(ord($c) - ord('0'));
                $result = $result->add($tmp->multiply($m));
            } else if ($c <= 'Z') {
                $tmp = self::_bigInt(ord($c) - ord('A')+ 10);
                $result = $result->add($tmp->multiply($m));
            } else if ($c <= 'z') {
                $tmp = self::_bigInt(ord($c) - ord('a')+ 36);
                $result = $result->add($tmp->multiply($m));
            }
            $m = $m->multiply(self::_bigInt(count(self::$_charset)));
        }
        
        return $result;
    }
}
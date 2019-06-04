<?php
/**
 * Created by PhpStorm.
 * User: e.krypowicz
 * Date: 29.05.2019
 * Time: 10:16
 */

class SyllabeCount
{

    public function getSyllabeCount($word){
        $vowel = ['a', 'ą', 'e', 'ę', 'i', 'o', 'ó', 'u', 'y'];
        $union=['au', 'ua', 'ea', 'ae', 'ai', 'ao', 'eo', 'oa', 'oe', 'io', 'oi', 'ei', 'ia', 'ie', 'iu', 'ei', 'ui'];

        for ($i = 0, $ile = count($union); $i < $ile; $i++) $word=str_replace($union[$i], 'a', $word);

        $sum = 0;
        for($i=0, $ile=count($vowel);$i<$ile;$i++) $sum+=mb_substr_count($word, $vowel[$i]);

        return $sum;
    }

}


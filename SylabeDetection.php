<?php
/**
 * Created by PhpStorm.
 * User: e.krypowicz
 * Date: 28.05.2019
 * Time: 15:33
 */

class SylabeDetection
{
    private $app;

    public function __construct($App)
    {
        $this->app=$App;

    }

    public function getSyllable($word){


        $vowel=[1=>'a', 'e', 'y', 'i', 'o', 'ą', 'ę', 'u', 'ó'];
        $prefixes=[1=>"kontr", "przed", "pod", "przy", "roz", "nie", "eks", "post", "bez", "eks", "do", "po" , "we", "na", "we", "za", "ze", "zo", "au", "eu", "a", "e", "u"];
        $syllable=[];

        for ($i = 1, $ile = count($prefixes); $i < $ile; $i++) {
            if(stripos($word, $prefixes[$i])===0){
                $syllable[] = substr($word, 0, strlen($prefixes[$i]));
                $word=str_replace($prefixes[$i], '', $word);
            }
        }


        $wordSplit=$this->splitFirstWord($word);


        for ($i = 0, $ile = count($wordSplit); $i < $ile; $i++) {
            $searchVowel[$i]=array_search($wordSplit[$i], $vowel); //znajdź samogłoski przypisuje im element tablicy
        }

        for ($i = 0, $ile = count($searchVowel); $i < $ile; $i++) {
           if (isset($searchVowel[$i]) && !$searchVowel[$i] && isset($searchVowel[$i + 1]) && isset($searchVowel[$i+2]) &&!$searchVowel[$i + 2] && isset($searchVowel[$i + 3])) { //spół + sam + spół + istnieje np. malunek
               $split=$wordSplit[$i] . $wordSplit[$i + 1];
               $syllable[] = $wordSplit[$i] . $wordSplit[$i + 1];
               $word=preg_replace("/{$split}/", "", $word, 1);
            }else if(isset($searchVowel[$i]) && $searchVowel[$i] && isset($searchVowel[$i+1]) && $searchVowel[$i+1] && isset($searchVowel[$i+2]) && $searchVowel[$i+2]) {
               $syllable[] = $wordSplit[$i] . $wordSplit[$i + 1];
           }else if(isset($searchVowel[$i]) && isset($searchVowel[$i+1]) && $wordSplit[$searchVowel[$i]]===$wordSplit[$searchVowel[$i+1]]){
               echo $searchVowel[$i];exit; //np. Joanna, Anna
           }
        }

        $syllable[]=$word;

        echo "<pre>".print_r($syllable, true)."</pre>"; exit;


        echo "<pre>".print_r($syllable, true)."</pre>"; exit;
        


    }


    public function splitFirstWord($word)
    {
        $digraphs = [ "rz", "sz", "cz", "ch", "dz", "dż", "dź", "ni", "mi", "zi", "wi"];
        $wordSplit = str_split($word);
        
        $exists = [];
        $temp=$word;
        for ($j = 0, $ilej = count($digraphs); $j < $ilej; $j++) {
            if($this->findAllOccurrences($temp, $digraphs[$j])){
                $exists[]=$this->findAllOccurrences($temp, $digraphs[$j]);
                $temp=str_replace($digraphs[$j], str_repeat("x", strlen($digraphs[$j])), $temp);
            }
        }

        $exists2=[];
        for ($i = 0, $ile = count($exists); $i < $ile; $i++) {
            foreach ($exists[$i] as $key=>$value){
                $exists2[$key]=$value;
            }
        }
        ksort($exists2);

        for ($i = 0, $ile = count($wordSplit); $i < $ile; $i++) {
            if(isset($exists2[$i])){
                $result[] = substr($word, $i, $exists2[$i]);
                $i = ($i + $exists2[$i])-1;
            }else{
                $result[] = substr($word, $i, 1);
            }
        }

        return $result;
    }

    public function findAllOccurrences($word, $needle){

        $lastPos=0;
        $positions=[];
        while (($lastPos = strpos($word, $needle, $lastPos))!== false) {
            $positions[$lastPos] = strlen($needle);
            $lastPos = $lastPos + strlen($needle);
        }

        return $positions;
    }



}

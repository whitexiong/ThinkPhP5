<?php


 function DeleteHtml($str) { 
     $str = trim($str); 
     $str = str_replace("\t","",$str); 
     $str = str_replace("\r\n","",$str); 
     $str = str_replace("\r","",$str); 
     $str = str_replace("\n","",$str); 
     return trim($str); 
 }		



echo DeleteHtml("");



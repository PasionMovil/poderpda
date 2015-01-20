<?php
/*
Template Name: Banner dinamico 3 Header
*/
$advert = array(); 
$advert[] = '<a href="" target="_blank"><img src=""></a>';
$advert[] = '<a href="" target="_blank"><img src=""></a>';
shuffle($advert); 
echo $advert[0];
exit(0);
?>
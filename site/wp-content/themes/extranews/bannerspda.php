<?php
/*
Template Name: Banner dinamico 1
*/
$advert = array(); 
$advert[] = '<a href="http://accesorios.poderpda.com" target="_blank"><img src="http://www.poderpda.com/wp-content/uploads/2013/03/BANNER-LARGE_Octilus_1.jpg"></a>';
$advert[] = '<a href="http://accesorios.poderpda.com" target="_blank"><img src="http://www.poderpda.com/wp-content/uploads/2013/03/BANNER-LARGE_Octilus_2.jpg"></a>';
$advert[] = '<a href="http://accesorios.poderpda.com" target="_blank"><img src="http://www.poderpda.com/wp-content/uploads/2013/03/BANNER-LARGE_Octilus_3.jpg"></a>';
shuffle($advert); 
echo $advert[0];
exit(0);
?>
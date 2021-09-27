<?php
$mt = ['title'=>'Integrass - Administrator',
	'desc'=>'Integrass - Administrator',
	'keywords'=> 'Integrass, Administrator, Admin',
	'img' => base_url('images/Integrass-Logo.png')];

if(isset($meta) && !empty($meta) && !is_null($meta) && is_array($meta)) {
	$mt['title'] = (array_key_exists('title', $meta) && !empty($meta['title']) && !is_null($meta['title']) ? $meta['title'] : $mt['title']);
	$mt['desc'] = (array_key_exists('desc', $meta) && !empty($meta['desc']) && !is_null($meta['desc']) ? $meta['desc'] : $mt['desc']);
	$mt['keywords'] = (array_key_exists('keywords', $meta) && !empty($meta['keywords']) && !is_null($meta['keywords']) ? $meta['keywords'] : $mt['keywords']);
	$mt['img'] = (array_key_exists('img', $meta) && !empty($meta['img']) && !is_null($meta['img']) ? $meta['img'] : $mt['img']);
} else {

} ?>
<meta name="author" content="INTEGRASS">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="title" content="<?= $mt['title']; ?>">
<meta name="description" content="<?= $mt['desc']; ?>">
<meta name="keywords" content="<?= $mt['keywords']; ?>">
<title><?= $mt['title']; ?></title>
<link rel="apple-touch-icon" href="https://integrass.com/themes/integrass/assets/img/favicon.ico">
<link rel="shortcut icon" type="image/png" href="https://integrass.com/themes/integrass/assets/img/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/mdb.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/fontawesome.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/sidebar.min.css'); ?>">
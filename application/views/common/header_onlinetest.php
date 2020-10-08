<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">     
	<link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/frontend/css/nta-ot.css');?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo isset($title)?'Free '.$title:'StudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.'?>">
    <meta name="keywords" content="IIT, IIT-JEE, IIT-JEE 2011, AIEEE, CBSE BOARD, ICSE BOARD, NEET, Exam Alert, Expert Help, Career Counselling, Latest Educational News, Sample Papers, Test Papers, Study Packages, Projects, Results, Scholarship, Blog, My Community, Dictionary, Calculator, Free Study Packages for All type of Exams, Free IIT-JEE Study Packages, Total Free Study Packages for IIT-JEE, AIEEE Free Study Packages, IIT-JEE Study Packages, Free Study Packages of AIEEE, NEET Study Packages, Free NEET Study Packages, Onl">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" />
       <title><?php echo isset($title)?$title.' - Studyadda.com':'JEE Main, JEE Advanced, CBSE, NEET, IIT, free study packages, test papers, counselling, ask experts - Studyadda.com';?>
	</title>
    
<meta property="og:title" content="<?php echo isset($title)?$title.' - Studyadda.com':'JEE Main, JEE Advanced, CBSE, NEET, IIT, free study packages, test papers, counselling, ask experts - Studyadda.com';?>" />
<meta property="og:description" content="<?php echo isset($title)?'Free '.$title:'StudyAdda offers free study packages for AIEEE, IIT-JEE, CAT, CBSE, CMAT, CTET and others. Get sample papers for all India entrance exams.'?>" />
<meta property="og:image" content="<?php echo get_assets('assets/frontend/images/logo_new.png');?>" />
<meta property="og:url" content="<?php echo base_url()?>"/>

 
    <!-- Custom Fonts -->
    <link href="<?php echo get_assets('assets/frontend/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo get_assets('assets/frontend/css/bootstrap.min.css');?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/frontend/css/bootstrap-material-design.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/frontend/css/ripples.css');?>">
    <!-- Custom CSS -->
    <link href="<?php echo get_assets('assets/frontend/css/main.css');?>" rel="stylesheet">
    <link href="<?php echo get_assets('assets/frontend/css/toastr.min.css');?>" rel="stylesheet"/>
     <link href="<?php echo get_assets('assets/frontend/css/ol.range.css');?>" rel="stylesheet"/>
    <?php if(isset($styles) && count($styles) > 0){ 
        foreach($styles as $key=>$style){   
    ?>
        <link media="all" type="text/css" rel="stylesheet" href="<?php echo strpos($style,'http') !== false ? $style : base_url().$style;?>">
    <?php } 
    } ?>
	 <link rel="stylesheet" type="text/css" href="<?php echo get_assets('assets/css/effect.css');?>">
    <!-- Material Design fonts -->
 
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var base_url="<?php echo base_url();?>";
    </script>
</head>
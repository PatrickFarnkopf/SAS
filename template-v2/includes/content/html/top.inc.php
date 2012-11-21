<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>SAS - Server Admin System</title>

        <!-- CSS -->
        <link href="style/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
        <link href="style/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
        <!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie6.css" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="style/css/ie7.css" /><![endif]-->

        <!-- JavaScripts-->
        <script type="text/javascript" src="style/js/jquery.js"></script>
        <script type="text/javascript" src="style/js/jNice.js"></script>
    </head>

    <body>
        <div id="wrapper">
            <h1>Server <span>Admin</span> System</h1>

            <?php
            $file = $_SERVER["SCRIPT_NAME"];
            $break = Explode('/', $file);
            $pfile = $break[count($break) - 1];
            ?>

            <ul id="mainNav">
                <?php 
                    loadMenu();
                ?>
            </ul>
            <!-- // #end mainNav -->
            <div id="containerHolder">
                <div id="container">
                    <div id="sidebar">

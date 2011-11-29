<!doctype html>
<html>

<!-- Envysea Header (normal pages) -->

<head>
    <!-- meta tags -->
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <meta name="description"
          content="Envysea authentication offers rapid application development for membership, authentication, and login sites."/>
    <meta name="keywords" content="Authentication, Membership, Login, Codeigniter 2.0.3"/>
    <meta name="author" content="Nicholas Cerminara | http://envysea.com"/>

    <!-- favicon -->
    <link href="http://lostandcloud.com/assets/images/favicon.png" rel="shortcut icon" type="image/png"/>
    <!-- css -->
    <link href="/css/reset.css" rel="stylesheet" type="text/css"/>
    <!-- Eric Meyer CSS reset v2.0 (HTML5 and CSS3 support) -->
    <link href="/css/base.css" rel="stylesheet" type="text/css"/>
    <!-- Shared CSS Elements -->
    <link href="/css/style.css" rel="stylesheet" type="text/css"/>
    <!-- Unique to non-admin and non-secure pages only -->

    <!-- javascript -->
    <!--[if IE]>
    <script src="/js/html5.js"></script><![endif]-->
    <script type="text/javascript" src="/js/jquery.js"></script>
    <!-- jQuery v1.7 -->
    <script type="text/javascript" src="/js/scripts.js"></script>
    <!-- custom jQuery scripts/plugins -->

    <title>Envysea Codeigniter Authentication</title>

</head>
<body>
<div id="container">
    <div id="header">
        <!-- delete this -->
        <div id="logo">
            <a href="/">Home</a></div>
        <!-- /end delete this -->
        <ul id="nav">
            <li><a href="/" title="Home is where you make it.">Home</a></li>
            <li><a href="http://lostandcloud.com/envysea/about">About</a></li>
            <li><a href="/members/login">Members</a></li>
            <li><a href="http://lostandcloud.com/envysea/contact">Contact</a></li>
            <?php if ($this->auth->is_logged_in()): ?>
            <li><a href="/members/logout">Logout</a></li>
            <?php endif; ?>
        </ul>
    </div>

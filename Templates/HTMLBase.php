<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!--Force IE standards mode-->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
        <link rel="stylesheet" media="only screen and (min-width: 801px)" href="/group2/Templates/Styles/desktop.css" />
        <link rel="stylesheet" media="only screen and (min-width: 800px) and (max-width: 1023px)" href="/group2/Templates/Styles/tablet.css">
        <link rel="stylesheet" media="handheld, only screen and (max-width: 799px), only screen and (max-device-width: 799px)" href="/group2/Templates/Styles/mobile.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
        <title><?=$title?></title>
    </head>
    <body>
        <header>
            <a href="/group2/"><img id="logo" src="/group2/Templates/Images/Map-Logo-Yellow.png" alt="Jack in the Box Logo"/></a>
            <nav id="headerNav">
                <ul>
                    <li><a href="/group2/">Home</a></li>
                    <li><a href="/group2/profiles/">Staff Profiles</a></li>
                    <li><a href="/group2/about/">About Us</a></li>
                    <li><a href="/group2/support/">Support Us</a></li>
                    <li><a href="/group2/gallery/">Gallery</a></li>
                    <li><a href="/group2/upcoming/">Upcoming</a></li>
                    <li><a href="/group2/contact/">Contact Us</a></li>
                    <li><a href="/group2/activities/">Activities</a></li>
                    <?php
                    if($authenticated){
                        echo'
                        <li><a href="/group2/settings/">Account Settings</a></li>
                        <li><a href="/group2/logout/">Log out</a></li>
                        ';
                    }
                    else
                        echo'
                        <li><a href="/group2/register/">Register</a></li>
                        <li><a href="/group2/login/">Log in</a></li>
                        ';
                    ?>
                </ul>
            </nav>
        </header>
        <div id="mainSection">
            <?php include ROOT."/Templates/".$body.".php"; ?>
            <!--<div id="socialnetworks">
                Friend us on Facebook <a href="https://www.facebook.com/jackin.thebox.758"><img src="/group2/Templates/Images/facebook_icon.png" alt="facebook logo" /></a><br />
                Follow us on Twitter <a href="https://twitter.com/Mahe_JackBox"><img src="/group2/Templates/Images/twitter_logo.jpg" alt="twitter logo" /></a><br />
            </div>-->
        </div>
        <footer>
                <a href="#">Terms</a> | <a href="#">FAQ's</a> | <a href="sitemap.html">Site map</a><br />
                2012 &copy; Sam Barker & Vicky Ng
        </footer>
    </body>
</html>
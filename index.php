<?php
session_start();
session_save_path('/group2/');
include("config.php");
include(ROOT."/Classes/PageManager.php");
include(ROOT."/Classes/Account.php");
require_once(ROOT."/Classes/PhpConsole.php");

//Used for debugging
PhpConsole::start(true, true, dirname(__FILE__));

if(isset($_GET['page']))
    $page = $_GET['page'];
else
    $page = "index";

if(isset($_GET['subpage']))
    $subpage = $_GET['subpage'];
else
    $subpage = null;

$pagemanager = new PageManager();
$pagemanager -> GetPage($page, $subpage);
$pagemanager -> RenderPage();

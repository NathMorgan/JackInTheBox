<?php
class PageManager
{
    var $title;
    var $body;
    var $extravalues;
    var $authenticated;
    var $error;

    public function GetPage($page, $subpage)
    {
        //Creating the account class
        $account = new Account();

        //Checking if the authenticated Session or Cookie exists if so checks if its authentic
        if(isset($_COOKIE['jitblogin']) || isset($_SESSION['jitblogin']))
        {
            if($account->Authenticate($_COOKIE['jitblogin'] . $_SESSION['jitblogin']))
                $this->authenticated = true;
            else
                $this->authenticated = false;
        }
        else
            $this->authenticated = false;
        if($subpage != "")
            $page = $subpage;

        switch($page)
        {
            case'index':
                $this->title = "Home";
                $this->body = "IndexBase";
                break;
            case'login':
                if(isset($_POST['submit']))
                {
                    $values = $account->Login($_POST['login-email'], $_POST['login-password'], isset($_POST['login-remember-me']), $_POST['login-parent']);
                    if($values == false)
                        $this->error = $account->GetError();
                    else
                    {
                        $this->extravalues = $values;
                    }
                }
                $this->title = "Login";
                $this->body = "ParentLoginBase";
                break;
            case'register':
                if(isset($_POST['submit']))
                {
                    if(!$account->RegisterParent($_POST['parent-first-name'], $_POST['parent-last-name'], $_POST['parent-email'], $_POST['parent-confirm-email'], $_POST['parent-password'], $_POST['parent-confirm-password'], $_POST['parent-home-contact-number'], $_POST['parent-work-contact-number'], isset($_POST['parent-subscribe'])))
                        $this->error = $account->GetError();
                }
                $this->title = "Register";
                $this->body = "RegisterBase";
                break;
            case'profiles':
                $this->title = "Staff Profiles";
                $this->body = "StaffProfilesBase";
                break;
            case'settings':
                $this->title = "Settings";
                $this->body = "SettingsBase";
                break;
            case'account':
                if($this->authenticated == false)
                    header: "Location: http://jitb.tuqiri.net/group2/login/";
                $this->title = "Account Settings";
                $this->body = "AccountSettingsBase";
                break;
            case'logout':
                $account->Logout($_SESSION['jitblogin'] . $_COOKIE['jitblogin']);
                break;
            default:
                $this->title = "404";
                $this->body = "404";
                break;
        }
    }

    public function RenderPage()
    {
        $title = $this->title;
        $error = $this->error;
        $body = $this->body;
        $extravalues = $this->extravalues;
        $authenticated = $this->authenticated;
        include ROOT.'/Templates/HTMLBase.php';
    }
}

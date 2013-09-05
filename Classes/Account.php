<?php
class Account
{
    var $error;

    public function RegisterParent($firstname, $lastname, $email, $confirmemail, $password, $confirmpassword, $homecontact, $workcontact, $subscribe) {
        //Checking the inputs are not null if they are null set the error and return false that the register was unsuccessful
        if($firstname == null)
        {
            $this->error = "First name has no value";
            return false;
        }
        if($lastname == null)
        {
            $this->error = "Last name has no value";
            return false;
        }
        if($email == null)
        {
            $this->error = "Email has no value";
            return false;
        }
        if($confirmemail == null)
        {
            $this->error = "Confirm email has no value";
            return false;
        }
        if($password == null)
        {
            $this->error = "Password has no value";
            return false;
        }
        if($confirmpassword == null)
        {
            $this->error = "Confirm password has no value";
            return false;
        }
        if($homecontact == null)
        {
            $this->error = "Home contact has no value";
            return false;
        }
        if($workcontact == null)
        {
            $this->error = "Work contact has no value";
            return false;
        }
        if($subscribe == null)
            $subscribe = 0;

        //Checking the two passwords match
        if($password != $confirmpassword)
        {
            $this->error = "Passwords don't match";
            return false;
        }

        //Checking the two emails match
        if($email != $confirmemail)
        {
            $this->error = "Emails don't match";
            return false;
        }

        //Checking if subscribe is true or false and not any other value
        if($subscribe != true && $subscribe != false)
        {
            $this->error = "Subscribe has an invalid value";
            return false;
        }

        //Checking the details comply with the standards set in config.php
        if(strlen($firstname) < PARENT_FIRSTNAME_MIN_LENGTH)
        {
            $this->error = "First Name value is too short";
            return false;
        }
        if(strlen($firstname) > PARENT_FIRSTNAME_MAX_LENGTH)
        {
            $this->error = "First Name value is too long";
            return false;
        }
        if(strlen($lastname) < PARENT_LASTNAME_MIN_LENGTH)
        {
            $this->error = "Last Name value is too short";
            return false;
        }
        if(strlen($lastname) > PARENT_LASTNAME_MAX_LENGTH)
        {
            $this->error = "Last Name value is too long";
            return false;
        }
        if(strlen($email) < PARENT_EMAIL_MIN_LENGTH)
        {
            $this->error = "Email value is too short";
            return false;
        }
        if(strlen($email) > PARENT_EMAIL_MAX_LENGTH)
        {
            $this->error = "Email value is too long";
            return false;
        }
        if(strlen($password) < PARENT_PASSWORD_MIN_LENGTH)
        {
            $this->error = "Password value is too short";
            return false;
        }
        if(strlen($password) > PARENT_PASSWORD_MAX_LENGTH)
        {
            $this->error = "Password value is too long";
            return false;
        }
        if(strlen($homecontact) < PARENT_CONTACT_MIN_LENGTH)
        {
            $this->error = "Home contact value is too short";
            return false;
        }
        if(strlen($workcontact) < PARENT_CONTACT_MIN_LENGTH)
        {
            $this->error = "Work contact value is too short";
            return false;
        }
        if(strlen($homecontact) > PARENT_CONTACT_MAX_LENGTH)
        {
            $this->error = "Home contact value is too long";
            return false;
        }
        if(strlen($workcontact) > PARENT_CONTACT_MAX_LENGTH)
        {
            $this->error = "Work contact value is too long";
            return false;
        }

        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

        //Escaping the strings to prevent sql injection
        $firstname = $mysqli->real_escape_string($firstname);
        $lastname = $mysqli->real_escape_string($lastname);
        $email = $mysqli->real_escape_string($email);
        $workcontact = $mysqli->real_escape_string($workcontact);
        $homecontact = $mysqli->real_escape_string($homecontact);

        $query = $mysqli->query('
        SELECT
          `Email`
        FROM
          `accounts`
        WHERE
          `Email` = '.$email.'');

        if($query != null)
        {
            $this->error = "Email already exists";
            return false;
        }

        $mysqli->query("
        INSERT INTO
          `parents`
          (`FirstName`, `LastName`, `HomeNo`, `WorkNo`)
        VALUES
          ('$firstname', '$lastname', '$homecontact', '$workcontact')
        ");

        $parentid = $mysqli->insert_id;

        $timenow = date("d-m-y H:i:s");
        $salt = hash("md5", $timenow.$email.$lastname.$firstname);
        $password = hash("md5", $salt.$password);

        $mysqli->query("
        INSERT INTO
          `accounts`
          (`Email`, `Salt`, `Password`, `Subscribe`, `Registered`, `LastLogin`)
        VALUES
          ('$email', '$salt', '$password','$subscribe' , '$timenow', '$timenow')
        ");

        $accountid = $mysqli->insert_id;

         $mysqli->query("
        INSERT INTO
          `accountxparents`
          (`Accountid`, `Parentid`)
        VALUES
          ('$accountid', '$parentid')
        ");

        $query = $mysqli->query('
        SELECT
          `Email`
        FROM
          `accounts`
        WHERE
          `Employee` = 1');

        if($query != null)
        {
            while($row = $query->fetch_assoc())
            {
                $this->Email($row['Email'], "New parent registered", "http://jitb.tuqiri.net/group2/templates/Email/newuser.php?name=$firstname  $lastname");
            }
        }

        header('Location: http://jitb.tuqiri.net/group2/');
    }

    public function RegisterEmployer() {

    }

    public function AddParent($firstname, $lastname, $homeno, $mobileno) {
        return true;
    }

    public function AddChild() {
        return true;
    }

    public function Authenticate($key){
        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

        $session = $mysqli->real_escape_string($key);

        $query = $mysqli->query("
        SELECT
          *
        FROM
          `sessions`
        WHERE
          `key` = '$key'
        ");;

        if($query == null){
            return false;
        }
        return true;
    }

    public function Login($email, $rawpassword, $remember, $parentid = 0) {
        //Checking the inputs are not null and returning false if so
        if($email == null)
        {
            $this->error = "Email is empty";
            return false;
        }
        if($rawpassword == null)
        {
            $this->error = "Password is empty";
            return false;
        }
        if($remember == null)
        {
            $remember = 0;
        }

        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

        //Escaping username to prevent sql injection
        $email = $mysqli->real_escape_string($email);

        //Getting the data from the accounts where the email is equal to the email in the database
        $query = $mysqli->query("
        SELECT
          `Accountid`, `Email`, `Password`, `Salt`
        FROM
          `accounts`
        WHERE
          `Email` = '$email'
        ");

        //If there is no result from the query then the email does not exist
        if($query == null)
        {
            $this->error = "Email does not exist";
            return false;
        }

        $row = $query->fetch_assoc();
        $password = hash("md5", $row['Salt'].$rawpassword);


        if($password != $row['Password'])
        {
            $this->error = "Incorrect password or email combination";
            return false;
        }

        $accountid = $row['Accountid'];
        $salt = $row['Salt'];

        $result = $mysqli->query("
        SELECT
          `Parentid`, `Accountid`
        FROM
          `accountxparents`
        WHERE
          `Accountid` = '$accountid'
        ");

        if($parentid == 0 && $result->num_rows > 1)
        {
            while($row = $result->fetch_assoc()){
                $parentid = $row['Parentid'];
                $query = $mysqli->query("
                SELECT
                  *
                FROM
                  `parents`
                WHERE
                  `Parentid` = '$parentid'
                ");

                $parents[] = $query->fetch_assoc();
            }

            if($remember)
                $remember = "checked";

            $values = array(
                "email" => $email,
                "password" => $rawpassword,
                "remember" => $remember,
                "parents" => $parents
            );

            return $values;
        }
        else if($result->num_rows == 1)
        {
            $row = $result->fetch_assoc();
            $parentid = $row['Parentid'];
        }

        $cookieval = hash("md5", $_SERVER['REMOTE_ADDR'].$salt.$email);
        $date = date("d-m-y H:i:s");

        $mysqli->query("
        INSERT INTO
          `sessions`
          (`Parentid`, `Key`, `DateTime`)
        VALUES
          ('$parentid','$cookieval', '$date')
        ");

        if($remember)
            setcookie("jitblogin", $cookieval, time()+(20*365*24*60*60), "/group2/");
        else
            $_SESSION['jitblogin'] = $cookieval;

        header('Location: http://jitb.tuqiri.net/group2/');
    }

    public function Logout($session) {
        if($session == null)
        {
            $this->error = "Not logged in";
            return false;
        }
        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

        $session = $mysqli->real_escape_string($session);

        $result = $mysqli->query("
            DELETE FROM
              `sessions`
            WHERE
              `Key` = '$session'
            ");

        $_SESSION['jitblogin'] = null;
        setcookie("jitblogin" , null, time()-60, "/group2/");
        header('Location: http://jitb.tuqiri.net/group2/');
    }

    static function GetEmployers() {
        $mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

        $result = $mysqli->query("
            SELECT
              *
            FROM
              `employees`
            ");

        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }
        return $rows;
    }

    static function Email($to, $subject, $message){
        //Using a remote server to send the mail(Note: This may be deleted in the future for security reasons)
        $link = "http://www.tuqiri.net/sendmail.php?id=Z9Nsuzm4sS1McHzd5txF&to=$to&subject=$subject&message=$message";
        $url = str_replace(' ', '%20', $link);
        file_get_contents($url);

        //If was done on the same server use this code
        /*
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Jack In The Box Admin <admin@jackintheboxnortheast.co.uk>' . "\r\n";

        mail($to, $subject, $message, $headers);
        */
    }

    public function GetError(){
        return $this->error;
    }
}

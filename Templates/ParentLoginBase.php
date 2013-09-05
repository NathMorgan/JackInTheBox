<div id="Loginwrapper">
    <h1>Login</h1>
    Please login in with the email and password you provided when registering
    <div id="Loginform">
        <div id="error"><?=$error?></div>
        <form name="parent-login" action="" method="post">
            <label for="login-email">Email: </label>
            <input type="text" name="login-email" id="login-email" value="<?=$extravalues['email']?>" <?php if(isset($extravalues['email'])) echo 'readonly'; ?> /><br/><br/>
            <label for="login-password">Password: </label>
            <input type="password" name="login-password" id="login-password" value="<?=$extravalues['password']?>" <?php if(isset($extravalues['email'])) echo 'readonly'; ?> /><br/><br/>
            <label for="login-remember-me">Remember me: </label>
            <input type="checkbox" name="login-remember-me" id="login-remember-me" <?=$extravalues['remember']?> <?php if(isset($extravalues['email'])) echo 'readonly'; ?> /><br/><br/>
            <?php
                if(isset($extravalues['parents']))
                {
                    echo "<label for=\"login-parent\">Please Select who you wish to login as</label>";
                    echo "<select name=\"login-parent\">";
                    foreach($extravalues['parents'] as $parent)
                    {
                        echo "<option value=\"".$parent['Parentid']."\">".$parent['FirstName']. " ".$parent['LastName']."</option>";
                    }
                    echo "</select>";
                }
            ?>
            <input name="submit" type="submit" value="Login" />
        </form>
    </div>
</div>
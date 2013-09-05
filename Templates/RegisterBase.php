<div id="Registerwrapper">
    <h1>Register</h1>
    Before you can register your child to participate in activities we first need to confirm who you are please fill out this form below so one of our staff can contact you by phone if you don't wish to register online please <a href="/group2/contact/">contact us</a>.
    <div id="Reigsterform">
        <div id="error"><?=$error?></div>
        <form name="parent-register" action="/group2/register/" method="post">
            <label for="parent-first-name">First Name: </label>
            <input type="text" name="parent-first-name" id="parent-first-name" /><br /><br />
            <label for="parent-last-name">Last Name: </label>
            <input type="text" name="parent-last-name" id="parent-last-name" /><br /><br />
            <label for="parent-email">Email: </label>
            <input type="text" name="parent-email" id="parent-email" /><br /><br />
            <label for="parent-confirm-email">Confirm Email: </label>
            <input type="text" name="parent-confirm-email" id="parent-confirm-email" /><br /><br />
            <label for="parent-password">Password: </label>
            <input type="password" name="parent-password" id="parent-password" /><br /><br />
            <label for="parent-confirm-password">Confirm Password: </label>
            <input type="password" name="parent-confirm-password" id="parent-confirm-password" /><br /><br />
            <label for="parent-home-contact-number">Home Contact Number: </label>
            <input type="text" name="parent-home-contact-number" id="parent-home-contact-number" /><br /><br />
            <label for="parent-work-contact-number">Work Contact Number: </label>
            <input type="text" name="parent-work-contact-number" id="parent-work-contact-number" /><br /><br />
            <label for="parent-subscribe">Subscribe: </label>
            <input type="checkbox" name="parent-subscribe" id="parent-subscribe" /><br /><br />
            <input name="submit" type="submit" value="Register">
        </form>
        <div class="clearfloats"></div>
    </div>
</div>
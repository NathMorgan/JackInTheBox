<div id="profileswrapper">
    <h1>Staff Profiles</h1>
    <?php
        foreach(Account::GetEmployers() as $employer)
        {
            echo"
            <div class=\"profile\">
            <h2>".$employer['Title']." ".$employer['FirstName']." ".$employer['LastName']."</h2>
            <img src=\"/Group2/Uploads/ProfilePictures/".$employer['PictureName']."\" alt=\"".$employer['FirstName']." profile picture\"/><br />
            <p><span>Name - </span>".$employer['FirstName']." ".$employer['LastName']."</p>
            <p><span>Education - </span>".$employer['Education']."</p>
            <p><span>About - </span>".$employer['About']."</p>
            </div>";
            }
    ?>
    <div class="clearfloats"></div>
</div>
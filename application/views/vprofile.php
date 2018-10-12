<h1>My Profile</h1>
<fieldset style="background:#E5E5E5;">
    <legend>User Credentials</legend>
    <form id="updateUserCredsFrm">
        <p>
            <label>User Name</label>
            <input type="text" name="user_name" value="<?php echo $user['user_name'] ?>"/>
        </p>
        <p>
            <label>User E-mail</label>
            <input type="text" name="user_email" value="<?php echo $user['user_email'] ?>"/>
        </p>
        <p>
            <label>Old Password</label>
            <input type="password" class="input-large required" name="old_password"/>&nbsp;<span class="form_notification"></span>
        </p>
        <p>
            <label>New Password</label>
            <input type="password" class="input-large required" name="password"/>&nbsp;<span class="form_notification" id="passStrength"></span>
        </p>
        <p>
            <label>Confirm Password</label>
            <input type="password" class="input-large required" name="confirmpassword"/>&nbsp;<span class="form_notification" id="passConfirm"></span>
        </p>
        <p class="btn_holder">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>"/>
            <input type="button" id="updateUserCredsBtn" class="btn" value="Update"/>
        </p>
    </form>
</fieldset>
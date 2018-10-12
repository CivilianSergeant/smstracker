<fieldset>
    <legend>Add User</legend>
    
            <form id="addNewUserFrm">
                <p>
                    <label>User Name</label>
                    <input type="text" name="user_name" class="required input-large"/>&nbsp;<span></span>
                </p>
                <p>
                    <label>User E-mail</label>
                    <input type="text" name="user_email" class="required input-large"/>&nbsp;<span></span>
                </p>
                <p>
                    <label>Password</label>
                    <input type="password" name="password" class="required input-medium"/>&nbsp;<span class="form_notification" id="passStrength"></span>
                </p>
                <p>
                    <label>Confirm Password</label>
                    <input type="password" name="confirmpassword" class="required input-medium"/>&nbsp;<span class="form_notification" id="passConfirm"></span>
                </p>
                
                <p>
                    <label>User Type</label>
                    <?php if(strtolower($user_type) == 'admin'){ ?>
                    <select name="user_type" class="required">
                        <option value="">--SELECT--</option>
                        <option value="admin">Admin</option>
                        <option value="client">Client</option>
                    </select>
                    <?php }else if(strtolower($user_type) == 'super_admin'){ ?>
                    <select name="user_type" class="required">
                        <option value="">--SELECT--</option>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="client">Client</option>
                    </select>&nbsp;<span></span>
                    <?php } ?>
                </p>
                <p class="btn_holder">
                    <input type="button" class="btn" id="saveUserBtn" value="Save"/>
                </p>
            </form>
</fieldset>

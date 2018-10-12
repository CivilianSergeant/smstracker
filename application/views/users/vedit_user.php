<fieldset>
    <legend>Edit User</legend>
    
            <form id="updateUserFrm">
                <p>
                    <label>User Name</label>
                    <input type="text" name="user_name" readonly value="<?php echo (!empty($user))? $user['user_name'] :''; ?>" class="required input-large"/>&nbsp;<span></span>
                </p>
                <p>
                    <label>User E-mail</label>
                    <input type="text" name="user_email" value="<?php echo (!empty($user))? $user['user_email'] :''; ?>" class="required input-medium"/>&nbsp;<span class="form_notification"></span>
                </p>
                <hr/>
                <p>
                    <label>User Password</label>
                    <input type="password" name="user_pass" class="required input-medium"/>&nbsp;<span>Update password (If necessary)</span>
                </p>
                <hr/>
                <p class="btn_holder">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>"/>
                    <input type="button" class="btn" id="updateUserBtn" value="Update"/>
                </p>
            </form>
    
       
</fieldset>

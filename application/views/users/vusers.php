<h1>Users</h1>
<fieldset style="background:#E5E5E5;">
    <legend>Search User</legend>
    <form id="searchUserFrm">
        <p>
            <label>Search:</label>
            <input type="text" name="searchTxt" class="input-large"/>
            <input type="button" id="searchUserBtn" class="btn" value="Search" />
        </p>
    </form>
</fieldset>
<hr/>
<fieldset style="background:#E5E5E5;">
    <legend>Users List</legend>
    <table class="grid">
        <thead>
            <tr>
                <td style="background:#EDEDED;" colspan="4"><?php echo (!empty($page_links))? $page_links.' | ' : ''; ?>  <a class="refresh_grid" href="#">Refresh</a></td>
                <td style="text-align:right;"><input type="button" id="addNewBtn" class="btn" value="Add New" /></td>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Sl.</th>
                <th>User Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php 
           if(!empty($users))
           {
               foreach($users as $k=> $user)
               {
         ?>
            <tr>
                <td><?php echo ($k+1);?></td>
                <td><?php echo (!empty($user['user_name']))? $user['user_name'] : 'No Data Found'; ?></td>
                <td><?php echo (!empty($user['user_email']))? $user['user_email'] : 'No Data Found'; ?></td>
                <td><?php echo (!empty($user['user_type']))? $user['user_type'] : 'No Data Found'; ?></td>
                <td>
                    <a class="user_edit" href="<?php echo $user['user_id']; ?>">Edit</a> | 
                    <?php 
                        if(strtolower($user['user_type']) == "client"){
                    ?>
                    <a href="<?php echo BASE; ?>limits/sms_limit/<?php echo $user['clientId']; ?>">SMS Settings</a> |
                    <?php } ?>
                    <a class="user_del" href="<?php echo $user['user_id']; ?>">Delete</a>
                </td>
            </tr>
         <?php
               }
           }
           else
           {
         ?>
            
         <?php
            }
         ?>   
        </tbody>
        <tfoot>
            <tr>
                <td style="background:#EDEDED;" colspan="5"><?php echo (!empty($page_links))? $page_links.' | ' : ''; ?> <a class="refresh_grid" href="#">Refresh</a></td>
            </tr>
        </tfoot>
    </table>
    
</fieldset>
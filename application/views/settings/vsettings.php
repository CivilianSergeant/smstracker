<h1>Settings</h1>
<fieldset>
    <legend>Domains</legend>
    <form id="addDomainFrm">
        <p>
            <label>Domain Name: </label>
            <input type="text" name="name" class="input-medium"/>
        </p>
        <p>
            <label>Link: </label>
            <input type="text" name="link" class="input-xlarge"/>
        </p>
        <p>
            <label>Create User Account</label> <input type="checkbox" name="create_user" value="1"/>
        </p>
        <hr/>
        <p>
            <input type="button" id="saveDomainBtn" class="btn" value="Save"/>
        </p>
    </form>
</fieldset>
<fieldset>
    <legend>Domains List</legend>
    <table class="grid">
        <thead>
            <tr>
                <td style="background:#EDEDED;" colspan="4"><?php //echo (!empty($page_links))? $page_links.' | ' : ''; ?>  <a class="refresh_grid" href="#">Refresh</a></td>
                
            </tr>
        </thead>
        <thead>
            <tr>
                <th>Sl.</th>
                <th>Domain Name</th>
                <th>Link</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($domains))
            {
                foreach($domains as $k => $d)
                {
            ?>
            <tr>
                <td><?php echo ($k+1); ?></td>
                <td><?php echo $d['name']; ?></td>
                <td><strong><?php echo $d['link']; ?></strong></td>
                <td>
                    <a class="domain_view" href="<?php echo BASE.'dashboard/app_user_details/'.$d['domain_id']; ?>" title="View">View</a>&nbsp;|&nbsp;
                    <a class="domain_edit" href="<?php echo $d['domain_id']; ?>" title="Edit">Edit</a>&nbsp;|&nbsp;
                    <a class="domain_del" href="<?php echo $d['domain_id']; ?>" title="Delete">Delete</a>&nbsp;|&nbsp;
                    <a class="domain_generate" href="<?php echo $d['domain_id']; ?>" title="Generate API KEY">Generate</a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="background:#EDEDED;" colspan="4"><?php //echo (!empty($page_links))? $page_links.' | ' : ''; ?> <a class="refresh_grid" href="#">Refresh</a></td>
            </tr>
        </tfoot>
    </table>
</fieldset>
<fieldset>
    <legend>Notification E-mail</legend>
    <form id="notifyEmailFrm">
        <p>
            <label>E-mail:</label>
            <input type="text" class="input-xlarge" value="<?php echo $settings['email']['value']; ?>" name="email"/>
        </p>
        <p>
            <label>Current Provider:</label>
            <select type="width:auto;" name="active_vendor">
                <?php $vendors = array('Eworld','BulkSms','Progga','WiselySend'); ?>
                <?php foreach($vendors as $v){ ?>
                   <option value="<?php echo $v; ?>" <?php if($settings['active_vendor']['value'] == $v){ echo 'selected="selected"'; } ?>><?php echo $v; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <input type="button" class="btn" id="notifyEmailBtn" value="Update"/>
        </p>
    </form>
</fieldset>
<br/>

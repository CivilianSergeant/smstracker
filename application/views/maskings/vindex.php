<fieldset>
    <legend>Add Masking</legend>
    <form id="addMaskingFrm" action="<?php echo BASE; ?>dashboard/maskings" method="post">
        <p>
            <label>Masking:</label>
            <input type="text" name="masking" class="input-medium"/>
        </p>
        <p>
            <label>&nbsp;</label>
            <input type="submit" class="btn" name="submitMasking" value="Add"/>
        </p>
    </form>
</fieldset>
<fieldset>
    <legend>List of Masking</legend>
    <table class="grid">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Masking</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(!empty($maskings)){
                    foreach($maskings as $k => $masking){
            ?>
            <tr>
                <td><?php echo ($k+1); ?></td>
                <td><?php echo $masking['masking']; ?></td>
                <td>
<!--                    <a href="<?php echo BASE; ?>dashboard/update_masking/<?php echo $masking['masking_id']; ?>">Edit</a> |-->
                    <a href="<?php echo BASE; ?>dashboard/delete_masking/<?php echo $masking['masking_id']; ?>">Delete</a>
                </td>
            </tr>
            <?php } 
            
                }
            ?>
            
        </tbody>
    </table>
</fieldset>
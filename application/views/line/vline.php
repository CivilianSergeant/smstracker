<fieldset>
    <legend>Specify Line for Masking</legend>
    <?php if(!empty($msg)){ ?>
    <h3 style="color:green"><?php echo $msg; ?></h3>
    <?php } ?>
    <form action="<?php echo site_url('line/updateline');?>" method="post">
    <table class="grid">
        <thead>
        <tr>
            <th>Masking</th>
            <?php
                foreach($provdiers as $provider){
            ?>
            <th><?php echo $provider['provider']; ?></th>
            <?php } ?>

            <th>Default</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($masking as $m){ ?>
        <tr>
            <td><?php echo $m['masking']; ?></td>
            <?php
            foreach($provdiers as $provider){
            ?>
            <td>
                <select name="line[<?php echo $m['masking']; ?>][<?php echo $provider['provider']; ?>]" style="width:100px;">
                    <option <?php if($lines[$m['masking']][$provider['provider']] == "OFF"){echo 'selected="selected"';}?> value="OFF">OFF</option>
                    <option <?php if($lines[$m['masking']][$provider['provider']] == "Default"){echo 'selected="selected"';}?> value="Default">Default</option>
                    <?php
                        for($i=1; $i<=5; $i++)
                        {
                            $lineNumber = $provider['provider'].'_'.$i;
                            echo '<option ';
                            if($lines[$m['masking']][$provider['provider']] == $lineNumber)
                            echo 'selected="selected"';
                            echo ' value="'.$provider['provider'].'_'.$i.'">'.$lineNumber.'</option>';
                        }
                    ?>
                </select>
            </td>
            <?php } ?>

            <td>
                <select name="line[<?php echo $m['masking']; ?>][Default]" style="width:100px;">
                    <option <?php if($lines[$m['masking']]['Default'] == "OFF"){ echo 'selected="selected"'; } ?> value="OFF">OFF</option>
                    <?php
                    $vendors = array('BulkSms','Eworld','Msg21','Progga','WisleySend');
                    foreach($provdiers as $provider){
                        for($i=1; $i<=5; $i++)
                        {
                            $lineNumber = $provider['provider'].'_'.$i;
                            echo '<option ';
                            if($lines[$m['masking']]['Default'] == $lineNumber)
                                echo 'selected="selected"';
                            echo ' value="'.$lineNumber.'">'.$lineNumber.'</option>';
                        }
                    }
                    foreach($vendors as $vendor){
                        /*for($i=1; $i<=5; $i++)
                        {*/
                        $lineNumber = $vendor;
                        echo '<option ';
                        if($lines[$m['masking']]['Default'] == $lineNumber)
                            echo 'selected="selected"';
                        echo ' value="'.$lineNumber.'">'.$lineNumber.'</option>';
                        /*}*/
                    }
                    ?>
                </select>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <br/>
    <input type="submit" class="btn" value="Update"/>
    </form>
</fieldset>
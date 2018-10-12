<h1>Send SMS</h1>
<fieldset id="sms" style="background:#E5E5E5;">
    <legend>Create new Text Message Here</legend>
    <?php 
       if(($used >= $limit) && (strtolower($user_type) == 'client') ){
?>
           <div class="error_msg" style="display:block;">
               <img style="position:relative;top:4px;" src="<?php  echo IMAGE; ?>red_cross.png" alt="red_cross.png"/><span>
               Sorry! Your SMS limit exceeded. Please contact with system provider.
               </span>
           </div>
<?php  }else{ ?>
    
    <div class="success_msg" style="display:<?php if(isset($error) && $error==0){ echo 'block'; }else{ echo 'none';}?>">
        <img style="position:relative;top:4px;" src="<?php  echo IMAGE; ?>green_tick_16x16.png" alt="green_tick.png"/> Successfully Message sent.
    </div>
    
    <div class="error_msg" style="display:<?php if($error==1 || $error==2){ echo 'block'; }else{ echo 'none';}?>">
        <img style="position:relative;top:4px;" src="<?php  echo IMAGE; ?>red_cross.png" alt="red_cross.png"/><span> Message Sent Failed.
        <?php if($error==1){ echo ' File did not uploaded';} ?>
        <?php if($error==2){ echo ' Only CSV File can be upload';} ?>
        </span>
    </div>
    
    <div id="tabs">
        <ul>
        <li><a href="#tabs-1">Single SMS</a></li>
        <li><a href="#tabs-2">Bulk SMS</a></li>
<!--        <li><a href="#tabs-3">Aenean lacinia</a></li>-->
        </ul>
        <div id="tabs-1">
            <form id="singleSmsFrm" action="<?php echo BASE ?>dashboard/sms_sent" method="post">
                <p>
                    <label>Number:</label>
                    <input type="text" name="number" class="input-medium"/>
                </p>
                <p>
                    <label>Sender:</label>
                    <select name="subject" class="input-medium">
                        <?php 
                            if(!empty($masking)){
                                foreach($masking as $m){
                                    echo '<option value="'.$m['masking'].'">'.$m['masking'].'</option>';
                                }
                            }
                        ?>
                       
                    </select>
                </p>
                <p>
                    <label>Message:</label>
                    <textarea maxlength="480" name="message" style="resize:none;width:350px;height:85px;" ></textarea>
                </p>
                <p>
                    <label>Characters:</label>
                    <span id="countMsg">0</span>  
                    
                    <span style="color:tomato;" id="single_smsCount"></span>
                </p>
                <p>
                    <label>Schedule:</label><input type="checkbox" name="schedule_status" value="1"/>
                    <input type="text" id="ss_date" class="input-small" name="ss_date" disabled="disabled" style="display:none;" value="<?php echo date('m/d/Y'); ?>"/>
                    <span id="hrs" style="display:none;">
                        Hour:<select name="hour" style="width:50px;" disabled="disabled">
                        <?php 
                            for($hour=0;$hour<24;$hour++)
                            {
                                $hour = ($hour<10)? '0'.$hour : $hour;
                                echo '<option>'.$hour.'</option>';
                            }
                        ?>
                    </select>
                    </span>
                    <span id="min" style="display:none;">
                    Minute:<select name="min" style="width:50px;" disabled="disabled">
                        <?php 
                            for($min=0;$min<59;$min++)
                            {
                                $min = ($min<10)? '0'.$min : $min;
                                echo '<option>'.$min.'</option>';
                            }
                        ?>
                    </select>
                    </span>
                    <span id="sec" style="display:none;">
                    Second:<select name="sec" style="width:50px;" disabled="disabled">
                        <?php 
                            for($sec=0;$sec<59;$sec++)
                            {
                                $sec = ($sec<10)? '0'.$sec : $sec;
                                echo '<option>'.$sec.'</option>';
                            }
                        ?>
                    </select>
                    </span>
                </p>
                <br/>
                <p>
                    <label>&nbsp;</label>
                    <input type="submit" class="btn" value="Send"/>
                    <input type="reset" class="btn" value="Reset"/>
                </p>
            </form>
        </div>
        <div id="tabs-2">
            <form id="bulkSmsFrm" enctype="multipart/form-data" action="<?php echo BASE ?>dashboard/bulk_sms_sent" method="post">
                <p>
                    <label>Numbers:</label>
                    <input type="file" name="numberfile" class="input-large"/>
                    <small>(only csv file)</small>
                </p>
                <p>
                    <label>Sender:</label>
                    <select name="subject" class="input-medium">
                        <?php 
                            if(!empty($masking)){
                                foreach($masking as $m){
                                    echo '<option value="'.$m['masking'].'">'.$m['masking'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <label>Message:</label>
                    <textarea maxlength="480" name="message" style="resize:none;width:350px;height:85px;" ></textarea>
                </p>
                <p>
                    <label>Characters:</label>
                    <span id="countMsg">0</span>
                    <span style="color:tomato;" id="bulk_smsCount"></span>
                </p>
                <p>
                    <label>Schedule:</label><input type="checkbox" name="schedule_status" value="1"/>
                    <input type="text" id="bs_date" name="bs_date" class="input-small" disabled="disabled" style="display:none;" value="<?php echo date('m/d/Y'); ?>"/>
                    <span id="bhrs" style="display:none;">
                    Hour:<select name="hour" style="width:50px;" disabled="disabled">
                        <?php 
                            for($hour=0;$hour<24;$hour++)
                            {
                                $hour = ($hour<10)? '0'.$hour : $hour;
                                echo '<option>'.$hour.'</option>';
                            }
                        ?>
                    </select>
                    </span>
                    <span id="bmin" style="display:none;">
                    Minute:<select name="min" style="width:50px;" disabled="disabled">
                        <?php 
                            for($min=0;$min<59;$min++)
                            {
                                $min = ($min<10)? '0'.$min : $min;
                                echo '<option>'.$min.'</option>';
                            }
                        ?>
                    </select>
                    </span>
                    <span id="bsec" style="display:none;">
                    Second:<select name="sec" style="width:50px;" disabled="disabled">
                        <?php 
                            for($sec=0;$sec<59;$sec++)
                            {
                                $sec = ($sec<10)? '0'.$sec : $sec;
                                echo '<option>'.$sec.'</option>';
                            }
                        ?>
                    </select>
                    </span>
                </p>
                <br/>
                <p>
                    <label>&nbsp;</label>
                    <input type="submit" class="btn" value="Send"/>
                    <input type="reset" class="btn" value="Reset"/>
                </p>
            </form>
        </div>
<!--        <div id="tabs-3">
        <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
        <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
        </div>-->
    </div>
<?php } ?>
</fieldset>
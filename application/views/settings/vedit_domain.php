<fieldset>
    <legend>Edit Domain</legend>
    <form id="updateDomainFrm">
        <p>
            <label>Domain Name: </label>
            <input type="text" name="name" value="<?php echo $domain['name']; ?>" class="input-medium"/>
        </p>
        <p>
            <label>Link: </label>
            <input type="text" name="link" value="<?php echo $domain['link']; ?>" class="input-large"/>
        </p>
        <hr/>
        <p>
            <input type="hidden" name="domain_id" value="<?php echo $domain['domain_id']; ?>"/>
            <input type="button" id="updateDomainBtn" class="btn" value="Update"/>
        </p>
    </form>
</fieldset>
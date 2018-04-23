<select class="logout" id="languages">
    <?php
    foreach (L10NAvail as $lang) { ?>
        <option value="<?= $lang["abr"] ?>" <?php if($lang["abr"] == $params["lang"]) echo "selected" ?>><?= $lang["language"] ?></option>
    <?php } ?>
</select>
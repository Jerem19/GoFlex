<select id="languages">
    <?php
    foreach (L10NAvail as $lang) { ?>
        <option value="<?= $lang["abr"] ?>" <?php if($lang["abr"] == $_SESSION["lang"]) echo "selected" ?>><?= $lang["language"] ?></option>
    <?php } ?>
</select>
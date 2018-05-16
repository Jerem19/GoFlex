<div class="row mt col-lg-12 form-panel">
    <form class="form-horizontal style-form" id="formCheckUserData" method="post">

        <label class="control-label col-sm-12" style="font-size: x-large;"><?= L10N['index']['checkUserData']['chooseUser']?></label>

        <select name="clientNumber" class="col-sm-8 form-control">
            <?php
            foreach($user->getAllUser() as $valueUser)
            {
                echo "<option value=" . $valueUser['userid'] .">" . $valueUser['username'] . "</option>";
            }
            ?>
        </select>








    </form>
</div>


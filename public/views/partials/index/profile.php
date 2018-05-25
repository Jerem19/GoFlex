<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['profile']?>
</div>

<div class="row mt col-lg-12 form-panel" style="margin-bottom: 40px;">
    <form class="form-horizontal style-form" id="formUpdateProfile" method="post">
        <label class="control-label col-sm-4"><?= L10N['index']['profile']['firstname']?></label><input class="col-sm-8 form-control" disabled="disabled" value="<?= $user->getFirstname() ?>" name="firstname" />

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['lastname']?></label><input class="col-sm-8 form-control" disabled="disabled" value="<?= $user->getLastname() ?>" name="lastname" />

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['phone']?></label><input class="col-sm-8 form-control" type="number" value="<?= $user->getPhone() ?>" name="phone"/>

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['email']?></label><input disabled="disabled" class="col-sm-8 form-control" value="<?= $user->getEmail() ?>" name="email" />

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['username']?></label><input style="margin-bottom: 20px;" disabled="disabled" class="col-sm-8 form-control" value="<?= $user->getUsername() ?>" name="username" />

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['profile']['update']?></button>

    </form>
</div>

<script>
    window.onload = function() {
        $("#formUpdateProfile").submit(function (event) {
            att = $(this).serialize();
            $.post("updateProfile", att, function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data) {
                    alert("<?= L10N['index']['profile']['alertUpdateUserSuccess']?>");
                }
                else {
                    alert("<?= L10N['index']['profile']['alertUpdateUserFailed']?>");
                }
            });
            return false;
        });
    }
</script>
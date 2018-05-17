<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formAddUser" method='post'>

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['firstname']?></label>
        <input required="required" class="col-sm-8 form-control" name="firstname" />

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['lastname']?></label>
        <input required="required" class="col-sm-8 form-control" name="lastname" />

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['phone']?></label>
        <input type="number" class="col-sm-8 form-control" name="phone" />

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['email']?></label>
        <input type="email" required="required" class="col-sm-8 form-control" name="email"/>

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['username']?></label>
        <input required="required" type="text" class="col-sm-8 form-control" name="username"/>

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['gatewayName']?></label>
        <input required="required" type="text" style="margin-bottom: 20px;" class="col-sm-8 form-control" value="goflex-dc-" name="gatewayname"/>

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['profile']['create']?></button>

    </form>
</div>

<script>
    window.onload = function() {

        $("#formAddUser").submit(function (event) {
            att = $(this).serialize();

            $.post("create", att, function (data) {
                console.log(data);
                data = JSON.parse(data);

                if (data) {
                    alert("<?= L10N['index']['profile']['alertCreateUserSuccess']?>");
                    window.location.reload();
                }
                else {
                    alert("<?= L10N['index']['profile']['alertCreateUserFailed']?>");
                }
            });
            return false;
        });
    }
</script>
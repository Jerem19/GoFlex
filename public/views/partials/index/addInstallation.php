<div class="row mt col-lg-12 form-panel">
    <form class="form-horizontal style-form" id="formAddInstallation" method="post">
        <label class="control-label col-sm-4"><?= L10N['index']['addInstallation']['macAddress']?></label><input required="required" class="col-sm-8 form-control" name="mac" />

        <label class="control-label col-sm-4"><?= L10N['index']['addInstallation']['name']?></label><input required="required" style="margin-bottom: 20px;" class="col-sm-8 form-control" name="name" />

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['profile']['create']?></button>
    </form>
</div>


<script>
    window.onload = function() {

        $("#formAddInstallation").submit(function (event) {
            att = $(this).serialize();
            $.post("createInstallation", att, function (data) {
                data = JSON.parse(data);

                if (data) {
                    alert("<?= L10N['index']['addInstallation']['alertCreateInstallationSuccess']?>");
                    window.location.reload();
                }
                else {
                    alert("<?= L10N['index']['addInstallation']['alertCreateInstallationFailed']?>");
                }
            });
            return false;
        });
    }
</script>
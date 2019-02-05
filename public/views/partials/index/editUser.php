<div id="loading" style="display: none;"></div>
<div class="row mt col-lg-12 form-panel">
    <h2 class="head-title"><?= L10N['index']['sidebar']['editUser'] ?></h2>
</div>

<div class="row mt form-panel">
    <label class="control-label"><?= L10N['index']['checkUserData']['chooseUser'] ?></label>

    <select name="userUsername" class="form-control">
        <?php
        $gws = $isInstall ? Gateway::getAllReady() : Gateway::getAllInstalled();
        foreach ($gws as $gw) { ?>
            <option value="<?= $gw->getInstallation()->getUser()->getId() ?>"><?= $gw->getName() ?>
                [<?= $gw->getInstallation()->getUser()->getUsername() ?>]
            </option>
        <?php } ?>
    </select>
</div>

<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formEditUser" method='post'>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['username'] ?></label>
            <input required class=" form-control" name="username"/>
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['firstname'] ?></label>
            <input required class=" form-control" name="firstname"/>
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['lastname'] ?></label>
            <input required class=" form-control" name="lastname"/>
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['phone'] ?></label>
            <input type="number" class=" form-control" name="phone"/>
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['email'] ?></label>
            <input type="email" required class=" form-control" name="email"/>
        </div>

        <input class="btn btn-theme02 btn-block" type="submit" value="<?= L10N['index']['profile']['update'] ?>">
    </form>
</div>

<script>
    window.onload = function () {
        var selectUser = $('select[name="userUsername"]');
        var loadingDiv = document.getElementById('loading');

        selectUser.on("change",function () {
            $.ajax({
                url: 'userInfo',
                type: 'POST',
                data: { id : $(this).val() },
                beforeSend: function () {
                    $('input').prop('disabled', true);
                    loadingDiv.style.display = 'block';
                }, success : function (data) {

                    if (data) for (var d in data) $(`[name="${d}"]`).val(data[d]);
                    else console.error("No data");

                    loadingDiv.style.display = 'none';
                    $('input').prop('disabled', false);
                }
            });
        }).change();

        $("#formEditUser").submit(function () {
            var data = $(this).serialize() + `&id=${selectUser.val()}`;
            console.log(data);
            $.post("edit", data, function (data) {
                if (JSON.parse(data)) {
                    alert("<?= L10N['index']['profile']['alertUpdateUserSuccess']?>");
                    window.location.reload();
                }
                else alert("<?= L10N['index']['profile']['alertUpdateUserFailed']?>");
            });

            return false;
        });
    }
</script>
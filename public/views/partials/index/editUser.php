<div id="loading" style="display: none;"></div>
<div class="row mt col-lg-12 form-panel">
    <h2 class="head-title"><?= L10N['index']['sidebar']['editUser'] ?></h2>
</div>

<div class="row mt form-panel">
    <label class="control-label"><?= L10N['index']['checkUserData']['chooseUser'] ?></label>

    <select name="userId" class="form-control">
        <?php
        $gws = $isInstall ? Gateway::getAllReady() : Gateway::getAllInstalled();
        foreach ($gws as $gw) { ?>
            <option value="<?= $gw->getInstallation()->getUser()->getId() ?>">
                <?= $gw->getName() ?> [<?= $gw->getInstallation()->getUser()->getUsername() ?>]
            </option>
        <?php } ?>
    </select>
</div>

<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formEditUser" method='post'>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['username'] ?></label>
            <input required class="form-control" name="username" />
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['firstname'] ?></label>
            <input class="form-control" name="firstname" />
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['lastname'] ?></label>
            <input class="form-control" name="lastname" />
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['phone'] ?></label>
            <input type="number" class="form-control" name="phone" />
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['email'] ?></label>
            <input required type="email" class="form-control" name="email" />
        </div>

        <input class="btn btn-theme02 btn-block" type="submit" value="<?= L10N['index']['profile']['update'] ?>">
    </form>
</div>

<script>
    window.onload = function () {
        var selectUser = $('select[name="userId"]'),
            txtUsername = $('input[name="username"]');
        var loadingDiv = document.getElementById('loading');

        function testUsername(callback = new Function()) {
            $.post('user_exist', "user=" + txtUsername.val(), function (response) {
                if (JSON.parse(response))
                    $.gritter.add({
                        text: "error: Username already exist"
                    });
                else callback();
            });
        }

        txtUsername.on('change', function () {
            testUsername();
        });

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
            var postData = $(this).serialize() + `&id=${selectUser.val()}`;
            testUsername(function() {
                $.post("edit", postData, function (data) {
                    if (JSON.parse(data)) {
                        alert("<?= L10N['index']['profile']['alertUpdateUserSuccess']?>");
                        window.location.reload();
                    }
                    else alert("<?= L10N['index']['profile']['alertUpdateUserFailed']?>");
                });
            });
            return false;
        });
    }
</script>
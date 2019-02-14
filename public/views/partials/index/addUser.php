<div class="row mt col-lg-12 form-panel">
    <h2 class="head-title"><?= L10N['index']['sidebar']['creationUser'] ?></h2>
</div>

<div class="row mt col-lg-12 form-panel">
    <form class='form-horizontal style-form' id="formAddUser" method='post'>

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

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['username'] ?></label>
            <input required type="text" class=" form-control" name="username"/>
        </div>

        <div class="col-sm-12">
            <label class="control-label"><?= L10N['index']['profile']['role'] ?></label>
            <select id="role" style="margin-bottom: 10px;" name="role" class=" form-control"
                    onChange="disabledOrEnable()">
                <?php foreach (Role::getAll() as $role) { ?>
                    <option value="<?= $role->getId() ?>" <?php if ($role->getId() == 4) echo "selected"; ?>><?= $l10n["profile"][$role->getName()] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-sm-12">
            <label class="control-label">goflex-dc-xxx</label>
            <input required id="gatewayname" type="number" class=" form-control user-only" name="gatewayname"/>
        </div>

        <div class="col-sm-12">
            <label class=" control-label"><?= $l10n['installation']['address'] ?></label>
            <input required class=" form-control user-only" name="address"/>
        </div>

        <div class="col-sm-12">
            <label class=" control-label"><?= $l10n['installation']['npa'] ?></label>
            <input required type="number" class=" form-control user-only" name="npa"/>
        </div>

        <div class="col-sm-12">
            <label class=" control-label"><?= $l10n['installation']['city'] ?></label>
            <input required class=" form-control user-only" name="city"/>
        </div>

        <div class="col-sm-12">
            <label class=" control-label"><?= $l10n['installation']['adminNote'] ?></label>
            <textarea class=" form-control user-only" name="adminNote" style="margin-bottom: 20px;"></textarea>
        </div>
        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['profile']['create'] ?></button>
    </form>
</div>

<script>


    window.onload = function () {
        var gwId = document.getElementById('gatewayname'),
            txtUsername = $('input[name="username"]');

        function testGateway(callback = new Function()) {
            $.post('gw_exist', "gw=goflex-dc-" + gwId.value, function (response) {
                if (JSON.parse(response))
                    $.gritter.add({
                        text: "error: Gateway already exist"
                    });
                else callback();
            });
        }

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

        gwId.onchange = function () {
            testGateway();
        };

        $("#formAddUser").submit(function () {
            var form = $(this);
            var data = form.serialize();
            testUsername(function() {
                testGateway(function () {
                    $.post("create", data, function (data) {
                        var msg = "";
                        if (JSON.parse(data)) {
                            msg = "<?= L10N['index']['profile']['alertCreateUserSuccess']?>";
                            form.trigger("reset");
                        }
                        else msg = "<?= L10N['index']['profile']['alertCreateUserFailed']?>";
                        $.gritter.add({
                            text: msg
                        });
                    });
                });
            });
            return false;
        });

        var firstName = $('input[name="firstname"]'),
            lastName = $('input[name="lastname"]');
        firstName.add(lastName).on('change', function () {
            //https://stackoverflow.com/questions/990904/remove-accents-diacritics-in-a-string-in-javascript
            $('input[name="username"]').val((firstName.val().toLowerCase() + "." + lastName.val().toLowerCase()).replace(/\s/g, '').normalize('NFD').replace(/[\u0300-\u036f]/g, ""));
        })
    };

    var inputsUser = document.getElementsByClassName('user-only');
    function disabledOrEnable() {
        for (var i in inputsUser)
            inputsUser.item(i).disabled = !(document.getElementById("role").value == 4);
    }
    disabledOrEnable();

</script>
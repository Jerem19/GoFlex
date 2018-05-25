<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['creationUser']?>
</div>

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

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['role']?></label>
        <select id="role" name="role" class="col-sm-8 form-control" onChange="disabledOrEnable()">
            <?php foreach (Role::getAll() as $role) {?>
                <option value="<?= $role->getId() ?>" <?php if ($role->getId() == 4) echo "selected"; ?>><?= $l10n["profile"][$role->getName()] ?></option>
            <?php } ?>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['gatewayName']?></label>
        <input id="gatewayname" type="text" style="margin-bottom: 20px;" class="col-sm-8 form-control" value="goflex-dc-" name="gatewayname"/>

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['profile']['create']?></button>

    </form>
</div>

<script>
    var gwId = document.getElementById('gatewayname');
    window.onload = function() {
        function testGateway(callback = new Function()) {
            $.post('gw_exist', "gw="+ gwId.value, function(response) {
                if (JSON.parse(response))
                    $.gritter.add({
                        text: "error: already exist"
                    });
                else callback();
            });
        }

        gwId.onchange = function() { testGateway(); };

        $("#formAddUser").submit(function () {
            var data = $(this).serialize();
            testGateway(function() {
                $.post("create", data, function (data) {
                    data = JSON.parse(data);
                    if (data) {
                        alert("<?= L10N['index']['profile']['alertCreateUserSuccess']?>");
                        window.location.reload();
                    }
                    else alert("<?= L10N['index']['profile']['alertCreateUserFailed']?>");
                });
            });
            return false;
        });

        var firstName = $('input[name="firstname"]'),
            lastName = $('input[name="lastname"]');
        firstName.add(lastName).on('change', function() {
            //https://stackoverflow.com/questions/990904/remove-accents-diacritics-in-a-string-in-javascript
            $('input[name="username"]').val((firstName.val().toLowerCase() + "." + lastName.val().toLowerCase()).normalize('NFD').replace(/[\u0300-\u036f]/g, ""));
        })
    };

    function disabledOrEnable() {
        if (document.getElementById("role").value == 4) {
            gwId.value = "goflex-dc-";
            gwId.disabled = false;
        } else {
            gwId.value = "";
            gwId.disabled = true;
        }
    }
    disabledOrEnable();

</script>
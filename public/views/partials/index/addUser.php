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
            <option value="4"><?= L10N['index']['profile']['user']?></option>
            <option value="1"><?= L10N['index']['profile']['admin']?></option>
            <option value="2"><?= L10N['index']['profile']['technical']?></option>
            <option value="3"><?= L10N['index']['profile']['hotline']?></option>
        </select>

        <label class="control-label col-sm-4"><?= L10N['index']['profile']['gatewayName']?></label>
        <input id="gatewayname" type="text" style="margin-bottom: 20px;" class="col-sm-8 form-control" value="goflex-dc-" name="gatewayname"/>

        <button class="btn btn-theme02 btn-block" type="submit"><?= L10N['index']['profile']['create']?></button>

    </form>
</div>

<script>
    window.onload = function() {

        $("#formAddUser").submit(function () {
            var att = $(this).serialize();

            $.post("create", att, function (data) {
                data = JSON.parse(data);
                if (data) {
                    alert("<?= L10N['index']['profile']['alertCreateUserSuccess']?>");
                    window.location.reload();
                }
                else
                    alert("<?= L10N['index']['profile']['alertCreateUserFailed']?>");
            });
            return false;
        });

        var firstName = $('input[name="firstname"]'),
            lastName = $('input[name="lastname"]');
        firstName.add(lastName).on('change', function() {
            $('input[name="username"]').val(firstName.val().toLowerCase() + "." + lastName.val().toLowerCase());
        })
    }



    function disabledOrEnable() {
        if(document.getElementById("role").value < 4) {

            document.getElementById("gatewayname").value = "";
            document.getElementById("gatewayname").disabled = true;
        }
        if(document.getElementById("role").value == 4) {
            document.getElementById("gatewayname").value = "goflex-dc-";
            document.getElementById("gatewayname").disabled = false;
        }
    }

</script>
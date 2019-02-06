<div class="row mt col-lg-12 form-panel" style="margin-bottom: 10px; text-align: center; font-size: xx-large;">
    <?= L10N['index']['sidebar']['allUsers']?>
</div>

<div class="row mt col-lg-12 form-panel" style="overflow-x:auto;">
    <table style="width: 100%;">
        <tr>
            <th><?= L10N['index']['profile']['firstname']?></th>
            <th><?= L10N['index']['profile']['lastname']?></th>
            <th><?= L10N['index']['profile']['email']?></th>
            <th><?= L10N['index']['profile']['username']?></th>
            <th><?= L10N['index']['profile']['role']?></th>
            <th><?= L10N['index']['profile']['gatewayName']?></th>
            <th><?= L10N['index']['profile']['active']?></th>
        </tr>
        <?php foreach (User::getAll() as $user) { ?>
            <tr>
                <td><?= $user->getFirstname()?></td>
                <td><?= $user->getLastname()?></td>
                <td><?= $user->getEMail()?></td>
                <td><?= $user->getUsername()?></td>
                <td><?= $user->getRole()?></td>
                <?php if(count($user->getInstallations()) > 0 ) { ?>
                    <td><?= $user->getInstallations()[0]->getGateway()->getName() ?></td>
                <?php } else echo "<td>No Gateway</td>"; ?>

                <td><?= L10N['index']['installation'][$user->isActive() ? 'yes' : 'no'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
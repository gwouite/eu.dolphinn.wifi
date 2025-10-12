<?php if (!defined('SPLASH-VD')) exit(); ?>
<?php
include dirname(__FILE__).'/_header.tpl';
?>
<form name="frmJK" action="login?<?php echo $params_query; ?>" method="post">
<section id="main">
    <div class="divContent">
        <div class="spacer"></div>
        <h1>Connexion au réseau Wifi</h1>
        <h1 class="alt">Connect to Wifi network</h1>
        <div class="spacer"></div>

        <p style="text-align:center;">
            <label for="vd_code"><strong>Code d'accès / Access code : </strong></label><input type="text" value="" id="vd_code" name="vd_code" style="width: 100px;" />
            <?php
            if (isset($params['vd_errcode'])) {
                ?>
                <strong class="err">
                        <br />
                        <br />
                        Merci d'entrer un code d'accès valide.<br />
                        Please enter a valid access code.
                </strong>
                <?php
            }
            ?>
            <br />
        </p>
        <div class="spacer"></div>

        <p style="text-align: center;">
            <input type="submit" class="bt" name="vd_balid" value="Connexion / Connect" />
        </p>
    </div>
</section>
</form>
<?php
include dirname(__FILE__).'/_footer.tpl';
?>
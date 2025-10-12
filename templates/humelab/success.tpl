<?php if (!defined('SPLASH-VD')) exit(); ?>
<?php
include dirname(__FILE__).'/_header.tpl';
?>
<section id="main">
    <div class="divContent">
        <div class="spacer"></div>
        <h1>Vous êtes connecté à Internet.</h1>
        <h1 class="alt">You are now connected to the Internet.</h1>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <p style="text-align: center;">
            <a href="https://www.google.fr/" class="bt">Aller sur Google</a>
        </p>
        <div class="spacer"></div>
        <p style="text-align: center;">
            Vous pouvez vous déconnecter en cliquant sur le lien ci-dessous.
        </p>
        <p class="alt" style="text-align: center;">
            To disconnect at any time, you can click the link below.
        </p>
        <div class="spacer"></div>
        <p style="text-align: center;">
            <a href="logout?<?php echo $params_query; ?>" class="bt">Déconnexion / Disconnect</a>
        </p>
    </div>
</section>
<?php
include dirname(__FILE__).'/_footer.tpl';
?>
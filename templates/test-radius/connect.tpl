<?php if (!defined('SPLASH-VD')) exit(); ?>
<?php
include dirname(__FILE__).'/_header.tpl';
?>
<form name="frmMk" id="frmMkt" action="login?<?php echo $params_query; ?>" method="post">
<input type="hidden" name="type" id="submitType" value="free" />
<input type="hidden" name="decoFirst" id="decoFirst" value="0" />
<section id="main">
    <div class="divContent" style="text-align:center;">
		<h1>Connexion au réseau Wifi</h1>
		<h1 class="alt">Connect to Wifi network</h1>
		
		<div class="spacer"></div>
		<p style="text-align:center;">
			Choix du mode de connexion :
		</p>
		<div class="spacer"></div>
		<div style="margin: 20px; padding: 10px; display: inline-block; width: 150px; height: 150px; border: 1px #ffffff solid; text-align: center; cursor: pointer" onclick="submitType('free')">
			<br />Accès simple<br />
			<h2>1mbps</h2>
			<h4>24 heures</h4>
		</div>
		<div style="margin: 20px; padding: 10px; display: inline-block; width: 150px; height: 150px; border: 1px #ffffff solid; text-align: center; cursor: pointer" onclick="submitType('plus')">
			<br />Accès plus<br />
			<h2>15mbps</h2>
			<h4>12 heures</h4>
		</div>
		<div style="margin: 20px; padding: 10px; display: inline-block; width: 150px; height: 150px; border: 1px #ffffff solid; text-align: center; cursor: pointer" onclick="submitType('super')">
			<br />Accès super<br />
			<h2>sans limite</h2>
			<h4>20 minutes</h4>
		</div>
	</div>
    
</section>
</form>

<script language="javascript">
	function submitType(type) {

		document.getElementById('submitType').value = type;
		document.getElementById('frmMkt').submit();
	}
	(function() {
		<?php

		if (isset($_GET['type'])) {
			?>		
			document.getElementById('submitType').value = "<?php echo $_GET['type']; ?>";
			<?php
		}

		if (isset($_GET['err']) && $_GET['err'] == 'ERR_DEVICE_LIMIT') {
			?>		
			if (confirm("Voulez-vous déconnecter le plus ancien device connecté ?")) {
				document.getElementById('decoFirst').value = "1";
				document.getElementById('frmMkt').submit();
			}
			<?php
		}
		?>
	})();
</script>
<?php
include dirname(__FILE__).'/_footer.tpl';
?>
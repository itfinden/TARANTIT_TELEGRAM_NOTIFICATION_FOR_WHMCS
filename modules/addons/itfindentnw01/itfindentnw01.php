<?php

if (!defined("WHMCS")) {
	die("This file cannot be accessed directly");
}
function itfindentnw01_config() {
	$configarray = array(
		"name" => "itfindentnw01 Telegram Notifications for WHMCS",
		"description" => "Este es un desarrollo de ITFINDEN CORP",
		"version" => "1.0",
		"author" => "Itfinden Corp",
		"language" => "english",
		#"fields" => array(
		#"key" => array ("FriendlyName" => "ITFINDEN API", "Type" => "text", "Size" => "50", "Description" => "", "Default" => "", ),

		"fields" => array(
			"key" => array("FriendlyName" => "Itfinden Token", "Type" => "text", "Size" => "50", "Description" => "Token de ITFINDEN ", "Default" => "DEMO"),

			"BotId" => array("FriendlyName" => "Bot ID", "Type" => "text", "Size" => "50", "Description" => "Bot Id de Telegram", "Default" => ""),

			"chatid" => array("FriendlyName" => "Chat ID", "Type" => "text", "Size" => "50", "Description" => "Ingresa el codifo de tu chat telegram ", "Default" => ""),

		));
	return $configarray;
}

function itfindentnw01_activate() {
	$query = "CREATE TABLE IF NOT EXISTS `itfindentnw01` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `adminid` int(11) NOT NULL,
    `access_token` varchar(255) NOT NULL,
    `permissions` text NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;";
	$result = mysql_query($query);
}

function itfindentnw01_deactivate() {
	$query = "DROP TABLE `itfindentnw01`";
	$result = mysql_query($query);
}

function itfindentnw01_output($vars) {
	global $customadminpath, $CONFIG;

	$access_token = select_query('itfindentnw01', '', array('adminid' => $_SESSION['adminid']));

	if ($_GET['return'] == '1' && $_SESSION['request_token']) {

		#$response = curlCall("https://notiapp.com/api/v1/get_access_token",array('app' => $vars['key'], 'request_token' => $_SESSION['request_token']));
		$response = curlCall("https://itfinden.free.beeceptor.com/get_access_token", array('app' => $vars['key'], 'request_token' => $_SESSION['request_token']));

		$result = json_decode($response, true);
		insert_query("itfindentnw01", array("adminid" => $_SESSION['adminid'], "access_token" => $result['access_token']));
		$_SESSION['request_token'] = "";
		curlCall("https://notiapp.com/api/v1/add", array('app' => $vars['key'], 'user' => $result['access_token'], "notification[title]" => "WHMCS is ready to go!", "notification[text]" => "You will now receive WHMCS notifications directly to your desktop", "notification[sound]" => "alert1"));
		header("Location: addonmodules.php?module=itfindentnw01");

	} elseif ($_GET['setup'] == '1' && !mysql_num_rows($access_token)) {

		#$response = curlCall("https://notiapp.com/api/v1/request_access",array('app' => $vars['key'], 'redirect_url' => $CONFIG['SystemURL']."/".$customadminpath."/addonmodules.php?module=itfindentnw01&return=1"));
		$response = curlCall("https://itfinden.free.beeceptor.com/", array('app' => $vars['key'], 'redirect_url' => $CONFIG['SystemURL'] . "/" . $customadminpath . "/addonmodules.php?module=itfindentnw01&return=1"));

		$result = json_decode($response, true);

		if ($result['request_token'] && $result['redirect_url']) {

			$_SESSION['request_token'] = $result['request_token'];
			header("Location: " . $result['redirect_url']);

		} else {
			echo "<div class='errorbox'><strong>Incorrecta API Key</strong></br>Incorrecta ITFINDEN API Key Informada.  </div>";
		}
	} elseif ($_GET['disable'] == '1' && mysql_num_rows($access_token)) {
		full_query("DELETE FROM `itfindentnw01` WHERE `adminid` = '" . $_SESSION['adminid'] . "'");
		echo "<div class='infobox'><strong>Se Desactivo itfindentnw01</strong></br>se ha desactivado itfindentnw01.</div>";
	} elseif (mysql_num_rows($access_token) && $_POST) {
		update_query('itfindentnw01', array('permissions' => serialize($_POST['notification'])), array('adminid' => $_SESSION['adminid']));
		echo "<div class='infobox'><strong>Se ha Actualizado itfindentnw01</strong></br>Se logro actualizar la Informacion.</div>";
	}

	$access_token = select_query('itfindentnw01', '', array('adminid' => $_SESSION['adminid']));
	$result = mysql_fetch_array($access_token, MYSQL_ASSOC);
	$permissions = unserialize($result['permissions']);

	$modulos = [
		["new_client", "Nuevos Clientes"],
		["new_invoice", "Pagar Facturas"],
		["new_ticket", "Nuevo Ticket"],
		["new_update", "Nuevo Tickets Respuestas"],
		["log", "Nuevo log "],
	];

	if (!mysql_num_rows($access_token)) {
		echo "<p><a href='addonmodules.php?module=itfindentnw01&setup=1'>Configurar itfindentnw01</a></p>";
	} else {
		echo "<p><a href='addonmodules.php?module=itfindentnw01&disable=1'>Desabilitar itfindentnw01</a></p>";

		echo '<form method="POST"><table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td class="fieldlabel" width="200px">Notificaciones</td>
      <td class="fieldarea">
      <table width="100%">
        <tr>
           <td valign="top">';

		foreach ($modulos as $mod) {
			echo '<input type="checkbox" name="notification[' . $mod[0] . ']" value="1" id="notifications_' . $mod[0] . '" ' . ($permissions[$mod[0]] == "1" ? "checked" : "") . '> <label for="notifications_' . $mod[0] . '">' . $mod[1] . '</label><br>';
		}

		echo '  </td>
         </tr>

    </table>
  </table>

  <p align="center"><input type="submit" value="Grabar Cambios" class="button"></p></form>';
	}

}

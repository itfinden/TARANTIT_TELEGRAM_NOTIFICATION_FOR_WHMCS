<?php

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

function itfindentnw01_config() {
    $configarray = array(
    "name" => "itfindentnw01 Telegram Notifications for WHMCS",
    "description" => "Este huea lo cree yo",
    "version" => "1.0",
    "author" => "Itfinden Corp",
    "language" => "english",
    "fields" => array(
        "key" => array ("FriendlyName" => "ITFINDEN API", "Type" => "text", "Size" => "50", "Description" => "", "Default" => "", ),
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
 
  if ( $_GET['return'] == '1' && $_SESSION['request_token'] ) {    
    
    $response = curlCall("https://notiapp.com/api/v1/get_access_token",array('app' => $vars['key'], 'request_token' => $_SESSION['request_token']));
    
    $result = json_decode($response, true);    
    insert_query("itfindentnw01", array("adminid" => $_SESSION['adminid'], "access_token" => $result['access_token']) );
    $_SESSION['request_token'] = "";
    curlCall("https://notiapp.com/api/v1/add",array('app' => $vars['key'], 'user' => $result['access_token'], "notification[title]" => "WHMCS is ready to go!", "notification[text]" => "You will now receive WHMCS notifications directly to your desktop", "notification[sound]" => "alert1"));
    header("Location: addonmodules.php?module=itfindentnw01");
    
  } elseif($_GET['setup'] == '1' && !mysql_num_rows($access_token)) {
   
    $response = curlCall("https://notiapp.com/api/v1/request_access",array('app' => $vars['key'], 'redirect_url' => $CONFIG['SystemURL']."/".$customadminpath."/addonmodules.php?module=itfindentnw01&return=1"));
    $result = json_decode($response, true);
    
  
    if ($result['request_token'] && $result['redirect_url']) {
        
      $_SESSION['request_token'] = $result['request_token'];
      header("Location: ".$result['redirect_url']);
      
    } else {
      echo "<div class='errorbox'><strong>Incorrecta API Key</strong></br>Incorrecta ITFINDEN API Key Informada.  </div>";
    }
  } elseif( $_GET['disable'] == '1' && mysql_num_rows($access_token) ) {
    full_query("DELETE FROM `itfindentnw01` WHERE `adminid` = '".$_SESSION['adminid']."'");
    echo "<div class='infobox'><strong>Successfully Disabled itfindentnw01</strong></br>You have successfully disabled itfindentnw01.</div>";
  } elseif( mysql_num_rows($access_token) && $_POST ){
    update_query('itfindentnw01',array('permissions' => serialize($_POST['notification'])), array('adminid' => $_SESSION['adminid']));
    echo "<div class='infobox'><strong>Se ha Actualizado itfindentnw01</strong></br>Se logro actualizar la Informacion.</div>";    
  }
  
  $access_token = select_query('itfindentnw01', '', array('adminid' => $_SESSION['adminid']));
  $result = mysql_fetch_array($access_token, MYSQL_ASSOC);
  $permissions = unserialize($result['permissions']);   

  if ( !mysql_num_rows($access_token)) {
    echo "<p><a href='addonmodules.php?module=itfindentnw01&setup=1'>Configurar itfindentnw01</a></p>";
  } else {
    echo "<p><a href='addonmodules.php?module=itfindentnw01&disable=1'>Desabilitar itfindentnw01</a></p>";
    
    echo '<form method="POST"><table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
    <tr>
      <td class="fieldlabel" width="200px">Notificaciones</td>
      <td class="fieldarea">
      <table width="100%">
        <tr>
           <td valign="top">
             <input type="checkbox" name="notification[new_client]" value="1" id="notifications_new_client" '.($permissions['new_client'] == "1" ? "checked" : "").'> <label for="notifications_new_client">Nuevos Clientes</label><br>
             <input type="checkbox" name="notification[new_invoice]" value="1" id="notifications_new_invoice" '.($permissions['new_invoice'] == "1" ? "checked" : "").'> <label for="notifications_new_invoice">Pagar Facturas</label><br>
             <input type="checkbox" name="notification[new_ticket]" value="1" id="notifications_new_ticket" '.($permissions['new_ticket'] == "1" ? "checked" : "").'> <label for="notifications_new_ticket">Nuevo Ticket</label><br>
             <input type="checkbox" name="notification[new_update]" value="1" id="notifications_new_update" '.($permissions['new_update'] == "1" ? "checked" : "").'> <label for="notifications_new_update">Nuevo Tickets Respuestas</label><br>
           </td>
         </tr>
         
    </table>
  </table>
  
  <p align="center"><input type="submit" value="Grabar Cambios" class="button"></p></form>
  ';
  }
  
  

}

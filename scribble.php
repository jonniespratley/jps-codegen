<?php

require_once 'library/CodeGen.php';
$sqlitePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'CodeGen.sqlite';
$codegen = new CodeGen( $sqlitePath );
echo '<pre>';
print_r($codegen->getApps());
echo '</pre>';

if ( isset($_POST['btn_app_save']) )
{
	  
	$result = $codegen->saveApp( $_POST['txt_app_name'],$_POST['txt_app_url'],$_POST['txt_app_config'],$_POST['txt_app_schema']);
	echo $result;
}

if ( isset($_POST['btn_user_save']) )
{
	$result = $codegen->saveUser( $_POST['txt_user_email'],$_POST['txt_user_pass'],$_POST['txt_user_role'] );
	echo $result;
}

if ( isset($_GET['btn_login_save']) )
{
	$result = $codegen->loginUser( $_GET['txt_login_email'], $_GET['txt_login_pass'] );
	print_r( $result );
}

if ( isset($_GET['m'])=='delete')
{
	$result = $codegen->removeApp( $_GET['id'] );
	print_r( $result );
}


?>
<p>&nbsp;</p>
<fieldset>
  <legend>History Form</legend>
  <form id="form_history" name="form_history" method="post" action="">
    <p>
      <label for="txt_history_name">Name:</label>
      <input type="text" name="txt_history_name" id="txt_history_name" />
    </p>
    <p>
      <label for="txt_history_value">Value:</label>
      <input type="text" name="txt_history_value" id="txt_history_value" />
    </p>
    <p>
      <input type="submit" name="btn_history_save" id="btn_history_save" value="Submit" />
    </p>
  </form>

</fieldset>
<p>&nbsp;</p>

<fieldset><legend>Users Form</legend>
  <form id="form_user" name="form_user" method="post" action="">
    <p>
      <label for="txt_user_email">Email:</label>
      <input type="text" name="txt_user_email" id="txt_user_email" />
    </p>
    <p>
      <label for="txt_user_pass">Password:</label>
      <input type="text" name="txt_user_pass" id="txt_user_pass" />
    </p>
    <p>
      <label for="txt_user_role">Role:</label>
      <select name="txt_user_role" id="txt_user_role">
        <option value="0">Developer</option>
        <option value="1">Admin</option>
      </select>
    </p>
    <p>
      <input type="submit" name="btn_user_save" id="btn_user_save" value="Submit" />
    </p>
  </form>
</fieldset>
<p>&nbsp;</p>
<fieldset>
  <legend>Login From</legend>
  <form id="form_login" name="form_login" method="get" action="">
    <p>
      <label for="txt_login_email">Email:</label>
      <input type="text" name="txt_login_email" id="txt_login_email" />
    </p>
    <p>
      <label for="txt_login_pass">Password:</label>
      <input type="text" name="txt_login_pass" id="txt_login_pass" />
    </p>
 
    <p>
      <input type="submit" name="btn_login_save" id="btn_login_save" value="Login" />
    </p>
  </form>
</fieldset>

<p>&nbsp;</p>

<fieldset><legend>Apps Form</legend>
  <form id="form_app" name="form_app" method="get" action="">
    <p>
      <label for="txt_app_name">Name:</label>
      <input type="text" name="txt_app_name" id="txt_app_name" />
    </p>
    <p>
      <label for="txt_app_url">Url:</label>
      <input type="text" name="txt_app_url" id="txt_app_url" />
    </p>
    <p>
      <label for="txt_app_config">Config Path:</label>
      <input type="text" name="txt_app_config" id="txt_app_config" />
    </p>
    <p>
      <label for="txt_app_schema">Schema Path</label>
      <input type="text" name="txt_app_schema" id="txt_app_schema" />
    </p>
    <p>
      <input type="submit" name="btn_app_save" id="btn_app_save" value="Submit" />
    </p>
  </form>
</fieldset>
  <p>&nbsp;</p>
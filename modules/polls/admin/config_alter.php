<?php

$file = fopen("../config.inc.php","w");
fputs($file, "<?php\n\n");

fputs($file, "\$server = '".$server."';\n");
fputs($file, "\$server_var = '".$server_var."';\n\n");

fputs($file, "\$login = '".$login."';\n");
fputs($file, "\$login_var = '".$login_var."';\n\n");

fputs($file, "\$passwd = '".$passwd."';\n");
fputs($file, "\$passwd_var = '".$passwd_var."';\n\n");

fputs($file, "\$database = '".$database."';\n");
fputs($file, "\$database_var = '".$database_var."';\n\n");

fputs($file, "?>");
fclose($file);

header("Location: config_edit.php");
?>
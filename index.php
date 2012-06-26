<?php

require 'Service.php';
$service=new Service();

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Install iOS Apps</title>
<style type="text/css">

li {
    padding: 1em;
}

</style>
</head>
<body>
<ul>
    
    <?php foreach($service->listManifests() as $manifest)
    	echo "<li>".$manifest."</li>";
    	?>
</ul>
<br/><br/><a href="<?php echo $service->provisionFile ?>">Install Team Provisioning File</a>
</body>
</html>
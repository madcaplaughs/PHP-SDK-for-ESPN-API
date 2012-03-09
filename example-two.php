<?php
/**
 * Copyright (c) 2012 Debarshi Kr. Banerjee, Laddu, Madcaplaughs.
 * debarshi dot ban at gmail dot com
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
 
require "espn.php";

$api = new espn();

//get your api key from http://developer.espn.com/member/register
$api->setApiKey("Your-API-Key");

//Function listAllSupportedSports return all the sports supported currently by the ESPN API along with its ID
$allsports = $api->listAllSupportedSports();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESPN API - All Supported Sports</title>
<style type="text/css">
.odd{background:#CCC} .even{background:#FFF}
</style>
</head>

<body>
<h4>All Supported Sports</h4>
<ul>
<?php for($i=0; $i < count($allsports); $i++){ ?>
	<li><?= $allsports[$i]['name'] ?></li>
<?php } ?>
</ul>
</body>
</html>
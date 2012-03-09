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

$headlines = $api->getTopHeadLines();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESPN API - Top Headlines</title>
<style type="text/css">
.odd{background:#CCC} .even{background:#FFF}
</style>
</head>

<body>
<table width="100%" cellspacing="0" cellpadding="10" border="1">
<tr>
 <th>Story</th>
 <th>Last Modified</th>
 <th>Link</th>
</tr>
<?php for($i=0; $i < count($headlines); $i++)  { ?>
	<tr class="<?php if( ($i % 2) == 0 ) echo "even"; else echo "odd"; ?>">
     <td><h4><?= $headlines[$i]['title']; ?></h4><p><?= $headlines[$i]['description']; ?></p></td>
     <td><?= $headlines[$i]['lastModified'] ?></td>
     <td><a href="<?= $headlines[$i]['web_link'] ?>" target="_blank">Read</a></td>
    </tr>
<?php } ?>
</table>
</body>
</html>
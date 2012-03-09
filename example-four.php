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

//Get raw without any filtration
$api->setOutputToRaw();

//Function getNews(Sport Name, Divison Name) requires @param the name of the sport(optional), @param the name of the division(optional) and returns all news listed under it
$raw = $api->getNews('basketball','nba');

echo "<pre>";
var_dump($raw);
echo "</pre>";
?>
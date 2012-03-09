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
 
 /*
 	Version : 0.1
	Beta  
 */
if (!function_exists('json_decode')) {
  die('ESPN needs the JSON PHP extension.');
}

class espn {
	
	protected $apiV = "v1";
	
	protected $apiR = "?apikey=";
	protected $apiKey = "";
	
	protected $uriapi = "http://api.espn.com/";
	
	protected $rawop = false;
	
	public function setApiV($v){
		if (!empty($v)) $this->apiV = $v; 
	}
	
	public function getApiV(){
		return $this->apiV;
	}
	
	public function setApiKey($apikey){
		if (!empty($apikey)) $this->apiKey = $apikey;
	}
	
	public function setOutputToRaw(){
		$this->rawop = true;
	}
	
	public function resetOutput(){
		$this->rawop = false;
	}
	
	public function listAllSupportedSports(){
		$res = $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . $this->apiR . $this->apiKey);
		if ($this->rawop) return $res;
		$toreturn = array(); $i=0;
		foreach($res->{'sports'} as $alls){
			$toreturn[$i]['name'] = $alls->{'name'};
			if (isset($alls->{'id'})) $toreturn[$i]['id'] = $alls->{'id'}; else $toreturn[$i]['id'] = "";
			$i++;
		}
		return $toreturn;
	}
	
	public function listAllLeagues($sport){
		$sport=strtolower($sport);
		if ($this->rawop) return $res;
		$res = $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . $sport . "/" . "leagues" . $this->apiR . $this->apiKey);
		$toreturn = array();
		for($i=0;$i < count($res->{'sports'}[0]->{'leagues'});$i++){
			$toreturn[$i]['name'] = $res->{'sports'}[0]->{'leagues'}[$i]->{'name'};
			$toreturn[$i]['abbr'] = $res->{'sports'}[0]->{'leagues'}[$i]->{'abbreviation'};
			$toreturn[$i]['id'] = $res->{'sports'}[0]->{'leagues'}[$i]->{'id'};
			if (isset($res->{'sports'}[0]->{'leagues'}[$i]->{'shortName'})) $toreturn[$i]['shortName'] = $res->{'sports'}[0]->{'leagues'}[$i]->{'shortName'}; else $toreturn[$i]['shortName'] = "";
		}
		return $toreturn;
	}
	
	public function listAllDivisons($sport,$labbr){
		$sport=strtolower($sport); $labbr=strtolower($labbr);
		return $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . $sport . "/" . $labbr . "/" . "groups" . $this->apiR . $this->apiKey);
	}
	
	public function getHeadLines(){
		$numargs = func_num_args();
		$param = '';
		if ($numargs > 0){
			$arg_list = func_get_args();
			for($i=0; $i < $numargs; $i++)
				$param .= strtolower($arg_list[$i])."/";
		}
		$res = $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . $param  . "news/headlines" . $this->apiR . $this->apiKey);
		if ($this->rawop)
			return $res;
		else
			return $this->streamline($res);
	}
	
	public function getTopHeadLines(){
		$res = $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . "news/headlines/top" . $this->apiR . $this->apiKey);
		if ($this->rawop)
			return $res;
		else
			return $this->streamline($res);
	}
	
	/*
		Expects the first three params to be year, month and date
	*/
	public function getNewsOn(){
		$numargs = func_num_args();
		if ($numargs < 3) return false;
		$param = ''; $arg_list = func_get_args();
		if ($numargs > 3){			
			for($i=3; $i < $numargs; $i++)
				$param .= strtolower($arg_list[$i])."/";
		}
		$yr = $arg_list[0]; $mon = $arg_list[1]; $dat = $arg_list[2];
		$res = $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . $param  . "news/dates/" . $yr . $mon . $dat . $this->apiR . $this->apiKey);
		if ($this->rawop)
			return $res;
		else
			return $this->streamline($res);
	}
	
	public function getNews(){
		$numargs = func_num_args();
		$param = '';
		if ($numargs > 0){
			$arg_list = func_get_args();
			for($i=0; $i < $numargs; $i++)
				$param .= strtolower($arg_list[$i])."/";
		}
		$res = $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . $param  . "news" . $this->apiR . $this->apiKey);
		if ($this->rawop)
			return $res;
		else
			return $this->streamline($res);
	}
	
	public function getTeamNews($id){
		$res =  $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . "teams" . "/" . $id . "/news/" . $this->apiR . $this->apiKey);
		if ($this->rawop)
			return $res;
		else
			return $this->streamline($res);
	}
	
	public function getAtheleteNews($id){
		$res =  $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . "athletes" . "/" . $id . "/news/" . $this->apiR . $this->apiKey);
		if ($this->rawop)
			return $res;
		else
			return $this->streamline($res);
	}
	
	public function getStory($id){
		return $this->espn_get($this->uriapi . $this->apiV . "/" . "sports" . "/" . "news" . "/" . $id . $this->apiR . $this->apiKey);
	}	
	
	protected function espn_get($uri){
		return json_decode(file_get_contents($uri));
	}
	
	protected function streamline($res){
		$toreturn=array();
		for($i=0; $i < count($res->{'headlines'}); $i++){
			if (isset($res->{'headlines'}[$i]->{'headline'})) $toreturn[$i]['headline'] = $res->{'headlines'}[$i]->{'headline'}; else $toreturn[$i]['headline'] = "";
			$toreturn[$i]['keywords'] = $res->{'headlines'}[$i]->{'keywords'};
			$toreturn[$i]['lastModified'] = $res->{'headlines'}[$i]->{'lastModified'};
			$toreturn[$i]['web_link'] = $res->{'headlines'}[$i]->{'links'}->{'web'}->{'href'};
			$toreturn[$i]['mobile_link'] = $res->{'headlines'}[$i]->{'links'}->{'mobile'}->{'href'};
			$toreturn[$i]['id'] = $res->{'headlines'}[$i]->{'id'};
			if (isset($res->{'headlines'}[$i]->{'title'})) $toreturn[$i]['title'] = $res->{'headlines'}[$i]->{'title'}; else $toreturn[$i]['title'] = "";
			if (isset($res->{'headlines'}[$i]->{'description'})) $toreturn[$i]['description'] = $res->{'headlines'}[$i]->{'description'}; else $toreturn[$i]['description'] = "";
		}
		return $toreturn;
	}
}
?>
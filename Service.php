<?php 
class Service{
	private $config;
	private $serverName;
	private $applications;
	public $provisionFile;
	function __construct(){
		$this->init();
	}
	private function init(){
		$this->config=parse_ini_file("/config/config.ini",true);
		$this->serverName="http://".$_SERVER["SERVER_NAME"];
		while(list($k,$v)=each($this->config)){
			if($k=="general"){
				$this->provisionFile="config/".$v["mobileprovision"];
			}else{
				$this->applications[$k]=$v;
			}
		}
	}
	public function listManifests(){
		$list=array();
		$pattern='<a href="itms-services://?action=download-manifest&url=%s">%s</a>';
		while(list($k,$v)=each($this->applications)){
			$this->createManifest($k);
			$list[]=sprintf($pattern,urlencode($this->serverName."/plists/".$k.".plist"),$k);
		}
		return $list;
	}
	private function createManifest($key){
		$pattern=file_get_contents("template.plist");
		$content=preg_replace(array("/_url_/","/_bundle-identifier_/","/_bundle-version_/","/_title_/"), array($this->serverName."/apps/".$key.".ipa",$this->config[$key]["bundle-identifier"],$this->config[$key]["bundle-version"],$this->config[$key]["title"]), $pattern);
		file_put_contents("plists/{$key}.plist", $content);
	}
}
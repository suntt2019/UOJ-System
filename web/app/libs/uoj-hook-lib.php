<?php
class Hook {
	static $hook_list;
	public static function init(){
		$hook_names = array(
			"balloon_demo",
		);
		foreach($hook_names as $name) {
			require $_SERVER['DOCUMENT_ROOT'].'/app/hooks/'.$name.'.hook.php';
		}
		Hook::$hook_list = array(
			"balloon" => array (
				new demoHook("balloon","demo"),
			),
		);
	}
	public static function run($event,$arg){
		if (!isset(Hook::$hook_list[$event]))
			return null;
		$return_value = array();
		foreach(Hook::$hook_list[$event] as $name => $hook) {
			$return_value[$name] = $hook->execute($arg);
		}
		return $return_value;
	}
}

abstract class HookElement {
	var $event, $name;
	function __construct($event,$name) {
		$this->event = $event;
		$this->name = $name;
	}
	public abstract function execute($arg);
}

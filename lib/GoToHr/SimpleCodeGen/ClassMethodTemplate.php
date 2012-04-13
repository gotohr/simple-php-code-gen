<?php
namespace GoToHr\SimpleCodeGen;

class ClassMethodTemplate {
	private $name;
	private $params = array();
	private $type = null;
	private $doc = null;
	private $access = 'public';
	
	public function __construct($name, $params = array(), $type = null, $doc = null, $access = null) {
		$this->name = $name;
		$this->setParams($params);
		$this->type = $type;
		$this->doc = $doc;
		$this->access = $access ? $access : $this->access;
	}
	
	public function addParam($name, $type = null, $default = null) {
		$this->params[$name] = new ClassMethodParamTemplate($name, $type, $default);
	}
	
	public function removeParam($name) {
		unset($this->params[$name]);
	}
	
	public function setParams($params) {
		$this->params = array();
		foreach ($params as $param_name => $param_def) {
			$this->addParam(
				isset($param_def['name']) ? $param_def['name'] : $param_name, 
				isset($param_def['type']) ? $param_def['type'] : null, 
				isset($param_def['default']) ? $param_def['default'] : null
			);
		}
		return $this;
	}
	
	public function __toString() {
		$out = "\t/**".PHP_EOL;
		if ($this->doc) {
			$out.= "\t * {$this->doc}".PHP_EOL;
		}
		if ($this->type) {
			$out.= "\t * @return {$this->type}".PHP_EOL;
		}
		$out.= "\t */".PHP_EOL;
		$out.= "\t{$this->access} function {$this->name} (";
		$params = array();
		foreach ($this->params as $param_name => $param) {
//			var_dump($param);
			$params[] = $param->__toString();
		}
//		die();
		$out.= implode(', ', $params);
		$out.= ") {}".PHP_EOL;
		return $out;
	}
}
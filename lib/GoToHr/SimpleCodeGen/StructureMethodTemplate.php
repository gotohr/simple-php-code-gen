<?php
namespace GoToHr\SimpleCodeGen;

class StructureMethodTemplate {
	protected $name;
	protected $params = array();
	protected $type = null;
	protected $doc = null;
	protected $access = 'public';
	protected $body;
	
	public function __construct($name, $params = array(), $type = null, $doc = null, $access = null, $body = null) {
		$this->name = $name;
		$this->setParams($params);
		$this->type = $type;
		$this->doc = $doc;
		$this->access = $access ? $access : $this->access;
		$this->body = $body ? $body : '';
	}
	
	public function addParam($name, $type = null, $default = null) {
		$this->params[$name] = new \GoToHr\SimpleCodeGen\StructureMethodParamTemplate($name, $type, $default);
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
		$out = $this->generateDocumentation();
		$out.= $this->generateNameParams();
		$out.= $this->generateBody();
		return $out;
	}
	
	protected function generateDocumentation() {
		$out = "\t/**".PHP_EOL;
		if ($this->doc) {
			$out.= "\t * {$this->doc}".PHP_EOL;
		}
		if ($this->type) {
			$out.= "\t * @return {$this->type}".PHP_EOL;
		}
		$out.= "\t */".PHP_EOL;
		return $out;
	}

	protected function generateNameParams() {
		$out = "\t{$this->access} function {$this->name} (";
		$params = array();
		foreach ($this->params as $param_name => $param) {
			$params[] = $param->__toString();
		}
		return $out.implode(', ', $params).')';
	}
	
	protected function generateBody() {
		return '{'.PHP_EOL.$this->body.PHP_EOL."\t}".PHP_EOL;
	}
	
}

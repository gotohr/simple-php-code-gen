<?php
namespace GoToHr\SimpleCodeGen;

class StructureMethodParamTemplate {
	private $name;
	private $type = null;
	private $default = null;
	
	public function __construct($name, $type = null, $default = null) {
		$this->name = $name;
		$this->type = $type;
		$this->default = $default;
	}
	
	public function getName() { return $this->name; }
	public function getType() { return $this->type; }
	
	public function __toString() {
		$out = '';
		if ($this->type) $out.= "{$this->type} ";
		$out.= "\${$this->name}";
		if ($this->default) $out.= " = {$this->default}";
		return $out;
	}
}
<?php
namespace GoToHr\SimpleCodeGen;

class ClassMemberTemplate {
	protected $name;
	protected $type;
	protected $doc;
	protected $access = 'public';
	protected $default;
	
	public function __construct($name, $type = null, $doc = null, $access = null, $default = null) {
		$this->name = $name;
		$this->type = $type;
		$this->doc = $doc;
		$this->access = $access ? $access : $this->access;
		$this->default = $default;
	}
	
	public function __toString() {
		$out = $this->generateDocumentation();
		$out.= $this->generateNameDefault();
		return $out;
	}
	
	protected function generateDocumentation() {
		$out = "\t/**".PHP_EOL;
		if ($this->doc) {
			$out.= "\t * {$this->doc}".PHP_EOL;
		}
		
		if ($this->type) {
			$out.= "\t * @var {$this->type}".PHP_EOL;
		}
		
		$out.= "\t */".PHP_EOL;
		return $out;
	}
	
	protected function generateNameDefault() {
		$out = "\t{$this->access} \${$this->name}";
		if ($this->default) {
			$out.= " = {$this->default}";
		}
		return ';'.$out.PHP_EOL;
	}
}
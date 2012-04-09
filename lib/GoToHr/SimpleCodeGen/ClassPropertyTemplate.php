<?php
namespace GoToHr\SimpleCodeGen;

class ClassPropertyTemplate {
	private $name;
	private $type;
	private $doc;
	private $access = 'public';
	
	public function __construct($name, $type, $doc = null, $access = null) {
		$this->name = $name;
		$this->type = $type;
		$this->doc = $doc;
		$this->access = $access ? $access : $this->access;
	}
	
	public function __toString() {
		$out = "\t/**".PHP_EOL;
		if ($this->doc) {
			$out.= "\t * {$this->doc}".PHP_EOL;
		}
		$out.= "\t * @var {$this->type}".PHP_EOL;
		$out.= "\t */".PHP_EOL;
		$out.= "\t{$this->access} \${$this->name};".PHP_EOL;
		return $out;
	}
}
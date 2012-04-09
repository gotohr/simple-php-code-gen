<?php
namespace GoToHr\SimpleCodeGen;

class CodeGenerator {
	
	private $meta = array();
	
	public function __construct($meta) {
		$this->meta = $meta;
	}
	
	public function generate() {
		$ns = $this->meta['ns'];
		foreach ($this->meta['classes'] as $class_name => $class_def) {
			ClassTemplate::fromArray($class_name, $class_def, $ns)->write();
		}
	}
}
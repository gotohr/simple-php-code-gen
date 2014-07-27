<?php
namespace GoToHr\SimpleCodeGen;

class CodeGenerator {
	
	private $meta = array();
	
	public function __construct($meta) {
		$this->meta = $meta;
	}
	
	public function generate() {
		$ns = $this->meta['ns'];
		
		if(isset($this->meta['classes'])) 
			foreach ($this->meta['classes'] as $name => $def) {
				ClassTemplate::fromArray($name, $def, $ns)->write();
			}
		
		if(isset($this->meta['interfaces'])) 
			foreach ($this->meta['interfaces'] as $name => $def) {
				InterfaceTemplate::fromArray($name, $def, $ns)->write();
			}
	}
}

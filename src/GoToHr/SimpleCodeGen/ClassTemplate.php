<?php
namespace GoToHr\SimpleCodeGen;

class ClassTemplate extends StructureTemplate {	
	private $consts = array();
	private $properties = array();
	
	public function __construct($name, $ns = null, $extends = null, $doc = null) {
		parent::__construct(
			'class', '\\GoToHr\\SimpleCodeGen\\ClassMethodTemplate',
			$name, $ns, $extends, $doc
		);
	}
	
	/**
	 * @param array $meta
	 * @return \GoToHr\SimpleCodeGen\ClassTemplate
	 */
	public static function fromArray($name, $meta, $ns = null) {
		$ct = new self(
			isset($meta['name']) ? $meta['name'] : $name, 
			isset($meta['ns']) ? $meta['ns'] : $ns, 
			isset($meta['extends']) ? $meta['extends'] : null, 
			isset($meta['doc']) ? $meta['doc'] : null
		);

		if (isset($meta['consts'])) {
			$ct->setConsts($meta['consts']);
		}
		
		if (isset($meta['properties'])) {
			$ct->setProperties($meta['properties']);
		}
		
		if (isset($meta['methods'])) {
			$ct->setMethods($meta['methods']);
		}
		
		return $ct;
	}
	
	/**
	 * chainable...
	 * 
	 * @param stringe $name
	 * @param string $type
	 * @param string $doc
	 * @param string $access
	 * @return \GoToHr\SimpleCodeGen\ClassTemplate
	 */
	public function addProperty($name, $type, $doc = null, $access = null, $default = null) {
		$this->properties[$name] = new ClassPropertyTemplate($name, $type, $doc, $access, $default);
		return $this;
	}
	
	public function removeProperty($name) {
		unset($this->properties[$name]);
		return $this;
	}
	
	public function setProperties($properties) {
		$this->properties = array();
		foreach ($properties as $prop_name => $prop_def) {
			$this->addProperty(
				isset($prop_def['name']) ? $prop_def['name'] : $prop_name, 
				isset($prop_def['type']) ? $prop_def['type'] : null, 
				isset($prop_def['doc']) ? $prop_def['doc'] : null, 
				isset($prop_def['access']) ? $prop_def['access'] : null,
				isset($prop_def['default']) ? $prop_def['default'] : null 
			);
		}
		return $this;
	}

	public function addConst($name, $type, $doc = null, $access = null, $default = null) {
		$this->consts[$name] = new ClassConstTemplate($name, $type, $doc, $access, $default);
		return $this;
	}
	
	public function removeConst($name) {
		unset($this->consts[$name]);
		return $this;
	}
	
	public function setConsts($consts) {
		$this->consts = array();
		foreach ($consts as $const_name => $const_def) {
			$this->addConst(
				isset($const_def['name']) ? $const_def['name'] : $const_name, 
				isset($const_def['type']) ? $const_def['type'] : null, 
				isset($const_def['doc']) ? $const_def['doc'] : null, 
				isset($const_def['access']) ? $const_def['access'] : null,
				isset($const_def['default']) ? $const_def['default'] : null 
			);
		}
		return $this;
	}

	public function generateBody() {
		$out = '';
		foreach ($this->consts as $const) {
			$out.= $const;
		}
		foreach ($this->properties as $prop) {
			$out.= $prop;
		}
		foreach ($this->methods as $method) {
			$out.= $method.PHP_EOL;
		}
		return $out;
	}
}
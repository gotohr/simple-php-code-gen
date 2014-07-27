<?php
namespace GoToHr\SimpleCodeGen;

class InterfaceTemplate extends StructureTemplate {	
	
	public function __construct($name, $ns = null, $extends = null, $doc = null) {
		parent::__construct(
			'interface', '\\GoToHr\\SimpleCodeGen\\InterfaceMethodTemplate',
			$name, $ns, $extends, $doc
		);
	}
	
	/**
	 * @param array $meta
	 * @return \GoToHr\SimpleCodeGen\ClassTemplate
	 */
	public static function fromArray($name, $meta, $ns = null) {
		$t = new self(
			isset($meta['name']) ? $meta['name'] : $name, 
			isset($meta['ns']) ? $meta['ns'] : $ns, 
			isset($meta['extends']) ? $meta['extends'] : null, 
			isset($meta['doc']) ? $meta['doc'] : null
		);
		
		if (isset($meta['methods'])) {
			$t->setMethods($meta['methods']);
		}
		
		return $t;
	}
}
<?php
namespace GoToHr\SimpleCodeGen;

class ClassTemplate {
	private $name;
	private $ns;
	private $extends;
	private $doc;
	
	private $properties = array();
	
	public function __construct($name, $ns = null, $extends = null, $doc = null) {
		$this->name = $name;
		$this->ns = $ns;
		$this->extends = $extends;	
		$this->doc = $doc;	
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

		if (isset($meta['properties'])) {
			$ct->setProperties($meta['properties']);
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
	public function addProperty($name, $type, $doc = null, $access = null) {
		$this->properties[$name] = new ClassPropertyTemplate($name, $type, $doc, $access);
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
				$prop_def['type'],
				isset($prop_def['doc']) ? $prop_def['doc'] : null, 
				isset($prop_def['access']) ? $prop_def['access'] : null 
			);
		}
		return $this;
	}

	public function write($path = './') {
		$filename = $this->name.'.php';
		if ($this->ns) {
			$path .= str_replace('\\', '/', $this->ns).'/';
			if (!file_exists($path)) {
				mkdir ($path, 0755, true);
			}
		}
		file_put_contents($path.$filename, '<?php'.PHP_EOL.$this);
	}
	
	public function __toString() {
		$out = '';
		if ($this->ns) {
			$out.= "namespace {$this->ns};".PHP_EOL.PHP_EOL;
		}
		if ($this->doc) {
			$out.= '/**'.PHP_EOL;
			$out.= '* '.$this->doc.PHP_EOL;
			$out.= '*/'.PHP_EOL;
		}
		
		$out.="class {$this->name} ";
		if ($this->extends) {
			$out.= "extends {$this->extends} ";
		}
		$out.='{'.PHP_EOL;
		foreach ($this->properties as $prop) {
			$out.= $prop;
		}
		$out.='}'.PHP_EOL;
		
		return $out;
	}
}
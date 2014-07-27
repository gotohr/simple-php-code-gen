<?php
namespace GoToHr\SimpleCodeGen;

class StructureTemplate {
	protected $structure;
	protected $methodTemplate;

	protected $name;
	protected $ns;
	protected $extends;
	protected $doc;
	
	protected $methods = array();
	
	public function __construct($structure, $methodTemplate, $name, $ns = null, $extends = null, $doc = null) {
		$this->structure = $structure;
		$this->methodTemplate = $methodTemplate;
		$this->name = $name;
		$this->ns = $ns;
		$this->extends = $extends;	
		$this->doc = $doc;	
	}
		
	public function addMethod($name, $params = array(), $type = null, $doc = null, $access = null, $body = null) {
		$this->methods[$name] = new $this->methodTemplate($name, $params, $type, $doc, $access, $body);
		return $this;
	}
	
	public function removeMethod($name) {
		unset($this->methods[$name]);
		return $this;
	}
	
	public function setMethods($methods) {
		$this->methods = array();
		foreach ($methods as $method_name => $method_def) {
			$this->addMethod(
				isset($method_def['name']) ? $method_def['name'] : $method_name, 
				isset($method_def['params']) ? $method_def['params'] : array(), 
				isset($method_def['type']) ? $method_def['type'] : null, 
				isset($method_def['doc']) ? $method_def['doc'] : null, 
				isset($method_def['access']) ? $method_def['access'] : null, 
				isset($method_def['body']) ? $method_def['body'] : null 
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
		$out = $this->generateNamespace();
		$out.= $this->generateDocumentation();
		$out.= $this->generateNameExtends();
		$out.='{'.PHP_EOL;
		$out.= $this->generateBody();
		$out.='}'.PHP_EOL;
		
		return $out;
	}
	
	protected function generateNamespace() {
		return $this->ns 
			? "namespace {$this->ns};".PHP_EOL.PHP_EOL
			: '';
	}
	protected function generateDocumentation() {
		$out = '';
		if ($this->doc) {
			$out.= '/**'.PHP_EOL;
			$out.= '* '.$this->doc.PHP_EOL;
			$out.= '*/'.PHP_EOL;
		}		
		return $out;
	}
	protected function generateNameExtends() {
		$out = "{$this->structure} {$this->name} ";
		if ($this->extends) {
			$out.= "extends {$this->extends} ";
		}
		return $out;
	}
	protected function generateBody() {
		$out = '';
		foreach ($this->methods as $method) {
			$out.= $method.PHP_EOL;
		}
		return $out;
	}
}

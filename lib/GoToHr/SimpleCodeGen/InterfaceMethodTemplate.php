<?php
namespace GoToHr\SimpleCodeGen;

class InterfaceMethodTemplate extends StructureMethodTemplate {
	protected function generateBody() {
		return ";".PHP_EOL;
	}
}

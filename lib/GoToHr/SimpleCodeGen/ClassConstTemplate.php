<?php
namespace GoToHr\SimpleCodeGen;

class ClassConstTemplate extends ClassMemberTemplate {
	protected function generateNameDefault() {
		return "\tconst {$this->name} = {$this->default};".PHP_EOL;
	}	
}
<?php
declare(strict_types=1);

namespace Guardian\Validators;

use PhpParser\NodeFinder;

class Validator_Base {
	
	protected NodeFinder $Node_Finder;

	public function __construct(){
		$this->Node_Finder = new NodeFinder();
	}
	
}
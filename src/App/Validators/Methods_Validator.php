<?php
declare(strict_types=1);

namespace Guardian\Validators;

use Guardian\Util\Config_Keys;
use PhpParser\Node\Expr\StaticCall;
use Guardian\Validators\Validator_Base;

class Methods_Validator extends Validator_Base {

	/**
	 * Check if file uses static calls
	 *
	 * @param array  $ast             The AST
	 * @param string $file_to_analyze The file to analyze
	 * @return array
	 */
	public function validateFile($ast, string $file_to_analyze): array {
		$errors = [];

		$error_info = [
			$file_to_analyze,
			'',
			'File uses static method calls',
			Config_Keys::KEY_ALLOW_STATIC_CALLS,
			Config_Keys::KEY_TYPES[Config_Keys::KEY_ALLOW_STATIC_CALLS],
		];

		$static_nodes = $this->Node_Finder->findInstanceOf($ast, StaticCall::class);
		if (empty($static_nodes)) {
			return [];
		}
		
		foreach($static_nodes as $node) {
			$error_info[1] = $node->getLine();
			$errors[] = $error_info;
		}

		return $errors;
	}

}
<?php
declare(strict_types=1);

namespace Guardian\Validators;

use Guardian\Util\Config_Keys;
use PhpParser\Node\Stmt\Declare_;
use Guardian\Validators\Validator_Base;

class Strict_Type_Validator extends Validator_Base {

	/**
	 * Check if file declares strict types
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
			'File does not declare strict types',
			Config_Keys::KEY_REQUIRE_STRICT_TYPES,
			Config_Keys::KEY_TYPES[Config_Keys::KEY_REQUIRE_STRICT_TYPES],
		];

		$declare_node = $this->Node_Finder->findInstanceOf($ast, Declare_::class);
		if (empty($declare_node)) {
			$errors[] = $error_info;
		} else {
			$strict_types = $declare_node[0]->declares[0]->value->value;
			$name = $declare_node[0]->declares[0]->key->name;

			if ($strict_types !== 1 || $name !== 'strict_types') {
				$errors[] = $error_info;
			}
		}
		
		return $errors;
	}
}
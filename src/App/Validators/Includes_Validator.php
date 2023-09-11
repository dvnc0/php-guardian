<?php
declare(strict_types=1);

namespace Guardian\Validators;

use Guardian\Util\Config_Keys;
use PhpParser\Node\Expr\Include_;
use Guardian\Validators\Validator_Base;

class Includes_Validator extends Validator_Base {

	/**
	 * Check if file uses include expressions
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
			'File uses include or require expressions',
			Config_Keys::KEY_ALLOW_INCLUDES,
			Config_Keys::KEY_TYPES[Config_Keys::KEY_ALLOW_INCLUDES],
		];

		$include_nodes = $this->Node_Finder->findInstanceOf($ast, Include_::class);
		if (empty($include_nodes)) {
			return [];
		}
		
		foreach($include_nodes as $node) {
			$error_info[1] = $node->getLine();
			$errors[] = $error_info;
		}

		return $errors;
	}

	public function validateBlacklist($ast, string $file_to_analyze, array $blacklist): array {
		$errors = [];

		$error_info = [
			$file_to_analyze,
			'',
			'File uses blacklisted include or require paths',
			Config_Keys::KEY_REQUIRE_INCLUDE_BLACKLIST,
			Config_Keys::KEY_TYPES[Config_Keys::KEY_REQUIRE_INCLUDE_BLACKLIST],
		];

		$include_nodes = $this->Node_Finder->findInstanceOf($ast, Include_::class);
		
		if (empty($include_nodes)) {
			return [];
		}

		foreach($include_nodes as $node) {
			$node_path = $node->expr->value;
			foreach($blacklist as $blacklist_path) {
				if (strpos($node_path, $blacklist_path) !== false) {
					$error_info[1] = $node->getLine();
					$errors[] = $error_info;
				}
			}
		}

		return $errors;
	}
}
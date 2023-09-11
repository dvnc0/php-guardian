<?php
declare(strict_types=1);

namespace Guardian\Validators;

use Guardian\Util\Config_Keys;
use PhpParser\Node\Stmt\Use_;
use Guardian\Validators\Validator_Base;

class Use_Validator extends Validator_Base {

	/**
	 * Check if file includes use statements
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
			'File utilizes use statements',
			Config_Keys::KEY_ALLOW_USE_STATEMENTS,
			Config_Keys::KEY_TYPES[Config_Keys::KEY_ALLOW_USE_STATEMENTS],
		];

		$use_nodes = $this->Node_Finder->findInstanceOf($ast, Use_::class);
		if (empty($use_nodes)) {
			return [];
		}
		
		foreach($use_nodes as $node) {
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
			'File uses blacklisted namespace',
			Config_Keys::KEY_NAMESPACE_BLACKLIST,
			Config_Keys::KEY_TYPES[Config_Keys::KEY_NAMESPACE_BLACKLIST],
		];

		$use_nodes = $this->Node_Finder->findInstanceOf($ast, Use_::class);
		
		if (empty($use_nodes)) {
			return [];
		}

		foreach($use_nodes as $node) {
			$node_path_parts = $node->uses[0]->name->parts;
			$node_path = implode('\\', $node_path_parts);
			if (in_array($node_path, $blacklist)) {
				$error_info[1] = $node->getLine();
				$errors[] = $error_info;
			}
		}

		return $errors;
	}
}
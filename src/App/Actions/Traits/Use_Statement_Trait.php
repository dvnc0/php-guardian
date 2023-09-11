<?php
declare(strict_types=1);

namespace Guardian\Actions\Traits;

use Guardian\Util\Config_Keys;
use Guardian\Validators\Use_Validator;

trait Use_Statement_Trait {
	protected function allowUseStatements($ast, array $config, string $file_to_analyze): array|bool {
		$allow_use_statements = $config[Config_Keys::KEY_ALLOW_USE_STATEMENTS];
		
		if ($allow_use_statements === true) {
			return true;
		}

		$Use_Validator = $this->Injector->resolve(Use_Validator::class);
		$errors = $Use_Validator->validateFile($ast, $file_to_analyze);

		$return = empty($errors) ? true : $errors;

		return $return;
		
	}

	protected function namespaceBlacklist($ast, array $config, string $file_to_analyze): array|bool {
		$blacklist = $config[Config_Keys::KEY_NAMESPACE_BLACKLIST];

		if (empty($blacklist)) {
			return true;
		}

		$Use_Validator = $this->Injector->resolve(Use_Validator::class);
		$errors = $Use_Validator->validateBlackList($ast, $file_to_analyze, $blacklist);

		$return = empty($errors) ? true : $errors;

		return $return;
	}
}
<?php
declare(strict_types=1);

namespace Guardian\Actions\Traits;

use Guardian\Util\Config_Keys;
use Guardian\Validators\Includes_Validator;

trait Includes_Trait {
	protected function allowIncludes($ast, array $config, string $file_to_analyze): array|bool {
		$allow = $config[Config_Keys::KEY_ALLOW_INCLUDES];
		
		if ($allow === true) {
			return true;
		}

		$Includes_Validator = $this->Injector->resolve(Includes_Validator::class);
		$errors = $Includes_Validator->validateFile($ast, $file_to_analyze);

		$return = empty($errors) ? true : $errors;

		return $return;
		
	}

	protected function requireIncludeBlacklist($ast, array $config, string $file_to_analyze): array|bool {
		$blacklist = $config[Config_Keys::KEY_REQUIRE_INCLUDE_BLACKLIST];

		if (empty($blacklist)) {
			return true;
		}

		$Includes_Validator = $this->Injector->resolve(Includes_Validator::class);
		$errors = $Includes_Validator->validateBlackList($ast, $file_to_analyze, $blacklist);

		$return = empty($errors) ? true : $errors;

		return $return;
	}
}
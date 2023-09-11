<?php
declare(strict_types=1);

namespace Guardian\Actions\Traits;

use Guardian\Util\Config_Keys;
use Guardian\Validators\Strict_Type_Validator;

trait Strict_Types_Trait {
	protected function strictTypes($ast, array $config, string $file_to_analyze): array|bool {
		$strict = $config[Config_Keys::KEY_REQUIRE_STRICT_TYPES];
		
		if ($strict === false) {
			return true;
		}

		$Strict_Type_Validator = $this->Injector->resolve(Strict_Type_Validator::class);
		$errors = $Strict_Type_Validator->validateFile($ast, $file_to_analyze);

		$return = empty($errors) ? true : $errors;

		return $return;
		
	}
}
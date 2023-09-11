<?php
declare(strict_types=1);

namespace Guardian\Actions\Traits;

use Guardian\Util\Config_Keys;
use Guardian\Validators\Methods_Validator;

trait Methods_Trait {

	/**
	 * Check if static method calls are made
	 * 
	 * @param $ast
	 * @param array $config
	 * @param string $file_to_analyze
	 * @return array|bool
	 */
	public function allowStaticCalls($ast, array $config, string $file_to_analyze): array|bool {
		$allow_static_calls = $config[Config_Keys::KEY_ALLOW_STATIC_CALLS];
		
		if ($allow_static_calls === true) {
			return true;
		}

		$Methods_Validator = $this->Injector->resolve(Methods_Validator::class);
		$errors = $Methods_Validator->validateFile($ast, $file_to_analyze);

		$return = empty($errors) ? true : $errors;

		return $return;
		
	}
}
<?php
declare(strict_types=1);

namespace Guardian\Actions;

use Guardian\Actions\Traits\Strict_Types_Trait;
use Guardian\Actions\Traits\Use_Statement_Trait;
use Guardian\Actions\Traits\Includes_Trait;
use Guardian\Actions\Traits\Methods_Trait;
use Clyde\Injector\Injector;

class Analyze_Factory {

	public Injector $Injector;

	use Strict_Types_Trait;
	use Use_Statement_Trait;
	use Includes_Trait;
	use Methods_Trait;

	public function __construct(Injector $Injector) {
		$this->Injector = $Injector;
	}

	public function runValidator(string $method, $ast, string $file_to_analyze, array $config): array|bool {
		$validator_result = $this->{$method}($ast, $config, $file_to_analyze);

		return $validator_result;
	}
}
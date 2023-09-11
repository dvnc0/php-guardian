<?php
declare(strict_types=1);

namespace Guardian\Actions;

use Clyde\Actions\Action_Base;
use Clyde\Request\Request;
use Clyde\Request\Request_Response;

class Init_Action extends Action_Base {
	public function execute(Request $Request): Request_Response {
		$this->Printer->message('Creating configuration file...');
		
		$basic_config  = [
			'require_strict_types' => true,
			'function_blacklist' => [],
			'namespace_blacklist' => [],
			'allow_use_statements' => true,
			'allow_includes_and_requires' => false,
			'require_include_blacklist' => [],
			'allow_static_calls' => false,
		];

		$basic_config_json = json_encode($basic_config, JSON_PRETTY_PRINT);
		$file_name = ROOT . '/guardian.json';

		$this->filePutContents($file_name, $basic_config_json);

		$this->Printer->success('Configuration file created!');
		return new Request_Response(true);
	}

	/**
	 * test wrapper, so we can mock this in tests
	 *
	 * @param string $file_name file name to create
	 * @param string $contents  contents to add
	 * @return int<0,max>|boolean
	 * 
	 * @codeCoverageIgnore
	 */
	protected function filePutContents(string $file_name, string $contents): int|bool {
		return file_put_contents($file_name, $contents);
	}

}
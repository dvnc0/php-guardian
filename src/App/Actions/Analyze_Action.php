<?php
declare(strict_types=1);

namespace Guardian\Actions;

use Clyde\Actions\Action_Base;
use Clyde\Request\Request;
use Clyde\Request\Request_Response;
use Clyde\Tools\Table;
use Guardian\Util\Parser\Tokenizer;
use Guardian\Actions\Analyze_Factory;
use Guardian\Injector\Injector;
use Clyde\Application;
use Clyde\Core\Event_Dispatcher;

class Analyze_Action extends Action_Base {
	
	/**
	 * Injector
	 *
	 * @var Injector
	 */
	public Injector $Injector;

	/**
	 * Methods to run
	 *
	 * @var array
	 */
	protected array $methods = [
		'strictTypes',
		'allowUseStatements',
		'allowIncludes',
		'requireIncludeBlacklist',
		'namespaceBlacklist',
	];

	/**
	 * Construct
	 *
	 * @param Application      $Application      The Application instance
	 * @param Event_Dispatcher $Event_Dispatcher The Event Dispatcher
	 */
	public function __construct(Application $Application, Event_Dispatcher $Event_Dispatcher){
		parent::__construct($Application, $Event_Dispatcher);
		$this->Injector = new Injector($Application);
	}

	/**
	 * Execute
	 *
	 * @param Request $Request Request object
	 * @return Request_Response
	 */
	public function execute(Request $Request): Request_Response {
		$file_to_analyze = $Request->getArgument('file');
		$this->Printer->message("Analyzing file {$file_to_analyze}...");
		
		$config_file = ROOT . '/guardian.json';

		$config = json_decode(file_get_contents($config_file), true);

		$ast = $this->getAst($file_to_analyze);
		$errors = [];
		$Analyze_Factory = $this->Injector->resolve(Analyze_Factory::class);

		foreach($this->methods as $method) {
			$validator_result = $Analyze_Factory->runValidator($method, $ast, $file_to_analyze, $config);

			if ($validator_result !== true) {
				$errors = array_merge($errors, $validator_result);
			}
		}

		$lines = array_map(function($error) {
			return $error[2];
		}, $errors);

		array_multisort($errors, SORT_ASC, $lines);

		$this->outputResults($errors);
		return new Request_Response(true);
	}

	/**
	 * Get AST
	 *
	 * @param string $file_to_analyze File to analyze
	 * @return array
	 */
	protected function getAst(string $file_to_analyze): array {
		$Tokenizer = $this->Injector->resolve(Tokenizer::class);
		$ast = $Tokenizer->tokenizeFile($file_to_analyze);
		return $ast;
	}

	/**
	 * Output results
	 *
	 * @param array $errors Errors to output
	 * @return void
	 */
	protected function outputResults(array $errors): void {
		if (!empty($errors)) {
			$this->Printer->alert('Errors found!');
			$Table = $this->Injector->resolve(Table::class);
			$table = $Table->buildTable(['headers' => ['File','Line','Error', 'Rule', 'Rule Type'], 'rows' => $errors]);
			
			$this->Printer->message($table);
			exit(1);
		}
		$this->Printer->success('No errors found!');
	}

}
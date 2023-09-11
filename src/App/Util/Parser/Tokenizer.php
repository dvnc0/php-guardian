<?php
declare(strict_types=1);

namespace Guardian\Util\Parser;

use PhpParser\ParserFactory;

class Tokenizer {

	public function tokenizeFile(string $file_path) {
		if (!file_exists($file_path)) {
			throw new \Exception('File does not exist: ' . $file_path);
		}

		$file = $this->fileGetContents($file_path);

		$parser_factory = $this->getParser();
		$parser = $parser_factory->create(ParserFactory::PREFER_PHP7);
		$ast = $parser->parse($file);

		return $ast;
	}

	protected function getParser(): ParserFactory {
		return new ParserFactory;
	}

	protected function fileGetContents(string $file_path): string {
		return file_get_contents($file_path);
	}
}
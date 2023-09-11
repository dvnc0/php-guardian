<?php
declare(strict_types=1);

namespace Guardian\Util;

class Config_Keys {

	const KEY_REQUIRE_STRICT_TYPES = 'require_strict_types';
	const KEY_FUNCTION_BLACKLIST = 'function_blacklist';
	const KEY_NAMESPACE_BLACKLIST = 'namespace_blacklist';
	const KEY_ALLOW_USE_STATEMENTS = 'allow_use_statements';
	const KEY_ALLOW_INCLUDES = 'allow_includes_and_requires';
	const KEY_REQUIRE_INCLUDE_BLACKLIST = 'require_include_blacklist';
	const KEY_ALLOW_STATIC_CALLS = 'allow_static_calls';

	const KEYS = [
		self::KEY_REQUIRE_STRICT_TYPES,
		self::KEY_FUNCTION_BLACKLIST,
		self::KEY_NAMESPACE_BLACKLIST,
		self::KEY_ALLOW_USE_STATEMENTS,
		self::KEY_ALLOW_INCLUDES,
		self::KEY_REQUIRE_INCLUDE_BLACKLIST,
		self::KEY_ALLOW_STATIC_CALLS,
	];

	const DEFAULTS = [
		self::KEY_REQUIRE_STRICT_TYPES => true,
		self::KEY_FUNCTION_BLACKLIST => [],
		self::KEY_NAMESPACE_BLACKLIST => [],
		self::KEY_ALLOW_USE_STATEMENTS => true,
		self::KEY_ALLOW_INCLUDES => false,
		self::KEY_REQUIRE_INCLUDE_BLACKLIST => [],
		self::KEY_ALLOW_STATIC_CALLS => false,
	];

	const KEY_TYPES = [
		self::KEY_REQUIRE_STRICT_TYPES => 'boolean',
		self::KEY_FUNCTION_BLACKLIST => 'array',
		self::KEY_NAMESPACE_BLACKLIST => 'array',
		self::KEY_ALLOW_USE_STATEMENTS => 'boolean',
		self::KEY_ALLOW_INCLUDES => 'boolean',
		self::KEY_REQUIRE_INCLUDE_BLACKLIST => 'array',
		self::KEY_ALLOW_STATIC_CALLS => 'boolean',
	];
}
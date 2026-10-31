# CHANGELOG

## v0.2.0 (2026-10-31)

 * Last release. The package is abandoned in favour of the bundled `phel.schema` in phel-lang.
 * Fix the required rule: `0`, `""` and `{}` are present values, and booleans no longer throw.
 * Fix `safe-parse` throwing and emitting PHP notices: rules stop after a failed required or type check.
 * Fix object schemas crashing on a non-map target.
 * Fix `lte` registering its rule under `:lt`.
 * `regex` throws on an invalid pattern when the schema is built, and on PCRE runtime errors. Bad UTF-8 against a `/u` pattern fails the rule.
 * `object` and `custom` reject malformed arguments, and `safe-parse` and `parse` reject a first argument that is not a schema.
 * Pin the CI actions to commit SHAs and add Dependabot.

 * `ZodError` message lists the issues, for example `Zod Error: Invalid type at [:user :username]`, so the REPL shows what failed.
 * Breaking: `number` accepts only PHP ints and floats. Numeric strings such as `"5"` now fail with "Invalid type", and `NAN` and `INF` are rejected.
 * `int` checks the numeric value, so whole floats such as `1e20` pass and `100.5` fails.
 * `custom` takes an options map, `(z/custom s test {:message "..."})`, and defaults the message to "Invalid value". The bare string message still works and is deprecated.

## v0.1.0 (2026-10-04)

 * Require phel-lang ^0.54 and PHP 8.5
 * Bind map destructuring pairs binding-first

## v0.0.1 (2025-06-23)

 * fix require phel version. Support phel-lang 0.17

## v0.0.0 (2024-06-25)

 * Support phel-lang 0.15


# CHANGELOG

## Unreleased

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


# Contributing

This package is abandoned and v0.2.0 is the last release, so the repository takes no new changes. This guide is for working on a fork.

## Set up

You need PHP 8.5 or later with `mbstring`, and Composer.

```bash
composer install
composer test
```

To work in Docker instead:

```bash
docker compose build
docker compose run --rm php_cli bash
```

## Layout

| Path | Holds |
|---|---|
| `src/phel/schema.phel` | Public API: `parse`, `safe-parse`, and one re-export per builder and rule |
| `src/phel/interfaces.phel` | The `schema` and `rule` structs, plus `typed-schema`, `add-rule` and `validate` |
| `src/phel/type/` | One file per type: `string`, `number`, `object`, `custom` |
| `src/php/ZodError.php` | The exception thrown by `parse` |
| `tests/phel/unit/` | Tests, mirroring `src/phel/` |

## Add a rule

A rule is a key, a test function and a message. Build it with `add-rule` and add the default message:

```clojure
(defn multiple-of [s n & [{message :message}]]
  (add-rule s :multiple-of #(= 0 (mod % n)) (or message "Not a multiple")))
```

Then:

1. Re-export it in `src/phel/schema.phel`.
2. Add tests in `tests/phel/unit/type/`: one that passes, one that fails with the default message, one with a custom message, and one that checks the rule key.
3. Add a line to the rules table in `README.md` and an entry under Unreleased in `CHANGELOG.md`.

Rules only run after the `Required` and `Invalid type` checks pass, so a rule can assume a value of the right type.

## Before you push

Run `composer test`. CI runs the same command on PHP 8.5 and also runs `composer validate --strict`.

## Commits and pull requests

- Use conventional commit subjects: `fix:`, `feat:`, `ref:`, `docs:`, `chore:`, `ci:`.
- Keep one change per pull request, and link the issue it closes.
- Describe what changed and how you checked it.

## Release

1. Rename the Unreleased heading in `CHANGELOG.md` to the version and date.
2. Merge it with the subject `chore(release): vX.Y.Z`.
3. Publish a GitHub release with the same tag. Packagist picks it up from the tag.

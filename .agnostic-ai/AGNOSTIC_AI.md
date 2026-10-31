# Project instructions

CLAUDE.md, AGENTS.md, and the other AI tool files are generated from `.agnostic-ai/`. Edit `.agnostic-ai/AGNOSTIC_AI.md` and the source specs, then run `agnostic-ai sync`.

phel-schema is a Zod-style validation library for Phel. The package is abandoned; v0.2.0 is the last release. Keep changes small and behavior-preserving unless an issue says otherwise.

## Commands

- Install: `composer install`
- Test: `composer test` (runs `vendor/bin/phel test`). Run it once the change is complete.
- Validate the manifest: `composer validate --strict`

## Layout

- `src/phel/schema.phel`: public API and the issue-collecting loop
- `src/phel/interfaces.phel`: `schema` and `rule` structs, `typed-schema`, `add-rule`, `validate`
- `src/phel/type/`: one file per type
- `tests/phel/unit/`: tests, mirroring `src/phel/`

## Rules

- Build every rule with `add-rule`. Do not add per-type rule structs.
- A rule runs only after the `:required_error` and `:invalid_type_error` guards pass, so it may assume the right type. `safe-parse` must never throw on bad input.
- Throw `InvalidArgumentException` for a malformed schema at build time, not at parse time.
- Each rule needs tests for pass, fail with the default message, fail with a custom message, and its `:key`.
- Use the dot form for namespaced PHP classes (`Phel.PhelSchema.ZodError`). The backslash form is deprecated in phel-lang 0.54.
- Commit subjects are conventional: `fix:`, `feat:`, `ref:`, `docs:`, `chore:`, `ci:`.
- Add every user-visible change to `CHANGELOG.md` under Unreleased.
- Keep `README.md` examples runnable: run one against the current code before changing the docs.

# phel-schema

Schema validation for [Phel](https://phel-lang.org), inspired by [Zod](https://zod.dev).

> [!WARNING]
> **This package is abandoned. v0.2.0 is the last release.**
>
> It uses the namespace `phel.schema`, the same as the schema library bundled with [phel-lang](https://github.com/phel-lang/phel-lang). When both are installed, this one hides the bundled one. Remove `phel-lang/phel-schema` from your dependencies and use the [bundled `phel.schema`](https://phel-lang.org/documentation/libraries/schema/).

## Migrate to the bundled library

The bundled library describes data with plain values such as `:int` and `[:map ...]`. It has no `string`, `number` or `object` builders, no `parse` or `safe-parse`, and no `ZodError`.

```clojure
# phel-schema
(def user (z/object {:name (-> (z/string) (z/min 3))
                     :age  (-> (z/number) (z/int) (z/positive))}))
(z/safe-parse user {:name "Lu" :age 0})

# bundled phel.schema
(def user [:map [:name [:and :string [:fn #(>= (php/mb_strlen %) 3)]]]
                [:age  [:and :int [:fn pos?]]]])
(s/validate user {:name "Lu" :age 0})   # => false
(s/explain user {:name "Lu" :age 0})    # => {:errors [{:in [:name] ...} {:in [:age] ...}] ...}
```

| phel-schema | Bundled `phel.schema` |
|---|---|
| `min`, `max`, `length` | `[:fn #(>= (php/mb_strlen %) 3)]` |
| `gt`, `gte`, `lt`, `lte`, `positive`, `negative` | `[:fn pos?]`, `[:fn neg?]` or any predicate |
| `regex` | `[:re "/^t/"]` |
| `custom` with a message | `[:fn pred]`. `explain` reports the kind and path of an error, not a message. |
| `parse`, `safe-parse` | `validate` or `explain`, then handle the result yourself |

## Usage

```clojure
(ns app
  (:require phel.schema :as z))

(def username (-> (z/string) (z/min 3) (z/max 10) (z/regex "/^t/")))

(z/parse username "tuna")      # => "tuna"
(z/parse username "a tuna")    # throws Phel\PhelSchema\ZodError

(z/safe-parse username "tuna")
# => {:success true :data "tuna" :issues []}

(z/safe-parse username 12)
# => {:success false :error <ZodError> :issues ({:message "Invalid type" :paths []})}
```

`parse` returns the value or throws. `safe-parse` never throws on bad input and returns a map instead.

### Types

| Builder | Accepts |
|---|---|
| `(z/string)` | PHP strings |
| `(z/number)` | PHP ints and floats. `NAN`, `INF` and numeric strings such as `"5"` are rejected. |
| `(z/object {...})` | Maps. Each child must be a schema. Keys that are not listed pass through unchecked. |

`nil` fails every type with `Required`. A wrong type fails with `Invalid type`. Later rules only run after both checks pass, so you get one issue per bad value, not a pile of follow-up errors.

### Rules

Every rule takes the schema first and an optional `{:message "..."}` last.

| Type | Rules (default message) |
|---|---|
| string | `min` (Too short), `max` (Too long), `length` (Wrong length), `regex` (Not match) |
| number | `gt`, `gte` (Too small), `lt`, `lte` (Too large), `int` (Not integer), `positive` (Not positive), `nonnegative`, `negative`, `nonpositive` |
| any | `custom` (Invalid value) |

```clojure
(z/min (z/string) 5 {:message "at least 5 characters"})

(z/custom (z/string) #(= (php/mb_strlen %) 4) {:message "must be 4 characters"})
```

`regex` throws `InvalidArgumentException` when the pattern does not compile. It also throws `RuntimeException` on a PCRE runtime error such as a backtrack limit. A string that is not valid UTF-8 fails a `/u` pattern like any other mismatch.

### Objects and errors

```clojure
(def signup (z/object {:user (z/object {:username (z/string)})}))

(z/safe-parse signup {:user {:username 123}})
# :issues => ({:message "Invalid type" :paths [:user :username]})
```

The `ZodError` message lists the issues, for example `Zod Error: Invalid type at [:user :username]`. Call `getIssues` on it for the same data as a PHP array.

## Development

You need PHP 8.5 or later.

```bash
composer install
composer test
```

See [CONTRIBUTING.md](CONTRIBUTING.md) for the layout, the Docker setup and how to add a rule. Release notes are in [CHANGELOG.md](CHANGELOG.md).

## License

[MIT](LICENSE)

# phel-schema

> [!WARNING]
> ## This package is deprecated
>
> This library uses the namespace `phel.schema`, the same name as the `phel.schema` namespace bundled with [phel-lang/phel-lang](https://github.com/phel-lang/phel-lang). When both are installed, this library hides the bundled one, so the core API is not available.
>
> **Please remove `phel-lang/phel-schema` from your dependencies** and use the bundled [`phel.schema`](https://phel-lang.org/documentation/libraries/schema/). This repository will no longer receive updates.
>
> The bundled API is not a drop-in replacement. It describes data with plain values such as `:int` or `[:map [:name :string]]` and offers `validate`, `explain`, `conform`, `coerce` and `generate`. It has no `string`, `number` or `object` builders, no `parse` or `safe-parse`, and no `ZodError`. These parts of this library have no named counterpart in core:
>
> - `min`, `max`, `length`, `gt`, `gte`, `lt`, `lte`, `positive`, `nonnegative`, `negative`, `nonpositive`: write them as `[:and :int [:fn pos?]]` or `[:re "/^t/"]`
> - `custom` with a message: `explain` reports errors by kind and path, with no custom message
> - `parse` and `safe-parse`: call `validate` or `explain` and handle the result yourself

---

Schema validation library in phel. The library inspired by zod

## Basic Usage

Creating a simple string schema

```clojure
(ns app
  (:require phel.schema :as z))

# creating a schema for strings
(def my-schema (z/string))

# parsing
(z/parse my-schema "tuna") # => "tuna"
(z/parse my-schema 12) # => throws ZodError

# "safe" parsing (doesn't throw error if validation fails)
(z/safe-parse my-schema "tuna") # => {:success true :data "tuna"}
(z/safe-parse my-schema 12) # => {:success false :error ZodError :issues [...]}
```

```clojure
(ns app
  (:require phel.schema :as z))

# creating a schema for strings
(def my-schema (as-> (z/string) s
                     (z/min s 3)
                     (z/max s 10)
                     (z/regex s "/^t/")))

# parsing
(z/parse my-schema "tuna") # => "tuna"
(z/parse my-schema "a tuna") # => throws ZodError
```

Creating an object schema


```clojure
(ns app
  (:require phel.schema :as z))

(def user-schama (z/object {
  :username (z/string)
}))

(z/parse user-schama {:username "Ludwig"})
```

### Primitives

```clojure
(ns app
  (:require phel.schema :as z))

# primitive values
(z/string)
(z/number)
(z/bigint) # z/bigint is not yet implemented.
(z/infer user-schama) # z/infer is not yet implemented.
(z/boolean) # z/boolean is not yet implemented.
(z/date) # z/date is not yet implemented.
(z/symbol) # z/symbol is not yet implemented.

# empty types
(z/undefined) # z/undefined is not yet implemented.
(z/null) # z/null is not yet implemented.
(z/void) # accepts undefined # z/void is not yet implemented.

# catch-all types
# allows any value
(z/any) # z/any is not yet implemented.
(z/unknown) # z/unknown is not yet implemented.

# never type
# allows no values
(z/never) # z/never is not yet implemented.
```


## Development

### Open shell

```bash
docker compose build
docker compose run --rm php_cli bash
```

### Test

```bash
# vendor/bin/phel test
```



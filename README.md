# phel-schema

Schema validation library in phel. The library inspired by zod

## Basic Usage

Creating a simple string schema

```clojure
(ns app
  (:require smeghead\schema :as z))

# creating a schema for strings
(def my-schema (z/string))

# parsing
(z/parse my-schema "tuna") # => "tuna"
(z/parse my-schema 12) # => throws ZodError

# "safe" parsing (doesn't throw error if validation fails)
(z/safe-parse my-schema "tuna") # => {:success true :data "tuna"}
(z/safe-parse my-schema 12) # => {:success false :error ZodError}
```


Creating an object schema


```clojure
(ns app
  (:require smeghead\schema :as z))

(def user-schama (z/object {
  :username (z/string)
}))

(z/parse user-schama {:username "Ludwig"})

# extract the inferred type
(z/infer user-schama)
# { username: string }
```

### Primitives

```clojure
(ns app
  (:require smeghead\schema :as z))

# primitive values
(z/string)
(z/number)
(z/bigint)
(z/boolean)
(z/date)
(z/symbol)

# empty types
(z/undefined)
(z/null)
(z/void) # accepts undefined

# catch-all types
# allows any value
(z/any)
(z/unknown)

# never type
# allows no values
(z/never)
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



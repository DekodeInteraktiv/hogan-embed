# Changelog

## 1.2.1
- Applied filter to the html output. [#9](https://github.com/DekodeInteraktiv/hogan-embed/pull/9)

## 1.2.0
- Don't manipulate the embed if fetched from the rest api. Fixes layout in Gutenberg [#6](https://github.com/DekodeInteraktiv/hogan-embed/pull/6)

## 1.1.2
- Output content without `wp_kses()`

## 1.1.1
- Update module to new registration method introduced in [Hogan Core 1.1.7](https://github.com/DekodeInteraktiv/hogan-core/releases/tag/1.1.7)
- Set hogan-core dependency `"dekodeinteraktiv/hogan-core": ">=1.1.7"`

## [1.1.0]
### Breaking Changes
- Remove heading field, provided from Core in [#53](https://github.com/DekodeInteraktiv/hogan-core/pull/53)
- Heading field has to be added using filter (was default on before).

## [1.0.13] - 2018-01-31
### Internal
* Use caption component on caption markup
* Remove assets enqueue action. Let hogan core handle it.
* Add frontend setup and minimize assets

### 1.0.9
- Heading classname changed from `.heading` to `.hogan-heading`.

### 1.0.5
Added instruction text to oembed field

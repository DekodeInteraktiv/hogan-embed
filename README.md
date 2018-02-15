# oEmbed Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-core) [![Build Status](https://travis-ci.org/DekodeInteraktiv/hogan-embed.svg?branch=master)](https://travis-ci.org/DekodeInteraktiv/hogan-embed)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-embed` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
- `hogan/module/embed/template` for overriding the default template file.
- `hogan/module/embed/wrapper_tag` for outer HTML wrapper tag, default `<section>`
- `hogan/module/embed/wrapper_classes` for outer HTML wrapper CSS classes.
- `hogan/module/embed/inner_wrapper_classes` for inner HTML `<figure>` wrapper classes.

### Content field
- `hogan/module/embed/content/allowed_html` for allowed oEmbed HTML.

### Caption field
- `hogan/module/embed/caption/enabled` for enabling caption field, default `true`.
- `hogan/module/embed/caption/tabs` for TinyMCE editor tabs, default all.
- `hogan/module/embed/caption/allow_media_upload` for allowing TinyMCE editor media upload, default 0.
- `hogan/module/embed/caption/toolbar` for TinyMCE editor toolbar, default hogan.

## Changelog
### 1.0.9
- Heading classname changed from `.heading` to `.hogan-heading`.

### 1.0.5
Added instruction text to oembed field

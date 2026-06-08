# Alink

MediaWiki extension (type: `parserhook`) that provides two parser functions for rendering raw HTML `<a>` and `<img>` tags with full attribute control.

- **Version:** 0.3.0
- **License:** GPL-3.0-or-later
- **Requires:** MediaWiki >= 1.35.0, PHP >= 7.2
- **Repository:** https://github.com/SimilisTools/mediawiki-alink

## Installation

1. Clone or extract into `extensions/Alink/`.
2. Add to `LocalSettings.php`:
   ```php
   wfLoadExtension( 'Alink' );
   ```

## Parser functions

### `#alink` — anchor tag

```
{{#alink: href=<url or wiki page> | <attributes> | <flags> | link text }}
```

**Allowed attributes:** `href`, `rel`, `target`, `class`, `id`, `content`, `name`, `itemprop`, and any `data-*` attribute.

**Flags (no `=` sign):**

| Flag | Effect |
|---|---|
| `nourlencode` | Skip `urlencode()` on the page name (useful for query strings with special characters) |
| `noprefix` | Strip namespace prefix from auto-generated link text |

**Link text** is the bare argument (no `=`). If omitted, falls back to the `href` value; with `noprefix`, falls back to the page title without namespace.

**Internal vs external links:** if `href` starts with `http://`, `https://`, or `ftp://`, the value is used as-is. Otherwise it is treated as a wiki page name and resolved through `$wgArticlePath`.

#### Examples

External link:
```
{{#alink: href=https://www.mediawiki.org | target=_blank | rel=nofollow | MediaWiki }}
```

Internal wiki page:
```
{{#alink: href=Example_page | target=_blank | Example page }}
```

Internal link with special characters in query string (skip URL encoding):
```
{{#alink: href=Special:FormEdit/Myform/Mypage?MyTemplate[Myparam]=Acción | nourlencode | Trigger action }}
```

Internal link, display title without namespace:
```
{{#alink: href=User:John_Smith | noprefix }}
```

With `data-*` attribute:
```
{{#alink: href=Main_Page | data-tracking=nav | Home }}
```

---

### `#aimg` — image tag

```
{{#aimg: src=<url or file name> | <attributes> }}
```

**Allowed attributes:** `src`, `rel`, `title`, `alt`, `class`, `id`, `content`, `itemprop`, and any `data-*` attribute.

If `src` does not start with a recognized protocol, it is treated as a MediaWiki file name and resolved to its full URL via `wfFindFile()`. If the file does not exist in the wiki, `src` is left unchanged.

#### Examples

External image:
```
{{#aimg: src=https://example.com/logo.png | alt=Logo | class=site-logo }}
```

Wiki-hosted file:
```
{{#aimg: src=Example.png | alt=Example image | title=An example }}
```

---

## Development

Install dependencies:
```bash
composer install
```

Lint (syntax check + executable-bit check):
```bash
composer test
```

Fix executable bits:
```bash
composer fix
```

PHP CodeSniffer (requires `mediawiki/mediawiki-codesniffer` installed separately):
```bash
vendor/bin/phpcs
```

There are no automated unit tests. Manual testing requires a running MediaWiki instance with the extension loaded.

## Notes

- Output is passed through `$parser->insertStripItem()` to prevent further wiki parsing of the raw HTML.
- Using raw `<a>` tags bypasses MediaWiki's link tracking (incoming/outgoing links are not recorded in the database). Use standard wikitext links when link tracking matters.

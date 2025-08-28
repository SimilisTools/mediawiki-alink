Alink
===============

Extension for printing customizable anchor links in MediaWiki.

Examples:

```
{{#alink:href=https://www.mediawiki.org|target=_blank|rel=nofollow|MediaWiki}}
```

if no http in href, we consider wiki pages. Link text is the parameter without any '='.

```
{{#alink:href=Example_page|target=_blank|Example page for wiki}}
```

If we want to avoid urlencoding, we sample add as parameter nourlencode

```
{{#alink:href=Special:FormEdit/Myform/Mypage?MyTemplate[Myparam]=Acción|nourlencode|Trigger action}}
```

If we want that automatically a wiki page is shown without prefix (namespace), we use noprefix parameter

```
{{#alink:href=User:John_Smith|noprefix}}
```

# To consider

* Render wiki links in wikitext format. Only importance is about incoming/outcoming links storage in MW database






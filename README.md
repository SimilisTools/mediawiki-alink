mediawiki-alink
===============

Extension for printing customizable anchor links in MediaWiki.

Examples:

{{#alink:href=https://www.mediawiki.org|target=_blank|rel=nofollow|MediaWiki}}

if no http in href, we consider wiki pages. Link text is the parameter without any '='.

{{#alink:href=Example_page|target_blank|Example page for wiki}}


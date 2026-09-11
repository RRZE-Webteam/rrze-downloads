[![Aktuelle Version](https://img.shields.io/github/package-json/v/rrze-webteam/rrze-downloads/main?label=Version)](https://github.com/RRZE-Webteam/rrze-downloads)
[![Release Version](https://img.shields.io/github/v/release/rrze-webteam/rrze-downloads?label=Release+Version)](https://github.com/rrze-webteam/rrze-downloads/releases/)
[![GitHub License](https://img.shields.io/github/license/rrze-webteam/rrze-downloads)](https://github.com/RRZE-Webteam/rrze-downloads)
[![GitHub issues](https://img.shields.io/github/issues/RRZE-Webteam/rrze-downloads)](https://github.com/RRZE-Webteam/rrze-downloads/issues)

# RRZE Downloads

Anzeige von Listen von Mediendateien als Downloadliste, sowie zusätzlich Einführung von Taxonomien (Kategorien und Tags) für Meiden in der Meidenbibliothek

## Contributors

* RRZE-Webteam, http://www.rrze.fau.de 

## Copyright

GNU General Public License (GPL) Version 3

## Documentation

See documenation at https://www.wp.rrze.fau.de

## Feedback

* https://github.com/RRZE-Webteam/rrze-ac/issues
* webmaster@rrze.fau.de



## Hinweis

Dieses Plugin ist veraltet und wird in naher Zukunft deaktiviert werden. Die Einführung der Taxonomien für die Mediathek wird durch ein anderes Plugins (RRZE Settings) geleistet werden.

## Dokumentation

### Einstellungsmenü

RRZE Downloads

### Shortcode

Der Shortcode  `[downloads]` erzeugt wahlweise eine Listeansicht, Tabelle oder reine Textlinks aller in der Mediathek verfügbaren Download-Dateien.

Ist der Server so konfiguriert, dass beim Upload von PDFs oder z.B. DOCs automatisch Vorschaubilder generiert werden, sollte die Konstante PREVIEW_ENABLED in config.php auf "true" gesetzt werden, um neben reinen Textlinks und Icons auch Vorschaubilder auswählbar zu machen.


Attribute:
<pre>
category
tags
type
format
htmlpre
htmlpost
htmlitempre
htmlitempost
search_application
search_image
search_video
search_audio
search_text
showsize
showcreated
showexcerpt
showcontent
errormsg
orderby
sort
</pre>

Beispiele und detailierte Informationen zu den Attributen finden Sie unter <a href="https://www.wordpress.rrze.fau.de/plugins/fau-und-rrze-plugins/rrze-downloads/">https://www.wordpress.rrze.fau.de/plugins/fau-und-rrze-plugins/rrze-downloads/</a>

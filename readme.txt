RRZE-Downloads
 Wordpress-Plugin zur Darstellung von Downloadlisten
 von Dateien der Mediathek
====================================================
 


DOWNLOADS

    GITHub-Repo:
        https://github.com/RRZE-Webteam/RRZE-Downloads
    
    

AUTHOR 
   RRZE-Webteam , http://www.rrze.fau.de


CREDITS & COPYRIGHT

   GNU General Public License (GPL) Version 2 



HOWTO

Das Plugin aktiviert Kategorien und Tags für die Medienbibliothek.
Über den Shortcode [downloads] können Dateien der Mediathek angezeigt
werden.


= Dateien einer Kategorie anzeigen
[downloads category="downloads"]


=Kategorie durch Tags einschränken

[downloads category="downloads" tags="bla"]

Es können auch weiteer Tags ergänzt werden. Innerhalb der Tags handelt es sich 
um eine "ODER"-Beziehung.

[downloads category="downloads" tags="bla, blub"]

 
= Ausgabeformate
== Liste

[downloads category="downloads" format="liste"]

== Tabelle

[downloads category="downloads" format="table"]


== Eigenes Format: Änderungen der Vor- und Nachtags

[downloads category="downloads" format="bluber" htmlpre="dl" htmlpost="dl" htmlitempre="dd" htmlitempost="dd"]


=Anzeige von Erstellungsdatum, Beschreibung, Excerpt, Size

Excerpt ("Auszug"/"Kuzbeschreibung") anzeigen:
[downloads category="downloads" showexcerpt="true"]

Beschriebung anzeigen:
[downloads category="downloads" showcontent="true"]

Erstellungsdatum anzeigen:
[downloads category="downloads" showcreated="true"]

Dateigröße anzeigen (per Default an):
[downloads category="downloads" showsize="true"]

Oder ausschalten:
[downloads category="downloads" showsize="false"]


= Beschränung auf Dateitypen: audio, video, attachment, text

Nur Anwendungsdateien (z.B. Office) anzeigen:
[downloads category="downloads" search_application="true"]

Application ist per Default an. Wenn audio, video, attachment, text alle auf "false" gestellt sind, werden alle Typen angezeigt.

Nur Dateien vom Form "Audio" anzeigen:
[downloads category="downloads" search_audio="true" search_application="false"]

Nur Videodateien anzeigen:
[downloads category="downloads" search_video="true" search_application="false"]

Nur Textdateien anzeigen:
[downloads category="downloads" search_text="true" search_application="false"]

Hier eine Ausgabe von Bilder aus der Kategorie , inkl Excerpt und in Tabellenform:
[downloads category="downloads" search_image="true" search_application="false" format="table" showexcerpt="true"]


= Sonstiges
Für den Fall dass keine Dateien gefunden wird, wird eine Fehlermeldung angezeigt.
Möchte man diese ändern, kann man das Attribut "errormsg" nutzen:
   errormsg="NIX DA!!"



FEEDBACK & BUGS

Please use github for submitting new features or bugs:
 https://github.com/RRZE-Webteam/RRZE-Downloads/issues

or send an email to 
 webmaster@rrze.fau.de


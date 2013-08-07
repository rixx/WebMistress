Viergewinnt
===========

This is a project for the Web Engineering course at DHBW Stuttgart 2013. The goal was to implement the game Captain's Mistress using only php, javascript with jQuery and a MySQL database.

Implementation details, required configuration of the web server aswell as a SQL dump to get you startet may be found in the doc/ directory. See below for information on how to set this project up (webserver configuration etc).

----------------------------

Dies ist ein Projekt für den Web-Engineering-Kurs an der DHBW Stuttgart 2013. Das Ziel war es, das Spiel "Vier gewinnt" mithilfe von php, javascript mit jQuery und einer MySQL-Datenbank zu implementieren.

Genauere Informationen über die Implementierung sowie ein SQL-Dump fürs erste Aufsetzen sind im doc/-Verzeichnis zu finden. Informationen über das Aufsetzen und notwendige Konfigurieren das Webservers: siehe unten.


Installation & Setup
====================

DB Setup
--------

Set up a MySQL db - there is a SQL dump in `doc/viergewinntdump.sql` that will set you up with a database complete with two test users, `foo` (password `foopw`) and `bar` (password `barpw`). You need to insert your authentication details into `lib/connectDB.php`.

----------------------------

Es wird eine MySQL-Datenbank benötigt, die mithilfe des SQL-Dumps in `doc/viergewinntdump.sql` aufgesetzt werden kann. Der SQL-Dump enthält auch zwei Testuser: `foo` (Passwort `foopw`) und `bar` (Passwort `barpw`). Die Authentifizierungsdaten zur Datenbank müssen in `lib/connectDB` angegeben werden.


Web Server
----------

You basically only need to configure your web server to see `public` as `DocumentRoot` and `/index.php` as `DirectoryIndex` (Apache syntax).

----------------------------

Dem Webserver müssen das Verzeichnis `public` als `DocumetRoot` und `/index.php` als `DirectoryIndex` angegeben werden (ausgehend von einem Apache-Server).



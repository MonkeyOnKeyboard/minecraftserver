# Minecraftserver
Ilch 2.1.X Modul zur Verwaltung von Minecraft-Servern

# Installation

alle Dateien, in ihrer Ordnerstrucktur hochladen (*Ilch2Root*/application/modules/minecraftserver/)

Nach Uploaden aller Datein muss das Modul im Backend bei der Module Übersicht unter Nicht installierte Module installiert werden.

#### Usage
Um die erweiterten Server Informationen zu bekommen, muss die server.properties des Server folgende Einstellungen haben:

enable-query=true
query.port=25565

Wenn enable-query deaktiviert ist (false) werden nur die Basisinformationen empfangen. Also nur die Daten _DIR_/plugins/MinecraftServerBasic.php wird dann genutzt.

Das Modul muss außerdem noch unter Menü verlinkt werden.

# Minecraftserver-Daten updaten
Die Minecraft-Server lassen sich per Cronjob aktualisieren oder per Aufruf der Frontend-Seite. Dies ist in den Settings einstellbar.
Um die Minecraft-Server per Cronjob zu aktualisieren, muss der Job folgenden Link aufrufen: http://DOMAIN/index.php/minecraftserver/index/update

# Haftungsausschluss
Ich übernehme keine Haftung für Schäden, welche durch dieses Modul entstehen. 



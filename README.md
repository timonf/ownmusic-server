OwnMusic-Server (WIP)
=====================

Music serving service for own music library for multiple users.

(Planned) features:

 *  Uploading music via web interface (working) or select folder on local storage
 *  Web client (working via HTML5 audio tag)
 *  Multiple users (with different roles for each user)
 *  Creating playlists
 *  Downloadable playlists
 *  Simple API
 
 
Requirements
------------

 *  PHP 5.6 with Command Line Interface
 *  PDO compatible database (like MySQL)
 *  Web-server (optional, you can use integrated PHP server)
 *  Some legal MP3s, for example: [Pornophonique](http://pornophonique.de/music.php) :)
 *  Some PHP.INI var changes, when you want to upload music files:
 
        post_max_size = 50M ; or higher
        upload_max_filesize = 50M  ; or higher



Installation (development mode)
-------------------------------

 *  `composer install` – installs all dependencies for this project.
 *  `bin/console doctrine:database:create` – Creates the database you have specified before
    in `app/config/parameters.yml`.
 *  `bin/console doctrine:schema:create --force` – Creates all database tables you will need
 *  `bin/console app:user:create` – Creates an admin user
 *  `bin/console server:run` – Runs the server on localhost:8000


Updating (development mode)
---------------------------

 *  `app/console doctrine:schema:update --force` – Updates the database
 
 
Future plans
------------

There are some nice features for the future. The main goal is to have something like Deezer, Napster or Spotify
for an own music library. Here are some of our planned features:

 *  iOS/Android App
 *  Parse ID3 tags
 *  Shared playlists
 *  Playlist import and export
 *  Parsing song information and validate them online
 *  Outsource server bundle
 *  Optional outsourceable file server (SFTP for example)
  

# Saga

![Logo](https://cloud.githubusercontent.com/assets/1554039/10742302/c1f3c46e-7c2c-11e5-8fa7-40865791976c.jpg)

[Read more about Saga here] (http://dismagazine.com/issues/73345/mathew-dryhurst-data-sagacity-and-site-specificity/)


Saga Installation Guide & Setup Instructions

=== SAGA ===

Contributors: matdryhurst, fawadrashid
Tags: Saga

Saga is an art project exploring website specific expression online.

== Installation ==

1. Copy all files in a subfolder or the root of your webserver.
2. Make a new mysql database in your mysql server using phpmyadmin or another mysql management tool/console. Import the sql script sagacity_smartembed.sql into your newly created database.
3. Edit the file database.php which is placed in your application in application/config. Change the database hostname, username and password to point to your newly created database.
4. Copy the database.php file to the folder /application/config/development as well. Make sure the file has the correct database credentials.
5. Make sure your webserver supports mod_rewrite. You may need to enable support for it on your webserver.
6. Next up locate your apache httpd-vhosts.conf or your httpd.conf file. Depending on your environment and operating system the location and format of this file may vary. You will need to edit this file and point the DocumentRoot to the location of the public folder located within the application.
7. Make sure the public folder and application/modules/embedcontent/templates folders have adequate permission as the templates are created in these folders. Set permissions on these folders something like 755
8. Login credentials for administrative backend are u:admin@smartembeds.com p:123. Url for administrative panel is http://<your host address>/admin/embeds/templates
9. The application has been tested and development on PHP 5.4 & MySQL 5.6.20
10. Please ensure that your web server is setup to handle file uploads with size at least 500MB as embed templates can be very large. The max_upload_size and max_post_size size are typically found in php.ini and can be set there. 

==USAGE==

Adding a video:

1) Make a template. Download the original Saga_one template and modify it to taste, or create one from scratch.

2) Upload this template via the admin interface

3) Navigate to ‘Embeds’ on the admin interface menu. Select a name for the project, your template and click the ‘is active’ box. Once you click ‘Create Embed content’ your file should be live and shareable.

As default, the video you will find in my first Saga template is sagatest.mp4. The easiest way to add your own video is to create a new template and include it in your 
/media folder, however depending on your server speed I can also recommend using Amazon Web Services for smoother streaming.

For Browsers, you need to point to your video in both the index.html file (line 71) and the site.js file (line 51:  var movieArray)

For Mobile, upload a compressed version of your video to the site.js file (line 400: movieArray)


Chaining media:

var movieArray in the site.js file lets you dictate a chain of videos to play through Saga, like a channel. By default, I have sagatest.mp4 and sagatwo.mp4 chained. 

Popups/ expressions:

Saga uses Mozilla’s Popcorn.js to be able to trigger popups or expressions on the timeline. You can read about how to use Popcorn here (http://popcornjs.org/documentation) or simply play around with the templated expression already in the site.js file (under var movieEvents). 

Currently you can trigger text and images to appear above the video at designated times. 


Tracking your video:

When you are logged in to your admin interface, you can track the IP and time of each post in the history section. There you will be told what video what posted when, and what template was used.

Cloning instances of your video:

Once someone has posted your media, you are able to make changes to the embed in that location by clicking on the pencil logo to the left. Once this is done, a new entry will appear in history with a dedicated hash that corresponds to the new folder visible on your server (under /public/static). When you edit this folder, those changes will appear in the location that you desired.


Uploading new templates:

In the admin section, you can navigate to ‘templates’ at the top. This will list all templates currently hosted on your server, and you may upload a new one by clicking ‘new’ in the top right of your environment. You will need to compress your template into a .zip file in order for it to register correctly.

WARNING: When you are zipping your template, select all of the folders (index.html, /js etc) and compress that way. If you compress a folder containing those folders, the system will eventually return an error. 


== Frequently Asked Questions ==
TODO

=== Where can I get more help? ===

Please get in touch with me on Twitter (@matdryhurst).

== Screenshots ==

TODO

== Changelog ==

TODO

== Contributors ==

* [fawadrashid](http://www.ndataconsulting.com/)
* [jawadrashid](http://www.ndataconsulting.com/)
* [asadaijazarain](http://www.ndataconsulting.com/)
* [othermeans] (http://othermeans.us)


== Contributing ==

We'd welcome contributions from anyone else working with the Saga project.
Fork the project, submit issues, and get in touch by whatever means.

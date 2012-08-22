# DataSift HTTP POST Receiver

A leightweight, fast and simple REST service to recived DataSift Push data, and write to a file. Written using PHP Slim framework - http://www.slimframework.com/

## Install

  * Upload to web aserver - enable mod_reqwrite if required to use .htaccess
  * Make sure /app/data and /app/logs are writable by the web server
  * REST endpoint is availble at "/" to POST requests

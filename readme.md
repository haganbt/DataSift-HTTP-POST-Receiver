# DataSift HTTP POST Receiver

A lightweight, fast and simple REST service to receive DataSift Push data, and write to a file. Written using PHP Slim framework - http://www.slimframework.com/

## Features

  * Receive HTTP POST JSON data from DataSift, and write each interaction object to a new line within a file.
  * Logging capability 

## Install

  * Upload to a web server - enable mod_reqwrite if required to use .htaccess
  * Make sure /app/data and /app/logs are writable by the web server
  * REST endpoint is availble at "/" to POST requests

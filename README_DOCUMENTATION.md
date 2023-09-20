# Project Name

**RESTful API** that serves vessel tracks from a DB 

## Table of Contents

- [Tools](#tools)
- [Installation](#installation)
- [Usage](#usage)


## Tools

Project was build using Laravel 10 Framework, PHP 8.1, MySQL
No other prerequisites are needed.

## Installation

The following commands must get executed in order to get the project up and running
- `php artisan serve` : get the serve up
- `php artisan migrate` : create the DB
- `php artisan app:import-vessel-tracks` : seed the DB using "storage/tracks/ship_positions.json"

## Usage

Using Postman the user can hit the following GET endpoint to retrieve vessel tracks

<url>:<port>/api/vessel-tracks?mmsi[]=247039300&mmsi[]=311486000&coordinates[min_lat]=30&coordinates[max_lat]=42.05627
    &coordinates[min_lon]=16.19508&coordinates[max_lon]=20&interval[start_time]=1372683960&interval[end_time]=1372700520

The endpoint can accept the following
- mmsi or mmsi[]
- coordinates[] #it's optional but when provided needs all the following min_lat, max_lat, min_lon, max_lon
- interval[] #can work with both start_time, end_time or one of the two 

The following content types can be supported:
- application/json
- application/hal+json
- application/xml
- text/csv
- 
The above can be tested providing this header: Content-Type = <some_content_type> 

Throttling per IP has been set to 10 requests.
For logging [Request, Response, Error] Laravel's file system has been used. Check "storage/logs/laravel.log".
Tests can be executed running `php artisan test`.

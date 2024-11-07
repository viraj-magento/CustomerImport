# Mage2 Module Viraj CustomerImport

    ``viraj/module-customerimport``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Customer Import via csv and json files

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Viraj`
 - Enable the module by running `php bin/magento module:enable Viraj_CustomerImport`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Install the module composer by running `composer require viraj-magento/module-customerimport`
 - enable the module by running `php bin/magento module:enable Viraj_CustomerImport`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration
bin/magento customer:import <profile> <filepath>
-  Command for importing customers


## Specifications

 - Console Command
	- CustomerImport

 - Json Profile Import
   - php bin/magento customer:import json var/import/sample.json
   - Specify file path in command e.g -var/import/sample.json or pub/import/sample.json

 - Csv Profile Import
   - php bin/magento customer:import csv var/import/sample.csv
   - Specify file path in command e.g -var/import/sample.csv or pub/import/sample.csv


## Attributes




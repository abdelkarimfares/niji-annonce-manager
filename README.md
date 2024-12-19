# niji-ad-manager

The Niji Ad Manager is a Magento 2 module designed to manage advertisements within your Magento store. This module allows you to create, manage, and display advertisements on your category page easily.

**Author**: Abdelkarim Fares (abdelkarimfares94@gmail.com)

## Features

- Ad Management: Create, update, and delete advertisements.
- Logging: Monitor ad creation and validation logs with integrated logging features.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)

## Installation
To install the Niji Ad Manager module via Composer, follow these steps:
1. Add the module to your project:
```shell 
composer require niji/module-ad-manager
```
2. Enable the module:
```shell
php bin/magento module:enable Niji_AdManager 
```
3. Run the setup upgrade to register the module:
```shell 
php bin/magento setup:upgrade 
```

## Usage
To create a new ad or manage existing ads:

1. Log in to the Magento Admin Panel.
2. Navigate to the Ad Manager in the sidebar menu.
3. Use the form to create new ads or manage the existing ones.

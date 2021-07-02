# Drc Systems Display Third Party Users

> A simple wordpress plugin to display users in table on custom endpoint from third party API.

![PHP Quality Assurance](https://github.com/inpsyde/php-coding-standards/workflows/PHP%20Quality%20Assurance/badge.svg)

-------------

# Installation

## Plugin Installation

The plugin can be installed via Composer by the name **`drcsystems/display-third-party-users`**.

It means they can be installed by adding the entry to composer.json `require-dev`:

```json
{
    "require-dev": {
        "drcsystems/display-third-party-users": "^1"
    }
}
```

or via command line with: 

```shell
$ composer require drcsystems/display-third-party-users --dev
```

## Plugin Requirements

- Php 5.6 or later
- Wordpress 5 or later

(The default target version is PHP 7.0+ and Wordpress 5.7)

-------------

# Usage

## Basic usage

When the plugin is installed via Composer, and dependencies are updated, everything is
ready and you can view the plugin in wp-admin under plugin where you need to activate it.


There are options that can be used to customise which can be found under Settings->Third Party Users in wp-admin


## Configuration

After activating the plugin go to Settings->Third Party Users in wp-admin and change the  [`Endpoint Slug`] if you want other wise the default value will be used.

Following API is used as default to display users: 

```shell
https://jsonplaceholder.typicode.com/users
```

(You can change the API but make sure your API has the same response structure as the default API)

Visit the page with your [`Endpoint Slug`] to view the data in table

```json
http://YOUR_DOMAIN_NAME/ENDPOINT_SLUG

OR

https://YOUR_DOMAIN_NAME/ENDPOINT_SLUG
```

## Customization

You can display more columns in the table using this filter hook:

```shell
wpdtpu_datatable_columns
```

For e.g.,

```shell
function wpdtpu_get_columns($data){
	$data[] = 'email'; //valid column name
	return $data;
}

add_filter( 'wpdtpu_datatable_columns', 'wpdtpu_get_columns',1 );
```

-------------
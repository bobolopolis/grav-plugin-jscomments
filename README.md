# Grav JSComments Plugin

**JSComments** is a [Grav](http://github.com/getgrav/grav) plugin which allows Grav to integrate comments into individual pages from Disqus / IntenseDebate and Facebook comments system.

Enabling the plugin is very simple. Just install the plugin folder to `/user/plugins/` in your Grav install. By default, the plugin is enabled, providing some default values.

# Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the resulting folder to `jscomments`.

>> It is important that the folder be named `jscomments` as this is the folder referenced in the plugin's code.

The contents of the zipped folder should now be located in the `/your/site/grav/user/plugins/jscomments` directory.

>> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav), the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) plugins, and a theme to be installed in order to operate.

# Usage

### Initial Setup

Place the following line of code in the theme file you wish to add jscomments for:

```
{% if (config.plugins.jscomments.enabled) %}{% include 'jscomments.html.twig' %}{% endif %}
```

This code works best when placed within the content block of the page, just below the main `{{ page.content }}` tag. This will place it at the bottom of the page's content.

>> NOTE: Any time you are making alterations to a theme's files, you will likely want to duplicate the theme folder in the `user/themes/` directory, rename it, and set the new name as your active theme. This will ensure that you don't lose your customizations in the event that a theme is updated.

### Options

You have the ability to set a number of variables that affect the JSComments plugin. These variables include your site's `account`, which is used by plugin to identify the community associated with the instance and `provider` used for identify the provider you want use. You can also more specifically refine the page ID, URL, and specifically disable comments for a specific page.

These options can exist in two places. Primarily, your user defaults will be set within the **jscomments.yaml** file in the `user/config/plugins/` directory. If you do not have a `user/config/plugins/` already, create the folder as it will enable you to change the default settings of the plugin without losing these updates in the event that the plugin is updated and/or reinstalled later on.

Alterantively, you can override these defaults within the

Here are the variables available:

**Common**
```
provider: (disqus|intensedebate|facebook)
account:
url: (default: Page URL)
disabled: (default: false)
```

**Disqus** plus common variables:
```
title: (default: Page Title)
id: (default: Page URL)
developer: (default: false)
```

**IntenseDebate** plus common variables:
```
id: (default: Page URL)
```

**Facebook** plus common variables:
```
lang: (default: en_US)
numposts: (default: 5)
color_scheme: (default: light)
width: (default: 100%)
```

If you want to change any of these settings for a specific page you can do so via the page's header. Below is an example of how these settings can be used.

```
jscomments:
  provider: disqus
  account: disqus_shortname_example
  title: Different title page
  id: page-slug-example
```

If you wish to set default options that remain static across all pages with comments enabled, you can do so in `/user/config/plugins/jscomments.yaml`. Here is an example:

```
provider: disqus
account: disqus_shortname_example
developer: false
disabled: false
```

For most users, only the **provider** and **account** option will need to be set. This will pull the comments settings from your account and pull information (such as the page title) from the page.


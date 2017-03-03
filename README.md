Restrict Username
-----------------

A Joomla plugin to add character restrictions to the username field.

If you like this extension, please review it at the Joomla Extensions Directory.

Introduction
------------

This is a user plugin for Joomla that adds a validation layer to the username field.

The plugin has a number of configuration parameters that allow you to specify exactly what this validation should look like.


Version History
----------------
* 1.0.0     2016-07-03: Initial release.


Installation
----------------
This is a standard Joomla plugin. Installation is via Joomla's extension manager.


Usage
----------------
The plugin has a number of configuration parameters:

* Min and Max length: These two parameters allow you to enforce a minimum and maximum length for usernames.

* Custom error message: Use this to define the error message that will be displayed if the validation fails. If you leave it blank, the system will generate a default error message, which shows a bullet-point list of permitted character types. This default message can of course be modified as well, by using Joomla's language translation overrides, but will still be in bullet-point format. This custom error message field is useful if you want a differently formatted error message.

* Use custom expression: Setting this parameter to 'Yes' will trigger the display of a 'Custom regular expression' free text field below it. This then allows you to enter a regular expression for the validation. If you are familiar with regular expression syntax, this will give you complete freedom to define your own username restrictions. This is an advanced option: If you are not familiar with regular expressions, you should leave this setting switched off and use the Yes/No options below it instead. Additionally, if you define a custom expression, you should also define a custom error message (see above), as the standard error message relies on the settings of the remaining fields.

* Allow spaces, upper case, lower case, numbers, dots, dashes: These fields allow you to configure whether to allow these types of character in usernames.

* Allow Cyrillic, Arabic, Hebrew, Extended Latin: These fields allow you to configure whether to allow characters from various languages in usernames.

* Allow Symbols: Setting this to 'Yes' will trigger an additional field allowing to specify exactly which symbols to allow.

* Allow email addresses: This option looks the same as the others in the config form, but internally it works separately in that it is validated using Joomla's built in email address validation, rather than using a regular expression. This check is done in addition to the other validations, so if you set this to allowed, you must also (at the very least) set Allow Symbols and include the '@' sign, otherwise it will fail on that even though you are allowing email addresses. Likewise, it is possible to switch this option off but still have an email address accepted as valid if your other options allow the characters.


Limitations
----------------



Motivation
----------------
This plugin was written from scratch as a response to a request for a similar feature to be built into Joomla. See https://github.com/joomla/joomla-cms/issues/14275.


To Do
-----

* Is the 'Allow Email' feature actually useful? Maybe remove it.
* Could add other language scripts if requested.


Caveats
-------


License
----------------
As with all Joomla extensions, this plugin is licensed under the GPL, in this case GPLv3. The full license document should have been included with the source code.

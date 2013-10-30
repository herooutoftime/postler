postler
=======

Postler is a MODx plugin/cron/component task to import mails into MODx resources.

* Postler will read your mail and create MODx resources.
* Postler will also update your MODx resources if you reply to it.
** You will receive a mail to reply to on success
** You can choose by which property you want to update ('pagetitle' or TV)
* Postler is also willing to delete MODx resources.
** Option 1: In subject via case insensitive keywords (comma separated e.g.: 'delete, remove')
** Option 2: In CC via delete address
** Both can be set via system settings
* Postler translates markdown (inline and as attachment) to HTML. (SOON)
* Postler is also capable of finding content in HTML mails (XPATH Query)
* Postler allows multiple settings to be customized by you.
* Postler needs the PHP imap extension installed.
* Postler has several system settings which will allow as much flexibility
* Postler has a grid panel with some information regarding the imports and enables manual importing

## Do It!
* Handle updates via email reply as best as possible and strip the quoted mail

## Usage
* Go to System -> System Settings, choose *postler* namespace and edit the settings according to your needs
* Either via snippet - put [[!postler]] into a resource
* Or via plugin - enable the **postler** plugin (it will be triggered when a logged in user inits the web context)

_Initial idea credits go out to Wordpress_
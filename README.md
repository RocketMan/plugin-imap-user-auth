plugin-imap-user-auth
=====================

IMAP user authentication for Kanboard

Author
------

- Jim Mason <jmason@ibinx.com>
- License MIT

Requirements
------------

- Kanboard >= 1.0.35

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/IMAPUserAuth`
3. Clone this repository into the folder `plugins/IMAPUserAuth`

Note: Plugin folder is case-sensitive.

Configuration
-------------

Go to Settings > Integrations > IMAP User Authentication

* **In the `Domain` field**, specify the domain name suffix for IMAP
    authentication

The value specified for this option will be appended to the username.
In addition, the plugin will use this value as the address of the IMAP
server.

* **Leave the `Mailbox` field blank**, unless your IMAP server has a
different address to the domain specified above, or usernames in your
IMAP server do not use domain name suffixes.

The value of the Mailbox option is of the form:

    {localhost:993/imap/ssl/novalidate-cert/notls}

See [imap_open](http://php.net/manual/en/function.imap-open.php) for
a list of the available mailbox flags.

You may specify `Mailbox` alone or in combination with `Domain`.

If both options are specified, the value specified by Mailbox is the
address of the IMAP server, while the value specified by Domain will
be appended to the username.

Users
-----

You will need to setup a user in Kanboard for each user that will be
authenticating via IMAP.  Tick the `Remote user` checkbox for each IMAP
user.  The `Disallow login form` checkbox must NOT be ticked.

The Kanboard username should match the IMAP username.  If the IMAP
username contains a domain (e.g., user@domain.com), then specify the
domain in the `Domain` setting, as per above.  In this case, the
Kanboard username should match the user portion of the IMAP username.
When logging into Kanboard, the user may specify either the user
portion only or the fully qualified username.

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

![screenshot](https://raw.githubusercontent.com/RocketMan/plugin-imap-user-auth/master/screenshot.png "Settings")

* **Domain**: Specify the domain name for IMAP authentication

The value specified for this option will be appended to the username.
In addition, the plugin will use this value as the address of the IMAP
server.

For example, if your IMAP usernames are of the format user@domain.com,
then you will specify 'domain.com' as the value for Domain; by default,
the plugin will authenticate to the IMAP server at domain.com.

If your IMAP usernames are simple names with no domain suffix, then
leave this field blank and instead use Mailbox below to specify the server.

* **Mailbox**:  **Leave this field blank**, unless your IMAP server
has a different address to the Domain specified above, **or** usernames
in your IMAP server do not use domain name suffixes.

The value of the Mailbox option is of the form:

    {some.server.com:993/imap/ssl/novalidate-cert/notls}

See [imap_open](http://php.net/manual/en/function.imap-open.php) for
a discussion of the format and a list of the available flags.

You may specify Mailbox alone or in combination with Domain.

If both options are specified, the value specified by Mailbox is the
address of the IMAP server, while the value specified by Domain will
be appended to the username.

Users
-----

You will need to setup a user in Kanboard for each user that will be
authenticating via IMAP.  Tick the `Remote user` checkbox for each IMAP
user.  The `Disallow login form` checkbox must NOT be ticked.

The Kanboard username should match the IMAP username, exclusive of any
domain suffix.  If the IMAP username includes a domain suffix (e.g.,
user@domain.com), then specify the domain in the Domain setting above.
In this case, the Kanboard username should be just the user portion of
the IMAP username.  When logging into Kanboard, the user may specify
either the user portion only or the fully qualified username.

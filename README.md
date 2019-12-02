IMAP User Authentication Plugin for Kanboard
============================================
[![Build Status](https://travis-ci.org/rocketman/plugin-imap-user-auth.svg?branch=master)](https://travis-ci.org/rocketman/plugin-imap-user-auth)

Login to Kanboard using your IMAP credentials

Author
------

- Jim Mason <jmason@ibinx.com>
- License MIT

Requirements
------------

- Kanboard >= 1.2.8
- PHP IMAP module

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

### Domain

Specify the domain name for IMAP authentication.

Example:  If your IMAP usernames are of the form user@example.org,
then you will specify 'example.org' as the value for Domain; by default,
the plugin will authenticate to the IMAP server at example.org.

**IMPORTANT:** If your IMAP usernames are simple names with no domain
suffix, then **leave this field blank** and instead use IMAP Server to
specify the server.

### IMAP Server

Address of your IMAP server, together with optional port number and
flags.  In many cases, you may **leave this field blank**.  This
setting is necessary only if Domain is blank or your IMAP server has a
different address from the domain name specified in Domain.

Some example IMAP Server settings:

  * `imap.example.org:993/imap/ssl/notls` *(IMAP with implicit TLS)*
  * `imap.example.org:143/imap/tls` *(IMAP with explicit TLS)*

Where *imap.example.org* is your IMAP server.

**IMPORTANT:** If your IMAP TLS certificate is invalid, then disable
certificate validation by adding `/novalidate-cert` to the IMAP Server setting.

See [imap_open](http://php.net/manual/en/function.imap-open.php) for a
discussion of the format of this field and a list of the available flags.

**NOTE:** You may specify IMAP Server alone or in combination with Domain.

If both options are specified, the value specified by IMAP Server is the
address of the IMAP server, while the value specified by Domain will
be appended to the username.

Users
-----

You will need to setup a user in Kanboard for each user that will be
authenticating via IMAP.  Tick the `Remote user` checkbox for each IMAP
user.  The `Disallow login form` checkbox must NOT be ticked.

The Kanboard username should match the IMAP username, exclusive of any
domain suffix.  If the IMAP username includes a domain suffix (e.g.,
user@example.org), then specify the domain in the Domain setting above.
In this case, the Kanboard username should be just the user portion of
the IMAP username.  When logging into Kanboard, the user may specify
either the user portion only or the fully qualified username.

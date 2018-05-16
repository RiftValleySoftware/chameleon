**1.0.0.2018** *(May 16, 2018)*

- Includes the latest BADGER, with token ID 1.

**1.0.0.2017** *(May 15, 2018)*

- Includes the latest BADGER, with improved vetting.

**1.0.0.2016** *(May 13, 2018)*

- Loosened write perms on users, so that the login does not have to be a login manager to modify many of the items (however, only a login manager can modify the "login_manager" context).
- Fixed an issue where a warning was emitted when there was no response to a search for IDs.
- Removed the token label stuff. You know what? It's too complicated for this level, and is better left to the higher-level implementation.
- Changed deleted security logins (which become token placeholders) to have a read ID of the token's ID. The write remains -1 (God-only).

**1.0.0.2015** *(May 12, 2018)*

- Made sure that the language precedence is done correctly.

**1.0.0.2014** *(May 11, 2018)*

- Updated to the latest BADGER, with its security tweaks.

**1.0.0.2013** *(May 10, 2018)*

- Added some more support for COBRA's auditing functionality.

**1.0.0.2012** *(May 9, 2018)*

- Adds support for the special "decomissioning" of login IDs.

**1.0.0.2011** *(May 8, 2018)*

- Added support for COBRA user creation.
- Added "garbage collection" to the collection classes.

**1.0.0.2010** *(May 3, 2018)*

- Added the user collection class.

**1.0.0.2009** *(May 2, 2018)*

- Updated to the latest BADGER, with its security tweaks.

**1.0.0.2008** *(April 27, 2018)*

- Added the "fuzzing" ability from BADGER.
- Added flexibility for arrayed extension dirs (for COBRA).

**1.0.0.2007** *(April 24, 2018)*

- Added support for a basic key/value pair facility.

**1.0.0.2006** *(April 21, 2018)*

- Added support for an "owner" collection class.

**1.0.0.2005** *(April 17, 2018)*

- Found one more Postgres issue (the payload), and fixed that.
- Added explicit sorting to the generic search, so there is predictability in the behavior of the system.

**1.0.0.2004** *(April 16, 2018)*

- Got the system working with Postgres. Really. For realsies this time.

**1.0.0.2003** *(April 15, 2018)*

- Got the system working with Postgres.

**1.0.0.2002** *(April 13, 2018)*

- Added more tests for security.
- The BADGER system now uses an object cache. We test that here.
- Tweaked the collection to make sure that contained (children) elements are always in the data database (not the security DB).

**1.0.0.2001** *(April 10, 2018)*

- Improved and added new tests.

**1.0.0.2000** *(April 9, 2018)*

- Beta.

**1.0.0.0000** *(March 28, 2018)*

- Initial Development Tag.
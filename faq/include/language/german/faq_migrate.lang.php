<?php
/* *************************************************************************
 Id: faq_migrate.lang.php


 Tim Gall
 Copyright (c) 2009-2018 osfaq.oz-devworx.com.au - All Rights Reserved.
 http://osfaq.oz-devworx.com.au

 This file is part of osFaq.

 Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
 For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

 ************************************************************************* */

define('OSF_MIGRATE_FAQ_EXISTS', 'FAQ %s already exists... continuing to next FAQ');

define('OSF_MIGRATE_CATS_IMPORTED', 'FAQ Categories imported %s');
define('OSF_MIGRATE_FAQS_IMPORTED', 'FAQs imported %s');
define('OSF_MIGRATE_FAQS_IGNORED', 'Duplicate FAQs ignored %s');

define('OSF_MIGRATE_HEADING', 'Import/Export');
define('OSF_OST2OSF_HEADING', 'Ready to Copy FAQs from osTicket');
define('OSF_OSF2OST_HEADING', 'Ready to Copy FAQs from osFAQ');

define('OSF_OST2OSF_DESCRIPTION', 'Copy FAQs and Categories from osTicket-KB to osFAQ.<br><br>
FAQs and categories set as private or un-published in osTicket-KB will be set to disabled (hidden) in osFAQ.');

define('OSF_OST2OSF', 'Copy FAQs from osTicket-KB to osFAQ');
define('OSF_IMPORT_NOW', 'Import now');

define('OSF_OSF2OST_DESCRIPTION', 'Copy FAQs and Categories from osFAQ  to osTicket-KB.');
define('OSF_OSF2OST', 'Copy FAQs from osFAQ to osTicket-KB');

define('OSF_COPY_FAQ', 'Import FAQs');

define('OSF_MIGRATE_DESCRIPTION', 'Copy FAQs and Categories from one FAQ manager system to another.');

define('OSF_DUPS_IGNORED', 'Duplicates will be ignored');
define('OSF_DUPS_WARN', 'WARNING: Everything will be imported. This may create duplicates! Especially if you have imported the KB before');

define('OSF_OPTIONS', 'Options');

define('OSF_OMIT_DUPS', 'Omit Duplicates from importing? (highly recommended)');
define('OSF_CAN_FAQS', 'Add ALL newly imported FAQs to canned responses?');
define('OSF_LIMIT_TO', 'Limit to');

// temp message
define('OSF_MIGRATE_NOT_IMPLEMENTED_YET', 'This functionality will be implemented in a future release of osFAQ.');
?>
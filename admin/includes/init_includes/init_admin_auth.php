<?php
/**
 * @package admin
 * @copyright Copyright 2003-2013 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Sun Jul 1 12:08:22 2012 +0100 Modified in v1.5.1 $
 */

if (!defined('IS_ADMIN_FLAG')) die('Illegal Access');

define('SUPERUSER_PROFILE', 1);

$hasDoneStartWizard = TRUE;

// admin folder rename required
if (!defined('ADMIN_BLOCK_WARNING_OVERRIDE') || ADMIN_BLOCK_WARNING_OVERRIDE == '')
{
  if (basename($_SERVER['SCRIPT_FILENAME']) != FILENAME_ALERT_PAGE . '.php')
  {
    if (substr(DIR_WS_ADMIN, -7) == '/admin/' || substr(DIR_WS_HTTPS_ADMIN, -7) == '/admin/')
    {
      zen_redirect(zen_href_link(FILENAME_ALERT_PAGE));
    }
    $check_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/../zc_install';
    if (is_dir($check_path))
    {
      zen_redirect(zen_href_link(FILENAME_ALERT_PAGE));
    }
  }
}
if (basename($_SERVER['SCRIPT_FILENAME']) != FILENAME_ALERT_PAGE . '.php')
{

  if (strpos(strtolower($PHP_SELF),FILENAME_PASSWORD_FORGOTTEN.'.php') !== FALSE &&
  substr_count(strtolower($PHP_SELF), '.php') > 1)
  {
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (!(basename($PHP_SELF) == FILENAME_LOGIN . ".php"))
  {
    $page = basename($PHP_SELF, ".php");
    if (!isset($_SESSION['admin_id']))
    {
      if (!(basename($PHP_SELF) == FILENAME_PASSWORD_FORGOTTEN . '.php'))
      {
        zen_redirect(zen_href_link(FILENAME_LOGIN, 'camefrom=' . basename($PHP_SELF) . '&' .  zen_get_all_get_params(), 'SSL'));
      }
    }

    if (!in_array($page, array(FILENAME_DEFAULT,FILENAME_ADMIN_ACCOUNT,FILENAME_LOGOFF,FILENAME_ALERT_PAGE,FILENAME_PASSWORD_FORGOTTEN,FILENAME_DENIED,FILENAME_ALT_NAV)) &&
        !zen_is_superuser())
    {
      if (check_page($page, $_GET) == FALSE)
      {
        zen_redirect(zen_href_link(FILENAME_DENIED, '', 'SSL'));
      }
    }

  }

  if ((basename($PHP_SELF) == FILENAME_LOGIN . '.php') &&
  (substr_count(dirname($PHP_SELF),'//') > 0 || substr_count(dirname($PHP_SELF),'.php') > 0))
  {
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  if (STORE_NAME == '' || STORE_OWNER == '')
  {
  	$hasDoneStartWizard = FALSE;
  	if (!in_array($page, array(FILENAME_DEFAULT,FILENAME_LOGOFF,FILENAME_ALERT_PAGE,FILENAME_PASSWORD_FORGOTTEN,FILENAME_DENIED,FILENAME_ALT_NAV)) && isset($_SESSION['admin_id']))
  	{
  		zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
  	}
  }
}

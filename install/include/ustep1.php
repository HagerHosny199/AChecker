<?php
/************************************************************************/
/* AChecker                                                             */
/************************************************************************/
/* Copyright (c) 2008 - 2011                                            */
/* Inclusive Design Institute                                           */
/*                                                                      */
/* This program is free software. You can redistribute it and/or        */
/* modify it under the terms of the GNU General Public License          */
/* as published by the Free Software Foundation.                        */
/************************************************************************/
// $Id$

if (!defined('AC_INCLUDE_PATH')) { exit; }
session_unset();	//clear session before using it
$_SESSION = array();
print_progress($step);

if (isset($_POST['submit']) && (trim($_POST['old_path']) != '')) {
	if ((strpos($_POST['old_path'], '/') === false) && is_dir('../../'.$_POST['old_path'])) {
		if ( file_exists('../../'.$_POST['old_path'] . '/include/config.inc.php') ) {
			
			require('../../'.$_POST['old_path'] . '/include/constants.inc.php');
			$progress[] = 'Found AChecker version <kbd><b>'.VERSION . '</b></kbd> in path <kbd><b>'.$_POST['old_path'].'</b></kbd>.';

			if (!version_compare(VERSION, $new_version, '<')) {
				$errors[] = 'The version upgrading (<kbd><b>'.VERSION.'</b></kbd>) is not older than the new version (<kbd><b>'.$new_version.'</b></kbd>).';
			}

			if (!$errors) {
				$progress[] = 'Will be upgrading from version <kbd><b>'.VERSION.'</b></kbd> to version <kbd><b>'.$new_version.'</b></kbd>.';
				print_feedback($progress);

				require('../../'.$_POST['old_path'] . '/include/config.inc.php');

				echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post" name="form">';
				echo '<input type="hidden" name="step" value="2" />';
				echo '<input type="hidden" name="old_path" value="'.$_POST['old_path'].'" />';

				echo '<input type="hidden" name="db_login" value="'.urlencode(DB_USER).'" />';
				echo '<input type="hidden" name="db_password" value="'.urlencode(DB_PASSWORD).'" />';
				echo '<input type="hidden" name="db_host" value="'.DB_HOST.'" />';
				if (defined('DB_PORT')) {
					echo '<input type="hidden" name="db_port" value="'.DB_PORT.'" />';
				} else {
					echo '<input type="hidden" name="db_port" value="3306" />';
				}
				echo '<input type="hidden" name="db_name" value="'.DB_NAME.'" />';

				if (defined('TABLE_PREFIX')) {
					echo '<input type="hidden" name="tb_prefix" value="'.TABLE_PREFIX.'" />';
				} else {
					echo '<input type="hidden" name="tb_prefix" value="" />';
				}
				if (defined('SITE_NAME')) {
					echo '<input type="hidden" name="site_name" value="'.urlencode(SITE_NAME).'" />';
				} else {
					echo '<input type="hidden" name="site_name" value="'.$_defaults['site_name'].'" />';
				}
				if (defined('HEADER_IMAGE')) {
					echo '<input type="hidden" name="header_img" value="'.HEADER_IMAGE.'" />';
				} else {
					echo '<input type="hidden" name="header_img" value="'.$_defaults['header_img'].'" />';
				}
				if (defined('HEADER_LOGO')) {
					echo '<input type="hidden" name="header_logo" value="'.HEADER_LOGO.'" />';
				} else {
					echo '<input type="hidden" name="header_logo" value="'.$_defaults['header_logo'].'" />';
				}
				if (defined('HOME_URL')) {
					echo '<input type="hidden" name="home_url" value="'.HOME_URL.'" />';
				} else {
					echo '<input type="hidden" name="home_url" value="'.$_defaults['home_url'].'" />';
				}

				if (defined('MAIL_USE_SMTP')) {
					echo '<input type="hidden" name="smtp" value="'.(MAIL_USE_SMTP ? 'TRUE' : 'FALSE').'" />';
				} else {
					echo '<input type="hidden" name="smtp" value="FALSE" />';
				}
				if (defined('AC_FORCE_GET_FILE')) {
					echo '<input type="hidden" name="get_file" value="'.(AC_FORCE_GET_FILE ? 'TRUE' : 'FALSE').'" />';
				} else {
					echo '<input type="hidden" name="get_file" value="FALSE" />';
				}
				echo '<input type="hidden" name="admin_password" value="'.urlencode(ADMIN_PASSWORD).'" />';

				if (defined('ADMIN_USERNAME')) {
					echo '<input type="hidden" name="admin_username" value="'.ADMIN_USERNAME.'" />';
				} else {
					echo '<input type="hidden" name="admin_username" value="'.$_defaults['admin_username'].'" />';
				}

				if (defined('ADMIN_EMAIL')) {
					echo '<input type="hidden" name="admin_email" value="'.ADMIN_EMAIL.'" />';
				} else {
					echo '<input type="hidden" name="admin_email" value="'.$_defaults['admin_email'].'" />';
				}
				if (defined('EMAIL')) {
					echo '<input type="hidden" name="contact_email" value="'.EMAIL.'" />';
				} else if (defined('ADMIN_EMAIL')) {
					echo '<input type="hidden" name="contact_email" value="'.ADMIN_EMAIL.'" />';
				} else {
					echo '<input type="hidden" name="contact_email" value="'.$_defaults['admin_email'].'" />';
				}
				if (defined('EMAIL_NOTIFY')) {
					echo '<input type="hidden" name="email_notification" value="'.(EMAIL_NOTIFY ? 'TRUE' : 'FALSE').'" />';
				} else {
					echo '<input type="hidden" name="email_notification" value="'.$_defaults['email_notification'].'" />';
				}

				if (defined('AC_EMAIL_CONFIRMATION')) {
					echo '<input type="hidden" name="email_confirmation" value="'.(AC_EMAIL_CONFIRMATION ? 'TRUE' : 'FALSE').'" />';
				} else {
					echo '<input type="hidden" name="email_confirmation" value="FALSE" />';
				}

				if (isset($MaxFileSize)) {
					echo '<input type="hidden" name="max_file_size" value="'.$MaxFileSize.'" />';
				} else {
					echo '<input type="hidden" name="max_file_size" value="'.$_defaults['max_file_size'].'" />';
				}
				
				echo '<input type="hidden" name="ill_ext" value="' . $_defaults['ill_ext'] . '" />';

				if (defined('CACHE_DIR')) {
					echo '<input type="hidden" name="cache_dir" value="' . CACHE_DIR . '" />';
				} else {
					echo '<input type="hidden" name="cache_dir" value="' . $_defaults['cache_dir'] . '" />';
				}

				if (defined('AC_TEMP_DIR')) {
					echo '<input type="hidden" name="content_dir" value="'.AC_TEMP_DIR.'" />';
				} else {
					echo '<input type="hidden" name="content_dir" value="'.$_defaults['content_dir'].'" />';
				}
				echo '<input type="hidden" name="new_version" value="'.$new_version.'" />';
				echo '<input type="hidden" name="old_version" value="'.VERSION.'" />';
				echo '<p align="center"><input type="submit" class="button" value=" Next &raquo; " name="submit" /></p></form>';
				return;
			}
		} else {
			$errors[] = 'Directory was found, but the old configuration file cannot be found.';
		}
	} else {
		$errors[] = 'Directory does not exist relative to the new installation.';
	}
}

if (isset($progress)) {
	print_feedback($progress);
}

if (isset($errors)) {
	print_errors($errors);
}

?>
<p>Please specify the location of the old AChecker installation.</p>

<ol>
	<li>Release Candidate (RC) installations cannot be upgraded.</li>
	<li>Depending on the size of the existing courses, some steps (particularly 2 and 6) of the upgrade may require considerable time to complete.</li>
	<li>All installed language packs will be deleted.</li>
	<li>Some installed themes may not be supported by this version.</li>
	<li>All extra modules will have to be reinstalled before they can be enabled again.</li>
</ol>

<p>Select the old AChecker installation directory below.</p>

<?php
	$dirs = scandir('../../');
	$path = realpath('../../').'/';
	$current_dir = basename(realpath(getcwd() .'../../'));
	foreach ($dirs as $key => $value) {
		if ($value == '.' || $value == '..') {
			unset($dirs[$key]);
		}
		if ($current_dir == $value) {
			unset($dirs[$key]);
			continue;
		}
		if (!is_dir($path . $value) || !file_exists($path . $value . '/include/config.inc.php')) {
			unset($dirs[$key]);
		}
	}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form">
<input type="hidden" name="new_version" value="<?php echo $new_version; ?>" />
<input type="hidden" name="step" value="1" />

<table width="70%" class="tableborder" cellspacing="0" cellpadding="1" border="0" align="center">
<tr>
	<td class="row1"><div class="required" title="Required Field">*</div><b><label for="dir">Old Directory Name:</label></b><br />
		The old directory must be at the same level as the current directory.</td>
		<td class="row1" valign="middle">
		<?php if ($dirs): ?>
			<select name="old_path">
				<?php foreach ($dirs as $dir): ?>
					<option value="<?php echo htmlspecialchars($dir); ?>"><?php echo $dir; ?>/</option>
				<?php endforeach; ?>
			</select>
		<?php else: ?>
			<em>None found.</em>
		<?php endif; ?>
		</td>
</tr>
</table>

<br />

<?php if ($dirs): ?>
	<br /><p align="center"><input type="submit" class="button" value="Next &raquo; " name="submit" /></p>
<?php endif; ?>

</form>
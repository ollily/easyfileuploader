<?php
/**
* @version		2.9.2.1
* @author		Michael A. Gilkes (jaido7@yahoo.com)
* @copyright	Michael Albert Gilkes
* @license		GNU/GPLv2
*/

/*

Easy File Uploader Module for Joomla!
Copyright (C) 2010-2020  Michael Albert Gilkes

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

//get the module class designation
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

//set up the custom text
$labelText = $params->get('efu_label');
$buttonText = $params->get('efu_button');
$questionText = $params->get('efu_question');
$yesText = $params->get('efu_yes');
$noText = $params->get('efu_no');
$maxSize = round(intval($params->get('efu_maxsize')) / 1024, 0, PHP_ROUND_HALF_DOWN);

if ($params->get('efu_custom') == 0)
{
	$labelText = Text::_('MOD_EFU_LABEL_TEXT');
	$buttonText = Text::_('MOD_EFU_BUTTON_TEXT');
	$questionText = Text::_('MOD_EFU_QUESTION_TEXT');
	$yesText = Text::_('JYES');
	$noText = Text::_('JNO');
}

//specify the action
$action = Uri::current().Uri::query;

?>
<div class="<?php echo $moduleclass_sfx;?>">
	<!-- Display the Results of the file upload if uploading was attempted -->
	<?php if (isset($_FILES[$params->get('efu_variable')])) : ?>
		<?php for ($j = 0; $j < count($result); $j++) : ?>
			<?php 
			/**
			* Just a quick note here. I decided to add a class, efum-hide, which contains
			* a single block, display=none;. I could have just added the style directly or 
			* not display the div code at all. I just think adding the class looks cleaner. 
			* The only problem can be browser caching of the page, that may not refresh the 
			* styles.css file where the class is defined.
			*/
			$show_class = "";
			if ($result[$j]['show'] == false) : 
				$show_class = " efum-hide";
			endif; ?>
			<div class="efum-alert efum-<?php echo $result[$j]['type'].$show_class;?>">
			<span class="close-btn" onclick="this.parentNode.style.display = 'none';">&times;</span>
			<?php echo $result[$j]['text']; ?>
			</div>
		<?php endfor; ?>
	<?php endif; ?>
	<!-- Input form for the File Upload -->
	<form enctype="multipart/form-data" action="<?php echo $action; ?>" method="post">
		<div class="mt-1">
            <?php if ($params->get('efu_multiple') == "1"): ?>
            <label for=<?php echo '"'.$params->get('efu_variable').'[]"'; ?>><?php echo $labelText; ?></label><br/>
            <?php else: ?>
            <?php echo $labelText; ?><br />
            <?php endif; ?>
            <?php
            $max = intval($params->get('efu_multiple'));
            for ($i = 0; $i < $max; $i++): ?>
            <input type="file" name=<?php echo '"'.$params->get('efu_variable').'[]"'; ?> id=<?php echo '"'.$params->get('efu_variable').'[]"'; ?> /><br/>
		<?php endfor; ?>
		<?php echo 'Max. '.$maxSize.' KB'; ?>
		</div>
		<?php if ($params->get('efu_default_replace') == false && $params->get('efu_replace') == true): /* 1 means 'Yes' or true. 0 means 'No' or false. */ ?>
		<div class="mt-1">
            <div><?php echo $questionText; ?></div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="radio" name="answer" value="1" class="form-check-input" /><?php echo $yesText; ?>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="radio" name="answer" value="0" class="form-check-input" checked /><?php echo $noText; ?>
                </label>
            </div>
        </div>
		<?php endif; ?>
		<div class="mt-2">
		    <input class="btn btn-primary" type="submit" name="submit" value=<?php echo '"'.$buttonText.'"'; ?> />
		</div>
	</form>
</div>
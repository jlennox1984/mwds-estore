<?php
defined('_JEXEC') or die('Restricted access');

/*
 *
 * Get the template parameters
 *
 */
$filename = JPATH_ROOT . DS . 'templates' . DS . $mainframe->getTemplate() . DS . 'params.ini';
if ($content = @ file_get_contents($filename)) {
	$templateParams = new JParameter($content);
} else {
	$templateParams = null;
}
/*
 * hope to get a better solution very soon
 */

$hlevel = $templateParams->get('headerLevelComponent', '2');

echo '<h' . $hlevel . '>';
echo JText :: _('Read more...');
echo '</h' . $hlevel . '>';
echo '<ul>';
foreach ($this->links as $link) {
	echo '<li>';
	echo '<a class="blogsection" href="';
	echo JRoute :: _('index.php?option=com_content&amp;task=view&amp;id=' . $link->id);
	echo ' ">';
	echo $link->title;
	echo '</a>';
	echo '</li>';
}
echo '</ul>';
?>
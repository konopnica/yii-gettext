<?php
/**
 * GetText class file.
 * @author Dylan Ferris <dylan@kanux.org>
 * @link http://github.com/acerix/yii-gettext
 * @copyright Copyright &copy; Dylan Ferris 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */


/**
 * Sets the php locale and 
 *
 * @package ext.gettext
 * @version $Id: GetText.php 2012-04-22 acerix $
 * @link http://github.com/acerix/yii-gettext
 * @author Dylan Ferris <dylan@kanux.org>
 * @copyright Copyright &copy; Dylan Ferris 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */


/**
 * GetText application component.
 * Used for registering php-GetText functionality.
 */
class GetText extends CApplicationComponent
{
	/**
	 * @var GetText domain.
	 */
	public $domain = 'yii';

	/**
	 * @var Language in canonical format.
	 */
	public $language = 'en_us';

	/**
	 * @var Directory containing gettext messages.
	 */
	public $locale_dir;

	/**
	 * Initialize php's gettext.
	 */
	public function init()
	{
		$this->language = $this->getLocaleID($this->language);
		if (!$this->locale_dir) $this->locale_dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'locale';
		setlocale(LC_ALL, $this->language);
		header('Content-Language: '.str_replace('_', '-', $this->language));
		$this->bindDomain();
	}

	/**
	 * Bind the gettext domain and make it the default
	 */
	public function bindDomain()
	{
		bind_textdomain_codeset($this->domain, 'utf-8');
		bindtextdomain($this->domain, $this->locale_dir);
		textdomain($this->domain);
	}

	/**
	 * Convert yii's canonical locale to the format required for gettext ( reverse of CLocale::getCanonicalID() )
	 */
	static public function getLocaleID($id)
	{
		$locale = explode('_',$id);
		if (isset($locale[1])) $locale[1] = strtoupper($locale[1]);
		return implode('_',$locale);
	}

	/**
	 * Test if gettext is translating.
	 */
	static public function demo($id)
	{
		$locale = explode('_',$id);
		if (isset($locale[1])) $locale[1] = strtoupper($locale[1]);
		return implode('_',$locale);
	}

}

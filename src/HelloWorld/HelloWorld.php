<?php
/*
 * This file is part of the container-interop-experiments package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GM\InteropExperiments\HelloWorld;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @package container-interop-experiments
 */
class HelloWorld
{
    /**
     * @var string[]
     */
    private static $greetings = [
        'en' => 'Hello World',
        'it' => 'Ciao Mondo',
        'es' => 'Hola Mundo',
        'de' => 'Hallo Welt',
        'fr' => 'Bonjour le Monde',
        'pt' => 'Olá Mundo',
        'zh' => '你好，世界',
        'hi' => 'नमस्ते दुनिया',
    ];

    /**
     * @var string[]
     */
    private static $names = [
        'en' => 'English',
        'it' => 'Italian',
        'es' => 'Spanish',
        'de' => 'German',
        'fr' => 'French',
        'pt' => 'Portuguese',
        'zh' => 'Chinese',
        'hi' => 'Hindi',
    ];

    /**
     * @var string
     */
    private $defLang = 'en';

    /**
     * @param string $defLang
     */
    public function __construct($defLang = 'en')
    {
        array_key_exists($defLang, self::$greetings) and $this->defLang = $defLang;
    }

    /**
     * @return string
     */
    public function defaultLanguage()
    {
        return $this->defLang;
    }

    /**
     * @return string[]
     */
    public function supportedLanguages()
    {
        return array_keys(self::$greetings);
    }

    /**
     * @param string $lang
     * @return string
     */
    public function languageName($lang)
    {
        if (! array_key_exists($lang, self::$names)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" language is not a supported language.', $lang)
            );
        }

        return self::$names[$lang];
    }

    /**
     * @param string $lang
     * @return string
     */
    public function sayHello($lang = 'en')
    {
        (is_string($lang) && $lang) or $lang = $this->defLang;

        if (! array_key_exists($lang, self::$greetings)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" language is not a supported language.', $lang)
            );
        }

        return self::$greetings[$lang];
    }
}

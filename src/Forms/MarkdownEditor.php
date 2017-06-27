<?php

namespace Axllent\Gfmarkdown\Forms;

use SilverStripe\Forms\TextareaField;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Director;

/**
 * Markdown Editor using Ace Editor
 */

class MarkdownEditor extends TextareaField
{
    protected $theme;
    protected $rows;
    protected $wrap;
    protected $highlight_active_line;

    public function __construct($name, $title = null, $value = null)
    {
        parent::__construct($name, $title, $value);
        $this->theme = $this->currConfig('theme', 'chrome');
        $this->rows = $this->currConfig('rows', 10);
        $this->wrap = $this->currConfig('wrap', true);
        $this->highlight_active_line = $this->currConfig('highlight_active_line', false);
    }

    /**
     * Sets the theme for the ACE editor markdown editor.
     * @param string
     */
    public function setTheme($theme = 'chrome')
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Sets the "Wrap Mode" on the ACE editor markdown editor.
     * @param boolean $mode true if word wrap should be enabled, false if not
     */
    public function setWrap($boolean = false)
    {
        $this->wrap = $boolean;
        return $this;
    }

    /**
     * Sets the current line highlighting for the ACE editor markdown editor.
     * @param boolean
     */
    public function setHighlightActiveLine($boolean = false)
    {
        $this->highlight_active_line = $boolean;
        return $this;
    }

    /**
     * Check current config else return a default
     * @param String, value
     * @return value
     */
    protected function currConfig($key, $default = false)
    {
        $val = $this->config()->get($key);
        return (isset($val)) ? $val : $default;
    }

    /**
     * Returns the field holder used by templates
     * @return string HTML to be used
     */
    public function FieldHolder($properties = array())
    {
        $this->extraClasses['stacked'] = 'stacked';
        $base = $this->getModuleBase();

        Requirements::css($base . '/css/MarkdownEditor.css');

        Requirements::javascript($base . '/thirdparty/ace/ace.js');
        Requirements::javascript($base . '/thirdparty/ace/mode-markdown.js');
        if (is_file(Director::baseFolder() . $base . '/thirdparty/ace/theme-' . $this->theme . '.js')) {
            Requirements::javascript($base . '/thirdparty/ace/theme-' . $this->theme . '.js');
        }
        Requirements::javascript($base . '/javascript/MarkdownEditor.js');

        return parent::FieldHolder($properties);
    }

    /**
     * Generates the attributes to be used on the field
     * @return Array of attributes to be used on the form field
     */
    public function getAttributes()
    {
        $theme = 'ace/theme/' . trim(htmlspecialchars($this->theme));

        return array_merge(
            parent::getAttributes(),
            array(
                'style' => 'width: 97%; max-width: 100%; height: ' . ($this->rows * 15) . 'px; resize: none;', // prevents horizontal scrollbars
                'data-ace-wrap' => $this->wrap ? true : false,
                'data-ace-theme' => $theme,
                'data-ace-highlight-active-line' => $this->highlight_active_line
            )
        );
    }

    /**
    * Returns the base directory of this module
    * @return string
    */
    private function getModuleBase()
    {
        return basename(dirname(dirname(dirname(__FILE__))));
    }
}

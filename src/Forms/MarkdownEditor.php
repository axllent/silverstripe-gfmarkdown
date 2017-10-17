<?php

namespace Axllent\Gfmarkdown\Forms;

use SilverStripe\Control\Director;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\Forms\TextareaField;
use SilverStripe\View\Requirements;

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
        Requirements::css('axllent/silverstripe-gfmarkdown: css/MarkdownEditor.css');

        Requirements::javascript('axllent/silverstripe-gfmarkdown: thirdparty/ace/ace.js');
        Requirements::javascript('axllent/silverstripe-gfmarkdown: thirdparty/ace/mode-markdown.js');

        $theme = ModuleResourceLoader::singleton()->resolvePath(
            'axllent/silverstripe-gfmarkdown: thirdparty/ace/theme-' . $this->theme . '.js'
        );
        if ($theme) {
            Requirements::javascript('axllent/silverstripe-gfmarkdown: thirdparty/ace/theme-' . $this->theme . '.js');
        }

        Requirements::javascript('axllent/silverstripe-gfmarkdown: javascript/MarkdownEditor.js');

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
}

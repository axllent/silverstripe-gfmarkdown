<?php
namespace Axllent\Gfmarkdown\Forms;

use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\Forms\TextareaField;
use SilverStripe\View\Requirements;

/**
 * Markdown Editor using Ace Editor
 */
class MarkdownEditor extends TextareaField
{
    /**
     * Theme - Ace editor
     *
     * @var mixed
     */
    protected $theme;

    /**
     * Rows - Ace editor
     *
     * @var mixed
     */
    protected $rows;

    /**
     * Wrap - Ace editor
     *
     * @var mixed
     */
    protected $wrap;

    /**
     * Highlight active line - Ace editor
     *
     * @var mixed
     */
    protected $highlight_active_line;

    /**
     * Constructor
     *
     * @param string $name  Name
     * @param string $title Title
     * @param string $value Value
     *
     * @return void
     */
    public function __construct($name, $title = null, $value = null)
    {
        parent::__construct($name, $title, $value);
        $this->theme                 = $this->currConfig('theme', 'chrome');
        $this->rows                  = $this->currConfig('rows', 10);
        $this->wrap                  = $this->currConfig('wrap', true);
        $this->highlight_active_line = $this->currConfig('highlight_active_line', false);
    }

    /**
     * Sets the theme for the ACE editor markdown editor.
     *
     * @param string $theme Theme name
     *
     * @return self
     */
    public function setTheme($theme = 'chrome')
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Sets the "Wrap Mode" on the ACE editor markdown editor.
     *
     * @param boolean $value true if word wrap should be enabled, false if not
     *
     * @return self
     */
    public function setWrap($value = false)
    {
        $this->wrap = $value;

        return $this;
    }

    /**
     * Sets the current line highlighting for the ACE editor markdown editor.
     *
     * @param boolean $value Value
     *
     * @return self
     */
    public function setHighlightActiveLine($value = false)
    {
        $this->highlight_active_line = $value;

        return $this;
    }

    /**
     * Check current config else return a default
     *
     * @param string $key     Confg array key
     * @param string $default Default value is value is unset
     *
     * @return mixed
     */
    protected function currConfig($key, $default = false)
    {
        $val = $this->config()->get($key);

        return (isset($val)) ? $val : $default;
    }

    /**
     * Returns the field holder used by templates
     *
     * @param array $properties Properties array
     *
     * @return string HTML to be used
     */
    public function FieldHolder($properties = [])
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
     *
     * @return Array of attributes to be used on the form field
     */
    public function getAttributes()
    {
        $theme = 'ace/theme/' . trim(htmlspecialchars($this->theme));

        return array_merge(
            parent::getAttributes(),
            [
                // prevents horizontal scrollbars
                'style'                          => 'width: 97%; max-width: 100%; height: ' .
                ($this->rows * 15) . 'px; resize: none;',
                'data-ace-wrap'                  => $this->wrap ? true : false,
                'data-ace-theme'                 => $theme,
                'data-ace-highlight-active-line' => $this->highlight_active_line,
            ]
        );
    }
}

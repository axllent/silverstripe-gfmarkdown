<?php
namespace Axllent\Gfmarkdown\FieldTypes;

use Parsedown;
use SilverStripe\ORM\FieldType\DBText;

class Markdown extends DBText
{
    /**
     * Use a casting object for a field.
     *
     * @var    array
     * @config
     */
    private static $casting = [
        'AsHTML'   => 'HTMLText',
        'Markdown' => 'Text',
    ];

    /**
     * The escape type for this field when inserted into a template - either "xml" or "raw".
     *
     * @var string
     * @config
     */
    private static $escape_type = 'xml';

    /**
     * Render markdown as HTML using Parsedown
     *
     * @return string Markdown rendered as HTML
     */
    public function asHTML()
    {
        $parsedown = new Parsedown();
        $options   = $this->config()->get('options');
        if ($options && is_array($options)) {
            foreach ($options as $fn => $param) {
                if (method_exists($parsedown, $fn)) {
                    $parsedown->{$fn}($param);
                }
            }
        }

        return $parsedown->text($this->value);
    }

    /**
     * Renders the field used in the template
     *
     * @return string HTML to be used in the template
     */
    public function forTemplate()
    {
        return $this->asHTML();
    }
}

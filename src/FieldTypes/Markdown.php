<?php

namespace Axllent\Gfmarkdown\FieldTypes;

use Parsedown;
use SilverStripe\ORM\FieldType\DBText;

class Markdown extends DBText
{
    private static $casting = array(
        'AsHTML' => 'HTMLText',
        'Markdown' => 'Text'
    );

    private static $escape_type = 'xml';

    /**
     * Render markdown as HTML using Parsedown
     *
     * @return string Markdown rendered as HTML
     */
    public function AsHTML()
    {
        $parsedown = new Parsedown();
        $options = $this->config()->get('options');
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
     * @return string HTML to be used in the template
     */
    public function forTemplate()
    {
        return $this->AsHTML();
    }
}

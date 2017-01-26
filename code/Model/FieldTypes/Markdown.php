<?php

namespace Axllent\Gfmarkdown\Model\FieldTypes;

use Parsedown;
use SilverStripe\ORM\FieldType\DBText;

class Markdown extends DBText
{
    public static $casting = array(
        'AsHTML' => 'HTMLText',
        'Markdown' => 'Text'
    );

    public static $escape_type = 'xml';

    /**
     * Render markdown as HTML using Parsedown
     *
     * @return string Markdown rendered as HTML
     */
    public function AsHTML()
    {
        $Parsedown = new Parsedown();
        return $Parsedown->text($this->value);
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

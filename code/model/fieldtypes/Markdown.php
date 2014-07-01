<?php

class Markdown extends Text {

    public static $casting=array(
        'AsHTML'=>'HTMLText',
        'Markdown'=>'Text'
    );


    public static $escape_type='xml';

    /**
     * Checks cache to see if the contents of this field have already been loaded from github, if they haven't then a request is made to the github api to render the markdown
     * @param {bool} $useGFM Use Github Flavored Markdown or render using plain markdown defaults to false just like how readme files are rendered on github
     * @return {string} Markdown rendered as HTML
     */
    public function AsHTML() {
        $Parsedown = new Parsedown();
        return $Parsedown->text($this->value);
    }

    /**
     * Renders the field used in the template
     * @return {string} HTML to be used in the template
     *
     * @see GISMarkdown::AsHTML()
     */
    public function forTemplate() {
        return $this->AsHTML();
    }
}
# Github Flavoured Markdown for Silverstripe

This module adds a field and a data type that allows for Markdown editing in the CMS using
the Github Flavoured Markdown parser [Parsedown](http://parsedown.org/) to render the html.

It includes the [Ace editor](https://ace.c9.io/) for CMS editing.

## Requirements

* Silverstripe ^4.0 || ^5.0

## Installation

`composer require axllent/silverstripe-gfmarkdown`

## Usage

Use the Markdown data type as your fields data type, and the MarkdownEditor field in the CMS for editing.

- Refer to the [Markdown editor configuration](docs/en/MarkdownEditor.md).
- Refer to the [Markdown rendering configuration](docs/en/Markdown.md).

## Example:

```php
<?php

use Axllent\Gfmarkdown\Forms\MarkdownEditor;

class MyPage extends Page
{
    public static $db = array(
        'MarkdownContent' => 'Markdown'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // If you want the Ace markdown editor in the CMS
        $fields->addFieldToTab('Root.Main',
            MarkdownEditor::create('MarkdownContent')
                ->setTheme('github')            // set theme
                ->setRows(20)                   // set number of rows in CMS
                ->setWrap(false)                // disable word wrapping
                ->setHighlightActiveLine(true)  // enable line highlighting
        );

        return $fields;
    }
}
```

## Silverstripe Template:

```html
<div class="content">
    $MarkdownContent  <!-- Will show as rendered html -->
</div>
```

# Markdown Editor Customisation

MarkdownEditor allows you to set the default editor theme, rows and word-wrapping either by setting values in a YAML file
or optionally on a per-editor basis.

Please note that theme names are based on the available theme files found in `thirdparty/ace/`, and consist of the theme
name only (ie: the theme name for `theme-chrome.js` is `chrome`).

## Global Defaults

In a YAML file you can specify default (global) defaults:

```yaml
Axllent\Gfmarkdown\Forms\MarkdownEditor:
   wrap: false
   theme: dawn
   rows: 15
   highlight_active_line: true
```

## Individual Editor Configuration

Each editor instance in the CMS can be customised individually:

```php
<?php

use Axllent\Gfmarkdown\FieldTypes\Markdown;
use Axllent\Gfmarkdown\Forms\MarkdownEditor;

class Product extends Page
{
    public static $db = array(
        'Specifications' => 'Markdown'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main',
            MarkdownEditor::create('Specifications')
                ->setTheme('github')
                ->setRows(20)
                ->setWrap(false)
                ->setHighlightActiveLine(true)
        );

        return $fields;
    }
}

```

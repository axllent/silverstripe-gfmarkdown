# Github Flavoured Markdown for SilverStripe 4

This module adds a field and a data type that allows for Markdown editing in the CMS using
the Github Flavoured Markdown parser [Parsedown](http://parsedown.org/) to render the html.

It includedes the [Ace editor](http://ace.c9.io/) for CMS editing.

## Requirements

* SilverStripe 4.x

## Installation

`composer require axllent/silverstripe-gfmarkdown`

## Usage

Use the Markdown data type as your fields data type, and the MarkdownEditor field in the CMS for editing.

- Refer to the [Markdown editor configuration](docs/en/MarkdownEditor.md).
- Refer to the [Markdown rendering configuration](docs/en/Markdown.md).

## Example:

```php
use Page;
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
        $editor = MarkdownEditor::create('MarkdownContent', 'Page Content (Markdown)');
        $editor->setRows(15); //optional, set number of rows in CMS
        $editor->setWrapMode(true); //optional, turn on word wrapping
        $editor->setTheme('cobalt'); // set theme
        $fields->addFieldToTab('Root.Main', $editor);
        $fields->addFieldToTab('Root.Main',
            MarkdownEditor::create('Specifications')
                ->setTheme('github')            // set theme
                ->setRows(20)                   // set number of rows in CMS
                ->setWrap(false)                // disable word wrapping
                ->setHighlightActiveLine(true)  // enable line highlighting
        );

        return $fields;
    }
}
```

## SilverStripe Template:

```html
<div class="content">
    $MarkdownContent  <!-- Will show as rendered html -->
</div>
```

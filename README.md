Github Flavoured Markdown for SilverStripe 3
============================================

This module adds a field and a data type that allows for Markdown editing in the CMS using
the Github Flavoured Markdown parser [Parsedown](http://parsedown.org/) to render the html.

It is integrated with the [Ace editor](http://ace.c9.io/) for CMS editing.

Silverstripe-gfmarkdown is strongly based on [silverstripe-markdown](https://github.com/UndefinedOffset/silverstripe-markdown).

## Requirements

* SilverStripe 3.x

## Usage

Use the Markdown data type as your fields data type, then use the MarkdownEditor field in the CMS for editing.

### Page class:

```php
class MyPage extends Page {
    public static $db=array(
        'MarkdownContent'=>'Markdown'
    );

    public function getCMSFields() {
        $fields=parent::getCMSFields();

        $editor = new MarkdownEditor('MarkdownContent', 'Page Content (Markdown)');
        $editor->setRows(15); //optional, set number of rows in CMS
        $editor->setWrapMode(true); //optional, turn on word wrapping
        $fields->addFieldToTab("Root.Main", $editor);

        return $fields;
    }
}
```

### Template:

```html
<div class="content">
    $MarkdownContent  <!-- Will show as rendered html -->
</div>
```
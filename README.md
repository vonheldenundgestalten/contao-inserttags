# contao-inserttags
New, clean insert tag handling, adding some custom logic to existing insert tags in Contao 4.x

Also activates rendering of insert tags in the backend - especially nice for custom elements, included subtemplates, icons and many more tricks in content element organisation.

Does not replace it on any kind of backend action that depends on insert tags, and we're not touching the HTML element - that usually is modules or other "bigger" includes.

###New tags

##### {{file_vendor::*}}
Includes php, tpl, xhtml or html5 file where path is relative to ./vendor directory.
f.e. ```{{file_vendor::magmell-agentur/contao-boxes/src/Resources/contao/templates/test.html5}}```

---
##### {{form::*}}
Returns value from $_SESSION['FORM_DATA']

f.e. {{form::firstName}} will return value from:
```php
$_SESSION['FORM_DATA']['firstName'];
```
---

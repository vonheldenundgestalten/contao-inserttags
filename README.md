# contao-inserttags
New, clean insert tag handling, adding some custom logic to existing insert tags in Contao 4.

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

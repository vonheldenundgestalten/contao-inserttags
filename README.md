# contao-inserttags
New, clean insert tag handling, adding some custom logic to existing insert tags in Contao 4.x

### Backend Tag rendering

Activates rendering of insert tags in the backend - especially nice for custom elements, included subtemplates, icons and many more tricks in content element organisation.

We're not touching the HTML element - that usually is modules or other "bigger" includes.

### New tags

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
##### {{get::*}}
Return value from url with function:

```
Input::get($elements[1]);
```
f.e. {{get::movies}} for URL www.example.com/movies/forrest-gump it will reutrn value forrest-gump  
      also it works with classical GET formats example www.example.com/list?movies=forrest-gump will return forrest-gump

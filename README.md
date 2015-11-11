gif2text
=======

Gif image to to Ascii Text..
See also [img2text](https://github.com/dhlwing/img2text)


Example
-------

![](test.gif)


`gif2text test.gif > out.html` [demo](http://dhlwing.github.io/img2text/out.html)


Installation
------------

```bash
$ composer require bigweb/gif2text
```

Usage
-----

```
Usage:
  gif2text <imgfile> 
  gif2text (-h | --help)
```

You also can use it anywhere what you want at your application like this:

```php
use Bigweb\Gif2text\Gif2text;

$options = [
        'maxLen'   => 100,
    ];
$template = __DIR__ . '/template.html';
$img = new Gif2text($gifPath, $template, $options);
echo $img->render();
```

Thanks
------
1. Use https://github.com/docopt/docopt.php to create beautiful command-line interface
2. Use https://github.com/Intervention/image to process image
3. Thanks @hit9, This project stolen from  https://github.com/hit9/img2txt

License
-------

BSD.

# Pletfix Documentation

This is the official documentation for the Pletfix Framework. It is available online at <http://pletfix.com/docs>.

## Licence

A lot of the markdown files in this package originally based off of [Laravel](https://github.com/laravel/docs).

It is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Contribution Guidelines

Contributing to the documentation is pretty simple. 

The documents have the following structure:
~~~
branch
 └── language
      └── markdown files
~~~

If you are submitting documentation for the current stable release, submit it to the corresponding branch. 
For example, documentation for Pletfix 1.0 would be submitted to the 1.0 branch. 
Documentation intended for the next release of Pletfix should be submitted to the master branch.

If you are interested in contributing a translation, please check the [issues list](https://github.com/pletfix/docs/issues) first. If someone is already working on it, we can collaborate on existing work.

If there is no relevant translation in progress, please create an issue so others know you have started the work on that particular language.

You can then fork the repository and add the [two-letter language code (ISO 639-1)](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes) and the translated contents.

If you have any questions feel free to ask the [Pletfix community](http://pletfix.com/community).

## Introduction for Markdown Syntax

[Full documentation of the Markdown syntax — Daring Fireball (John Gruber)](https://daringfireball.net/projects/markdown/)

[Markdown Extra syntax — Michel Fortin](https://michelf.ca/projects/php-markdown/extra/)

### Examples

#### Headers
~~~
# H1
## H2
### H3
#### H4
~~~

#### Horizontal Rule
Three or more Hyphens:
~~~
---
~~~

####Emphasis
~~~
Emphasis, aka italics, with _underscores_.

Strong emphasis, aka bold, with **asterisks**.

Strikethrough uses two tildes. ~~Scratch this.~~
~~~

####Lists
~~~
1. First ordered list item
2. Another item

- Unordered list item
- Another item
~~~

####Blockquotes
~~~
>This is a block
~~~

Tip (highlighted blockquote):
~~~
<div class="tip">This is a tip.</div>
~~~

Note
~~~
<div class="note">This is a note.</div>
~~~

#### Links
~~~
[Google's Homepage](https://www.google.com)
~~~

Shortcut style:
~~~
<http://example.com/>
~~~

#### Named Anchors

Example using a name:
~~~
Take me to [pookie](#pookie)
~~~

And the destination anchor:
~~~
### <a name="pookie"></a>Some heading
~~~

#### Images
~~~
![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png)
~~~

#### Raw Output
<pre>
~~~
Raw Text
~~~
</pre>

#### Code and Syntax Highlighting

Code blocks are part of the Markdown spec, but syntax highlighting isn't. However, many renderers -- like Github's and Markdown Here -- support syntax highlighting. Which languages are supported and how those language names should be written will vary from renderer to renderer. Markdown Here supports highlighting for dozens of languages (and not-really-languages, like diffs and HTTP headers); to see the complete list, and how to write the language names, see the [highlight.js](https://highlightjs.org/static/demo/) demo page.

Inline code:

~~~
Inline `code` has `back-ticks around` it.
~~~

Blocks of code (three or more backticks \` or tilde \~):
<pre>
 ```
 No language indicated, so no syntax highlighting.
 But let's throw in a <b>tag</b>.
 ```
</pre>

<pre>
```php
$s = "PHP syntax highlighting";
echo $s;
```
</pre>

#### Tables

Tables aren't part of the core Markdown spec, but they are part of GFM and Markdown Here supports them. They are an easy way of adding tables to your email -- a task that would otherwise require copy-pasting from another application.

Colons can be used to align columns.
~~~
| Tables        | Are           | Cool  |
| ------------- |:-------------:| -----:|
| col 3 is      | right-aligned |       |
| col 2 is      | centered      |       |
| zebra stripes | are neat      |       |
~~~

#### Inline HTML

You can also use raw HTML in your Markdown, and it'll mostly work pretty well.

#### Backslash Escapes

Markdown allows you to use backslash escapes to generate literal characters which would otherwise have special meaning in Markdown's formatting syntax. For example, if you wanted to surround a word with literal asterisks (instead of an HTML <em> tag), you can backslashes before the asterisks, like this:
~~~
\*literal asterisks\*
~~~

Markdown provides backslash escapes for the following characters:
~~~
\   backslash
`   backtick
*   asterisk
_   underscore
{}  curly braces
[]  square brackets
()  parentheses
#   hash mark
+   plus sign
-   minus sign (hyphen)
.   dot
!   exclamation mark
~~~

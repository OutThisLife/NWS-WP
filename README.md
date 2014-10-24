# NWS-WP
This is a less-than-boilerplate WordPress theme. This theme does not focus so much on giving you basic styles, but rather a strict (yet flexible) foundation to work within. It simplifies adding: widgets, theme options, image sizes, sidebars, JS libraries, CSS, navigation menus, shortcodes. All classes in the classes/ folder are autoloaded via sys/autoloader.php

The themes base is built with schema.org, AngularJS and RequireJS. RequireJS is used to simplify JS loading. AngularJS is to simplify any DOM manipulation via directives. I've also built a way to use WP as a single-page application without having to re-code much (at all). We'll get to that in a bit.

It also gives you a handy toolset to work with when actually coding the theme.

## CSS/JS

This base theme uses SASS along with my custom & modular classes.sass.

It uses CoffeeScript instead of vanilla JS. Learn how to autocompile SASS & CoffeeScript w/ ST2 here if you want to get started: http://www.nwsco.org/autocompiling-sass-coffeescript-sublime-text-2/

JS is modular in this theme, meaning that you only load which JS files you need at the time with RequireJS. By default we load only controllers and directives, but as your application grows you should make changes to the core.coffee file on which to bootstrap first.

I include foundation5 in the theme, but you can remove it. I personally use it for building mobile first.

## functions.php

This is the entire PHP 'bootstrap' of the theme. You can add styles, scripts, image sizes, sidebars, menus, settings, shortcodes and widgets from here with a simple array structure.

There's already a decent example in functions.php, and the syntax is fairly simple. There's not much more to it than what's there already.

### Styles and scripts

This is just a basic format, and it will load in the order that you place them in.

```
->addStyles(array(
  '/path/to/stylesheet1.css',
  '/path/to/stylesheet2.css',
  '/path/to/stylesheet3.css',
)),

->addScripts(array(
  '/path/to/script1.js',
  '/path/to/script2.js',
  '/path/to/script3.js',
)),
```

### Menus

Left is the 'key' that you call with `BackEnd::getMenu('key')` and the right is the friendly version of that.

```
->addMenus(array(array(
  'header' => 'Header Menu',
))),
```

### Sidebars

Add as many like this as you want, and call them with `dynamic_sidebar('slug-version')`. The key "Default Sidebar" would translate to `dynamic_sidebar('default-sidebar')`.

```
->addSidebars(array(
  'Default Sidebar',
)),
```

### Settings

Again, as many as you want and with tabs. Each layer is a tab, as you can see in the default functions.php.

```
->addSettings(array(array(
  # General settings tab
  'General' => array(
    'phone' => array(
    'name' => 'Phone #',
    'type' => 'text',
    'desc' => 'Use [phone] to retrieve this value.',
    ),
  ),

  # Footer settings tab
  'Footer' => array(
    'scripts' => array(
    'name' => 'Extra Scripts',
    'type' => 'textarea',
    'desc' => 'If used, these scripts will be loaded in the footer. Put things like Google Analytics in here.',
    ),
  ),
)),
```

This is all automatic! Isn't that nice?


### Shortcodes

Same deal, the top key is what the client will type, ie `'map' => function()` is `[map]`.

A good idea is to use `ob_start()` and `ob_get_clean()` so you can print/require/get template files without messing up the WP buffer.

```
->addShortcodes(array(array(
  # [example]
  'example' => function() { return 'Hello World!'; },
)),
```

### Widgets

This one is sort of messy, but I've found it very useful for quick widgets. No more giant classes, at least. The 'output' field requires inline PHP, as Widgets can only be classes we have to use `eval()` in order to create them. Use at your own risk.

```
->addWidgets(array(
  # Simple box
  array(
    'id' => 'simpleBox',
    'title' => 'SiteName Simple Box', # This is what the client sees on the back-end
    'desc' => 'This is the widget description',
    'fields' => array(
      array(
        'name' => 'Title',
        'id' => 'title', # This is the $variable name
        'type' => 'text', # Available types are text, textarea and select with another options array
      ),

      array(
        'name' => 'Copy',
        'id' => 'copy',
        'type' => 'textarea',
      ),
    ),

    'output' => '
<div class="widget simple-box">
  <h2><?=$title?></h2>
  <p><?=$copy?></p>
</div>
';
  ),
)),
```

## BackEnd.class.php

At the top of this file, and FrontEnd.class.php you'll see functions that begin with _. These functions are the 'magical' functions that you're using to bootstrap your app. Leave them alone unless you need to tweak how it works.

This file should be used for communicating with WP itself.

### getChildren()

This prints out an HTML list style of either categories (if viewing a blog) or sub-pages of the current page (or parent of the current page). Common use:

```
<?php if ($children = BackEnd::getChildren()): ?>
<nav class="widget page-nav">
  <ul><?=$children?></ul>
</nav>
<?php endif ?>
```

### getCategories() & getTerms($tax)

Does the same thing as getChildren, just for categories.

### getMenu($name, $settings = array())

This returns the WP nav menu that you create with addMenus(), the first paramater being the key that you used to create it. You can pass optional settings that will overwrite the default settings. Like adding a walker, after text, etc.

```
<nav>
  <ul><?=BackEnd::getMenu('header')?></ul>
</nav>
```

### getPostType($type, $settings = array())

This just returns a WP_Query for the post type that you set, with again defaults that you can override in the second paramater. You will use `Template::loop()` more often than not, however.

### getRootParent(), getRootTitle(), getPageDepth()

Returns the most top-level parent ID, title.

`getPageDepth()` returns the 'menu_order' value for the current page.

### getArchiveData()

This will return an object of which post type and which taxonomy we're viewing for on an archive listing.

### getAdjacentPost($dir, $type, $sameCategory = FALSE)

This will return either the previous or next post of any post type. Example usage:

```
$next = BackEnd::getAdjacentPost('next', 'my_post_type');
$prev = BackEnd::getAdjacentPost('prev', 'my_post_type');
```

## FrontEnd.class.php

This class file should only be used for front-end display functionality. Keep it small ;)

### truncate($sting, $limit, $break, $pad)

Simple: takes a string and truncates it to the break and limit that you set.

### parseGallery($content)

This grabs all the media IDs of a gallery. Old function and will be removed in the future.

### typekit($id)

Quick inclusion of a typekit script, add like so: `<?=FrontEnd::typekit('youridhere')?>` to header.php.

### getTitle()

Just returns the title string, structured for YOAST. While technically a 'backend' function, it doesn't do anything interesting and so it's stuck here.

### formatPhone()

Does as it says. Formats all phone types to a proper format.

## GenSiteMap.class.php

My favourite class. This just takes an array listing and creates those pages, and the child pages, with boilerplate content in the order that you place. Saves tons of time:

```
new GenSiteMap(array(
  # "Hello World" page
  array(
    'title' => 'Hello World',
    'children' => array('World', 'Hello', 'Universe'),
  ),

  # "Simple" page
  array('title' => 'Simple Page'),
));
```

## Template.class.php

This takes care of your loops. You'll [almost] never need to utilize `BackEnd::getPostType()` with this. It also fetches snippets for you based on the filename.

But the meat is:

```
Template::loop('post', array(
  'post_type' => 'post',
  'orderby' => 'post_date',
  'posts_per_page' => 10,
));

// OR

Template::loop(function() use ($cfs) {
  // Do some crazy stuff here.
}, array(
  'post_type' => 'my_post_type',
)));
```

It either tries to find `build-{key}` (the first parameter) or tries to use the first parameter as a callable function (you can pass a simple function to it instead of an anonymous one, as well).

Common usage would be something like the above or:

```
<!-- HTML EVERYWHERE -->
<?php Template::loop(function() use ($cfs) { ?>

<figure class="slide">
  <!-- Stuff -->
</figure>

<?php
}, array(
  'post_type' => 'slideshow'
));
?>
```

And the snippet method just returns you the file contents of whatever you request. Snippets can be found in classes/snippets.

## NavWalker.class.php

This prints out the default nav menu, but with itemprop on the anchor tags.

## Settings.class.php, WidgetCreator.class.php

Don't need to touch these at all. They are used to generate our settings page and widgets respectively.

## DevTests.class.php

This is like the developers handy toolbox. Conditional returns for testing purposes, or structuring purposes. Add your IP to the array of `isDeveloper()` and you can add code that your client or users can't see yet.

Expand this as you need, everything is fairly straight forward.

## config.php

Basic definitions for various things, like `assetDir`. assetDir just returns the template directory + '/assets'. This is used like: `<img src="<?=assetDir?>/images/filler-post.jpg" />` so you don't have a giant string everytime you need to call something from your assets directory.

Do whatever you need to here.

# Conclusion

Let me know if you want to see any fixes, or updates to this boilerplate. With the combination of RequireJS, AngularJS, Foundation 5 and this "framework" to dumb down WP (even more) I've seen my development speed incrase tenfold. I hope it helps you, and if not - submit an issue ;)

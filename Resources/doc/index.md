VichTweetFormatterBundle
========================

The `VichTweetFormatterBundle` takes tweets and the tweet entity information 
obtained from the Twitter API and formats the raw tweet string into an html string 
that links user mentions, hashtags, and urls. The `class` and `target` attributes 
of the link tags generated can be configured using the bundle's confguration.

## Installation

Install the bundle files to the `vendor/bundles/Vich/TweetFormatterBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony method for doing this

**Using the vendors script**

Add the following lines in your `deps` file:

```
[VichTweetFormatterBundle]
    git=git://github.com/dustin10/VichTweetFormatterBundle.git
    target=bundles/Vich/TweetFormatterBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```
**Using submodules**
 
If you prefer instead to use git submodules, the run the following:

``` bash
$ git submodule add git://github.com/dustin10/VichTweetFormatterBundle.git vendor/bundles/Vich/TweetFormatterBundle
$ git submodule update --init
```

## Configure the Autoloader

Add the `Vich` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...

    'Vich' => __DIR__.'/../vendor/bundles',
));
```

## Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Vich\TweetFormatterBundle\VichTweetFormatterBundle(),
    );
}
```

## Configure The Bundle

Now open up your `config.yml` file and add the following to configure the 
bundle. Below is the default configuration.

``` yaml
vich_tweet_formatter:
    twig: true # load twig extension
    link_target_attr: _blank # set <a> tag target attribute value
    link_css_class: # configure css classes for generated <a> tags
```

## Format Tweets

Simply have your class implement the `Vich\TweetFormatterBundle\Model\TweetInterface`. 
The interface relies on a `getMessage` method to get the raw tweet string and the 
`getMessageEntities` to get the JSON which represents the tweet entities. Once you 
have implemented this interface, then you can use the `vich_tweet_formatter.formatter' 
service to format the tweets.

``` php
<?php

class MainController extends Controller
{
    public function indexAction()
    {
        // get a tweet instance that implements TweetInterface..
        $tweet = $this->getSomeTweet();

        // format it
        $formatted = $this->get('vich_tweet_formatter.formatter')->format($tweet);

        ...
    }
}
```

## Twig

The bundle also comes packaged with a Twig extension that can be enabled in the 
configuration. Once enabled you can simply use the `vich_format_tweet` function 
in your Twig file to format a tweet message.

``` twig
{{ vich_format_tweet(tweet) }}
```
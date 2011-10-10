<?php

namespace Vich\TweetFormatterBundle\Formatter;

use Vich\TweetFormatterBundle\Formatter\TweetFormatterInterface;
use Vich\TweetFormatterBundle\Model\TweetInterface;

/**
 * TweetFormatter.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
class TweetFormatter implements TweetFormatterInterface
{
    /**
     * @var string $targetAttr
     */
    protected $targetAttr;
    
    /**
     * @var string $cssClass
     */
    protected $cssClass;
    
    /**
     * Constructs a new instance of TweetFormatter.
     * 
     * @param string $targetAttr The a tag target attribute value.
     */
    public function __construct($targetAttr, $cssClass)
    {
        $this->targetAttr = $targetAttr;
        $this->cssClass = $cssClass;
    }
    
    /**
     * {@inheritDoc}
     */
    public function format(TweetInterface $tweet)
    {
        $entityInfo = json_decode($tweet->getMessageEntities(), true);
        if (0 === count($entityInfo)) {
            return $tweet->getMessage();
        }
        
        $regexPairs = array();
        
        foreach ($entityInfo['user_mentions'] as $mention) {
            $handle = sprintf('@%s', $mention['screen_name']);
            $regex = $this->makeRegex($handle, true);
            $replacement = $this->makeUserLink($handle);
            
            $regexPairs[$regex] = $replacement;
        }
        
        foreach ($entityInfo['hashtags'] as $hashtag) {
            $fullHashTag = sprintf('#%s', $hashtag['text']);
            $regex = $this->makeRegex($fullHashTag);
            $replacement = $this->makeHashTagLink($fullHashTag);
            
            $regexPairs[$regex] = $replacement;
        }
        
        foreach ($entityInfo['urls'] as $url) {
            $displayUrl = $url['url'];
            $regex = $this->makeRegex($displayUrl);
            $replacement = $this->makeLink($displayUrl, $displayUrl);
            
            $regexPairs[$regex] = $replacement;
        }
        
        $formattedMessage = $tweet->getMessage();
        foreach ($regexPairs as $regex => $replace) {
            $formattedMessage = preg_replace($regex, $replace, $formattedMessage);
        }
        
        return $formattedMessage;
    }
    
    /**
     * Makes a regular expression out of the specified text.
     * 
     * @param string $text The text.
     * @param boolean True if regex pattern should be case insensitive, false otherwise.
     * @return string The regex.
     */
    protected function makeRegex($text, $caseInsensitive = false)
    {
        $basePattern = '/%s/';
        if ($caseInsensitive) {
            $basePattern .= 'i';
        }
        
        return sprintf($basePattern, preg_quote($text, '/'));
    }
    
    /**
     * Makes an html link tag.
     * 
     * @param string $href The url.
     * @param string $text The display text.
     * @return string The link html.
     */
    protected function makeLink($href, $text)
    {
        return sprintf(
            '<a href="%s" target="%s" class="%s">%s</a>',
            $href, 
            $this->targetAttr,
            $this->cssClass,
            $text
        );
    }
    
    /**
     * Makes an html link for a hashtag.
     * 
     * @param string $hashTag The hash tag.
     * @return string The link html.
     */
    protected function makeHashTagLink($hashTag)
    {
        $href = sprintf('http://www.twitter.com/search/%s', urlencode($hashTag));
        
        return $this->makeLink($href, $hashTag);
    }
    
    /**
     * Makes an html link for a user handle.
     * 
     * @param string $handle The user handle.
     * @return string The link html.
     */
    protected function makeUserLink($handle)
    {
        $href = sprintf('http://www.twitter.com/%s', urlencode(substr($handle, 1)));
        
        return $this->makeLink($href, $handle);
    }
}

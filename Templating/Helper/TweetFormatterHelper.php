<?php

namespace Vich\TweetFormatterBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Vich\TweetFormatterBundle\Model\TweetInterface;
use Vich\TweetFormatterBundle\Formatter\TweetFormatterInterface;

/**
 * TweetFormatterHelper.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
class TweetFormatterHelper extends Helper
{
    /**
     * @var TweetFormatterInterface $formatter
     */
    protected $formatter;
    
    /**
     * Constructs a new instance of TweetFormatterHelper.
     * 
     * @param TweetFormatterInterface $formatter The tweet formatter.
     */
    public function __construct(TweetFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }
    
    /**
     * Gets the canonical name of the helper.
     * 
     * @return string The name.
     */
    public function getName()
    {
        return 'vich_tweet_formatter';
    }
    
    /**
     * Formats the tweet.
     * 
     * @param TweetInterface $tweet The tweet.
     * @return string The formatted html string.
     */
    public function format(TweetInterface $tweet)
    {
        return $this->formatter->format($tweet);
    }
}

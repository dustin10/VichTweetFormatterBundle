<?php

namespace Vich\TweetFormatterBundle\Formatter;

use Vich\TweetFormatterBundle\Model\TweetInterface;

/**
 * TweetFormatterInterface.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
interface TweetFormatterInterface
{
    /**
     * Formats the tweet message.
     * 
     * @param TweetInterface $tweet The tweet.
     * @return string The formatted html string.
     */
    function format(TweetInterface $tweet);
}

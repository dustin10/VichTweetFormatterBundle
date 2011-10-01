<?php

namespace Vich\TweetFormatterBundle\Model;

/**
 * TweetInterface.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
interface TweetInterface
{
    /**
     * Gets the raw message.
     * 
     * @return string The raw message.
     */
    function getMessage();
    
    /**
     * Gets the JSON string containing the tweet entiies.
     * 
     * @return string The JSON tweet entities string.
     */
    function getMessageEntities();
}

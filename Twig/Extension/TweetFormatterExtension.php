<?php

namespace Vich\TweetFormatterBundle\Twig\Extension;

use Vich\TweetFormatterBundle\Templating\Helper\TweetFormatterHelper;
use Vich\TweetFormatterBundle\Model\TweetInterface;

/**
 * TweetFormatterExtension.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
class TweetFormatterExtension extends \Twig_Extension
{
    /**
     * @var TweetFormatterHelper $helper
     */
    protected $helper;
    
    /**
     * Constructs a new instance of TweetFormatterExtension.
     * 
     * @param TweetFormatterHelper $helper The helper.
     */
    public function __construct(TweetFormatterHelper $helper)
    {
        $this->helper = $helper;
    }
    
    /**
     * Returns the canonical name of this extension.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'vich_tweet_formatter';
    }
    
    /**
     * Returns a list of twig functions.
     *
     * @return array An array
     */
    public function getFunctions()
    {
        $names = array(
            'vich_format_tweet'  => 'format',
        );
        
        $funcs = array();
        foreach ($names as $twig => $local) {
            $funcs[$twig] = new \Twig_Function_Method($this, $local, array('is_safe' => array('html')));
        }
        
        return $funcs;
    }
    
    /**
     * Formats the message of the specified tweet adding the entities such as 
     * urls, other users name, etc.
     * 
     * @param TweetInterface $tweet The tweet.
     * @return string The html.
     */
    public function format(TweetInterface $tweet)
    {
        return $this->helper->format($tweet);
    }
}

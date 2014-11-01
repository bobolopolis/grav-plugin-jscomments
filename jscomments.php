<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class JSCommentsPlugin extends Plugin
{
  public static function getSubscribedEvents() {
    return [
      'onPluginsInitialized'  => ['onPluginsInitialized', 0],
      'onTwigTemplatePaths'   => ['onTwigTemplatePaths', 0],
      'onPageInitialized'     => ['onPageInitialized', 0]
    ];
  }

  public function onPluginsInitialized()
  {
    if ( $this->isAdmin() ) {
      $this->active = false;
    }
  }

  public function onTwigTemplatePaths()
  {
    if ( ! $this->active ) return;

    $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  public function onPageInitialized()
  {
    if ( ! $this->active ) return;

    /* save page object */
    $page = $this->grav['page'];

    /* get defaults from config file */
    $defaults = (array) $this->config->get('plugins.jscomments');

    /* define valid providers */
    $providers = [
      'disqus',
      'intensedebate',
      'facebook',
      'muut'
    ];

    /* validate header */
    if ( isset($page->header()->jscomments) ) {
      /* validate provider */
      if ( isset($page->header()->jscomments['provider']) and in_array($page->header()->jscomments['provider'], $providers) ) {
        /* save provider */
        $provider = $page->header()->jscomments['provider'];

        /* merge config with header page */
        $page->header()->jscomments = array_merge($defaults, $page->header()->jscomments);
      } else {
        return; // need pass throw
      }
    } else {
      $page->header()->jscomments = $defaults;
    }
  }
}

<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class JSCommentsPlugin extends Plugin
{
  public static function getSubscribedEvents() {
    return [
      'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
      'onPageInitialized'   => ['onPageInitialized', 0]
    ];
  }

  public function onTwigTemplatePaths()
  {
    $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  public function onPageInitialized()
  {
    /* save page object */
    $page = $this->grav['page'];

    /* get defaults from config file */
    $defaults = (array) $this->config->get('plugins.jscomments');

    /* define valid providers */
    $providers = [
      'disqus',
      'intensedebate',
      'facebook'
    ];

    /* validate header */
    if ( isset($page->header()->jscomments) ) {
      /* validate provider */
      if ( isset($page->header()->jscomments['provider']) and in_array($page->header()->jscomments['provider'], $providers) ) {
        /* save provider */
        $provider = $page->header()->jscomments['provider'];

        /* merge config with header page */
        $page->header()->jscomments = array_merge($defaults, $page->header()->jscomments);

        /* validate auto_content */
        if ( isset($page->header()->jscomments['auto_content']) and $page->header()->jscomments['auto_content'] ) {
          /* save current content */
          $old_content = $page->content();

          /* parse comments template */
          $content = $this->grav['twig']->twig()->render('jscomments.html.twig', ['page' => $page]);

          /* update page with new content */
          $page->content($old_content . $content);
        }
      } else {
        return; // need pass throw
      }
    } else {
      $page->header()->jscomments = $defaults;
    }
  }
}

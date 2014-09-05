<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class CommentsPlugin extends Plugin
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
    $defaults = (array) $this->config->get('plugins.comments');

    /* define valid providers */
    $providers = [
      'disqus',
      'intensedebate',
      'facebook'
    ];

    //die(print_r($page->header()->comments, true));

    /* validate header */
    if ( isset($page->header()->comments) ) {
      /* validate provider */
      if ( isset($page->header()->comments['provider']) and in_array($page->header()->comments['provider'], $providers) ) {
        /* save provider */
        $provider = $page->header()->comments['provider'];

        /* merge config with header page */
        $page->header()->comments = array_merge($defaults, $page->header()->comments);
        
        /* validate auto_content */
        if ( isset($page->header()->comments['auto_content']) and $page->header()->comments['auto_content'] ) {
          /* save current content */
          $old_content = $page->content();

          /* parse disqus comments template */
          $content = $this->grav['twig']->twig()->render('comments.html.twig', ['page' => $page]);

          /* update page with new content */
          $page->content($old_content . $content);
        }
      } else {
        return; // need pass throw
      }
    } else {
      $page->header()->comments = $defaults;
    }
  }
}

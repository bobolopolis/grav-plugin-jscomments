<?php namespace Grav\Plugin;

use Grav\Common\Page\Page;
use Grav\Common\Plugin;

class JSCommentsPlugin extends Plugin
{
  public static function getSubscribedEvents() {
    return [
      'onPluginsInitialized' => ['onPluginsInitialized', 0]
    ];
  }

  public function onPluginsInitialized()
  {
    if ( $this->isAdmin() ) {
      $this->active = false;
      return;
    }

    $this->enable([
      'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
      'onPageInitialized'   => ['onPageInitialized', 0]
    ]);
  }

  public function onTwigTemplatePaths()
  {
    $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  public function onPageInitialized()
  {
    $this->mergeConfig($this->grav['page']);

    $options = $this->grav['config']->get('plugins.jscomments');

    $providers = $options['providers'];

    if ( ! $this->validateProvider($options['provider']) ) {
      $this->grav['config']->set('plugins.jscomments.enabled', false);
      return;
    }
  }

  private function validateProvider( $provider )
  {
    $options = $this->grav['config']->get('plugins.jscomments');

    return ( isset($options['provider']) && array_key_exists($options['provider'], $options['providers']) ) ? true : false;
  }

  private function mergeConfig( Page $page )
  {
    $defaults = (array) $this->grav['config']->get('plugins.jscomments');
    if ( isset($page->header()->jscomments) ) {
      if ( is_array($page->header()->jscomments) ) {
        $this->grav['config']->set('plugins.jscomments', array_replace_recursive($defaults, $page->header()->jscomments));
      }
    }
  }
}

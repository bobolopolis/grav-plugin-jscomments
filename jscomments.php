<?php namespace Grav\Plugin;

use Grav\Common\Page\Page;
use Grav\Common\Plugin;

class JSCommentsPlugin extends Plugin
{
  private $provider;

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
      'onTwigTemplatePaths'   => ['onTwigTemplatePaths', 0],
      'onPageInitialized'     => ['onPageInitialized', 0]
    ]);
  }

  public function onTwigTemplatePaths()
  {
    $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  public function onPageInitialized()
  {
    $this->mergeConfig($this->grav['page']);

    $options = $this->config->get('plugins.jscomments');

    $providers = $options['providers'];

    if ( ! $this->validateProvider($options['provider']) ) {
      return;
    }

    $this->provider = $options['provider'];
  }

  private function validateProvider( $provider )
  {
    $options = $this->config->get('plugins.jscomments');

    return ( isset($options['provider']) && in_array($options['provider'], $options['providers']) ) ? true : false;
  }

  private function mergeConfig( Page $page )
  {
    $defaults = (array) $this->config->get('plugins.jscomments');
    if ( isset($page->header()->jscomments) ) {
      $this->config->set('plugins.jscomments', array_merge($defaults, $page->header()->jscomments));
    }
  }
}

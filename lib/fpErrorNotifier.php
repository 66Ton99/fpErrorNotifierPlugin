<?php

require_once 'util/fpErrorNotifierNullObject.php';

/**
 *
 * @package    fpErrorNotifier
 * 
 * @author     Maksim Kotlyar <mkotlar@ukr.net>
 */
class fpErrorNotifier
{
  /**
   * 
   * @var fpErrorNotifier
   */
  protected static $instance;
  
  /**
   * 
   * @var sfEventDispatcher
   */
  protected $dispather;
  
  /**
   * 
   * @param sfEventDispatcher $dispather
   * 
   * @return void
   */
  public function __construct(sfEventDispatcher $dispather)
  {
    $this->dispather = $dispather;
  }
  
  /**
   * 
   * @return sfEventDispatcher
   */
  public function dispather()
  {
    return $this->dispather;
  }
  
  /**
   * 
   * @param fpBaseErrorNotifierMessage
   * 
   * @return fpBaseErrorNotifierDecorator
   */
  public function decorator(fpBaseErrorNotifierMessage $message)
  {
    $options = sfConfig::get('sf_notify_decorator');
    $class = $options['class'];
    require_once "decorator/{$class}.php";
    return new $class($message);  
  }

  /**
   * 
   * @return fpBaseErrorNotifierDriver
   */
  public function driver()
  {
    $options = sfConfig::get('sf_notify_driver');
    $class = $options['class'];
    if (false !== strpos($class, 'Mail')) {
      require_once "driver/mail/{$class}.php";
    } else {
      require_once "driver/{$class}.php";
    }
    
    return new $class($options['options']); 
  }
  
  /**
   * 
   * @param string $title
   * 
   * @return fpBaseErrorNotifierMessage
   */
  public function message($title)
  {
    $options = sfConfig::get('sf_notify_message');
    $class = $options['class'];
    require_once "message/{$class}.php";
    return new $class($title); 
  }
  
  /**
   * 
   * @param string $title
   * 
   * @return fpBaseErrorNotifierDecorator
   */
  public function decoratedMessage($title)
  {
    return $this->decorator($this->message($title));
  }
  
  /**
   * 
   * @return fpErrorNotifierHandler
   */
  public function handler()
  {
    $options = sfConfig::get('sf_notify_handler');
    $class = $options['class'];
    require_once "handler/{$class}.php";
    return new $class($options['options']); 
  }
  
  /**
   * 
   * @return fpErrorNotifierMessageHelper
   */
  public function helper()
  {
    $options = sfConfig::get('sf_notify_helper');
    $class = $options['class'];
    require_once "message/{$class}.php";
    return new $class;
  }
  
  /**
   * 
   * @return sfContext|fpErrorNotifierNullObject
   */
  public function context()
  {
    if (!class_exists('sfContext') || sfContext::hasInstance()) {
      return new fpErrorNotifierNullObject();
    }
    return sfContext::getInstance();
  }
  
  /**
   * 
   * @return fpErrorNotifier
   */
  public static function getInstance()
  {
    return self::$instance;
  }
  
  /**
   * 
   * @param fpErrorNotifier
   * 
   * @return fpErrorNotifier
   */
  public static function setInstance(fpErrorNotifier $notifier)
  {
    return self::$instance = $notifier;
  }
}
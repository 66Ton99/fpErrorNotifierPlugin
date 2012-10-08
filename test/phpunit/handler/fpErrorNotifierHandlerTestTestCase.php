<?php

/**
 *
 * @package    fpErrorNotifier
 * @subpackage test 
 * 
 * @author     Ton Sharp <Froma-PRO@66ton99.org.ua>
 */
class fpErrorNotifierHandlerTestTestCase extends sfBasePhpunitTestCase
{

  /**
   * @expectedException Exception
   * @expectedExceptionMessage an exception
   */
  public function testHandleException()
  {
    $handler = new fpErrorNotifierHandlerTest(new sfEventDispatcher, array());
    $handler->handleException(new Exception('an exception'));
  }

  protected function getHeandler()
  {
    sfConfig::set('sf_notify_handler', array('class' => 'fpErrorNotifierHandlerTest', 'options' => array()));
    $notifier = new fpErrorNotifier(new sfEventDispatcher());
    return $notifier->handler();
  }

  /**
   * @expectedException fpErrorNotifierException
   * @expectedExceptionMessage an exception
   */
  public function testHandleException_Full()
  {
    $this->getHeandler()->handleException(new fpErrorNotifierException('an exception'));
  }

  /**
   * @expectedException ErrorException
   * @expectedExceptionMessage an exception
   */
  public function testHandleError_Full()
  {
    $this->getHeandler()->handleError(0, 'an exception', 0, 0);
  }

  /**
   * @expectedException fpErrorNotifierException
   * @expectedExceptionMessage an exception
   */
  public function testHandleFatalError_Full()
  {
    $this->getHeandler()->handleEvent(new sfEvent('an exception', 'test'));
  }
}

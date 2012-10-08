<?php

/**
 * @author Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpErrorNotifierHandlerTest extends fpErrorNotifierHandler {

  /**
   * @param Exception $e
   */
  public function handleException(Exception $e)
  {
    throw $e;
  }
}

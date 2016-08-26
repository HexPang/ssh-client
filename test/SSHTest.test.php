<?php
use hexpang\Client\SSHClient\SSHClient;

class SSHTest extends \PHPUnit_Framework_TestCase {
  public function testInstance(){
    $service = new SSHClient(0,0,0,0);
    $this->assertInstanceOf("\hexpang\Client\SSHClient\SSHClient",$service);
  }
}

?>

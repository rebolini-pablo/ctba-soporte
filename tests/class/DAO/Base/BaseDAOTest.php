<?php

  class BaseDAOTest extends PHPUnit_Framework_TestCase {
    
    private $dao;
    
    private $mockPDO;
    
    public function setUp() {
      $this->mockPDO = $this->getMock('MockPDO', array('prepare', 'bindValue', 'execute', 'fetch')); 
      $this->dao = new BaseDAO($this->mockPDO);
    }
    
    public function testObjectWasCreated() {
      $this->assertTrue(
        isset($this->dao)
      );
    }
    
    public function testExecuteQueryAndRetrieveResults() {
      $this->mockPDO->expects($this->once())
        ->method('prepare')
        ->will($this->returnValue($this->mockPDO));
 
      $this->mockPDO->expects($this->once())
       ->method('prepare')
       ->with($this->equalTo('SELECT * FROM users WHERE id = :id'));    
        
      $this->mockPDO->expects($this->once())
        ->method('bindValue');    
    
      $this->mockPDO->expects($this->once())
        ->method('fetch')
        ->will($this->returnValue((object) array('id' => 1)));  
    
      $this->dao->query('SELECT * FROM users WHERE id = :id');
      $this->dao->bind(':id', 1);
      $this->dao->execute();
      
      $this->assertEquals(
        1, $this->dao->single()->id
      );
      
    }
  
  }

<?php

use calatoiu\CnpcuiRule\ValidCnpcui;
use PHPUnit\Framework\TestCase;

class ValidCnpcuiTest extends TestCase
{
    /**
     * Test a valid CNPCUI.
     * 
     * @return void
     */
    public function testValidCnpcui(): void
    {
        $cnpcuiValidator = new ValidCnpcui();
    
        $validCnpcui = '1670620131260';
    
        $validatorMock = $this->getMockBuilder('Illuminate\Validation\Validator')
            ->disableOriginalConstructor()
            ->getMock();
    
        $validatorMock->expects($this->never())
            ->method('errors');
    
        // Pass a Closure as the third argument to the validate method
        $cnpcuiValidator->validate('cnpcui', $validCnpcui, function () {
            // The validation should not fail, so this function should not be called.
            $this->fail('Validation failed for a valid CNPCUI.');
        });
    }

    /**
     * Test an invalid CNPCUI.
     * 
     * @return void
     */
    public function testInvalidCnpcui(): void
    {
        $cnpcuiValidator = new ValidCnpcui();
        
        $invalidCnpcui = 'ABCD12345667';
    
        $validatorMock = $this->getMockBuilder('Illuminate\Validation\Validator')
            ->disableOriginalConstructor()
            ->getMock();
    
        $validatorMock->expects($this->once())
            ->method('errors')
            ->willReturn('The :attribute is not a valid CNPCUI.');
    
        $cnpcuiValidator->setValidator($validatorMock);
        
        // Pass a Closure as the third argument to the validate method
        $cnpcuiValidator->validate('cnpcui', $invalidCnpcui, function ($message) {
            // The validation should fail, so this function should be called.
            $this->assertEquals('The :attribute is not a valid CNPCUI.', $message);
        });
    }

    /**
     * Test an CNPCUI with white space.
     * 
     * @return void
     */
    public function testCnpcuiWithWhiteSpace(): void
    {
        $cnpcuiValidator = new ValidCnpcui();
        
        $cnpcuiWithWhiteSpace = 'DE02 1005 0000 0024 2906 61';
    
        $validatorMock = $this->getMockBuilder('Illuminate\Validation\Validator')
            ->disableOriginalConstructor()
            ->getMock();
    
        $validatorMock->expects($this->once())
            ->method('errors')
            ->willReturn('The :attribute is not a valid CNPCUI.');
    
        $cnpcuiValidator->setValidator($validatorMock);
        
        // Pass a Closure as the third argument to the validate method
        $cnpcuiValidator->validate('cnpcui', $cnpcuiWithWhiteSpace, function ($message) {
            // The validation should fail, so this function should be called.
            $this->assertEquals('The :attribute is not a valid CNPCUI.', $message);
        });
    }

    /**
     * Test an CNPCUI with special characters.
     * 
     * @return void
     */
    public function testCnpcuiWithSpecialCharacters(): void
    {
        $cnpcuiValidator = new ValidCnpcui();
        
        $cnpcuiWithSpecialCharacters = 'DE02!1005 0000 0024 2906 61';
    
        $validatorMock = $this->getMockBuilder('Illuminate\Validation\Validator')
            ->disableOriginalConstructor()
            ->getMock();
    
        $validatorMock->expects($this->once())
            ->method('errors')
            ->willReturn('The :attribute is not a valid CNPCUI.');
    
        $cnpcuiValidator->setValidator($validatorMock);
        
        // Pass a Closure as the third argument to the validate method
        $cnpcuiValidator->validate('cnpcui', $cnpcuiWithSpecialCharacters, function ($message) {
            // The validation should fail, so this function should be called.
            $this->assertEquals('The :attribute is not a valid CNPCUI.', $message);
        });
    }
}

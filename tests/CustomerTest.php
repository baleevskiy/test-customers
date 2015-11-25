<?php
require('./question_2.php');

class CustomerTest extends PHPUnit_Framework_TestCase
{
    public function testId()
    {
        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('B123');
        $this->assertEquals(123, $customer->getId());
    }

    public function testThrowsInvalidArg(){
        $this->setExpectedException('SoftwareEngineerTest\InvalidArgument');
        SoftwareEngineerTest\Customer_Factory::get_instance('B1123z');
    }

    public function testUsernameLength(){
        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('B123');
        $this->assertEquals(\SoftwareEngineerTest\Customer::LENGTH_USERNAME, strlen($customer->generate_username()));
    }

    public function testBalance(){
        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('B123');
        $customer->deposit(100);
        $this->assertEquals($customer->get_balance(), 100);

        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('S123');
        $customer->deposit(100);
        $this->assertEquals($customer->get_balance(), 105);

        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('G123');
        $customer->deposit(100);
        $this->assertEquals($customer->get_balance(), 110);

        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('X123');
        $customer->deposit(100);
        $this->assertEquals($customer->get_balance(), 110);

        $customer = SoftwareEngineerTest\Customer_Factory::get_instance('X123');
        $customer->deposit(10000);
        $this->assertEquals($customer->get_balance(), 12000);
    }
}

<?php
namespace SoftwareEngineerTest;

// Question 2 & 3 & 4

/**
 * Class Customer
 */
/**
 * Class Customer
 * @package SoftwareEngineerTest
 */
abstract class Customer {
	const LENGTH_USERNAME = 30;
	const LENGTH_ID = 10;
	protected $id;
	protected $balance = 0;
	protected $_username;

	/**
	 * @param string $id
	 * @throws InvalidArgument
	 */
	public function __construct($id) {
		if(strlen($id) == 0 or strlen($id) >= self::LENGTH_ID or !is_numeric($id))
			throw new InvalidArgument('invalid Id' .$id);
		$this->id = $id;
		$this->_username = $this->generate_username();
	}

	public function get_balance() {
		return $this->balance;
	}

	public function deposit($amount) {
		$this->balance += $amount;
		$this->balance += $this->get_additional_commission($amount);
		return $this;
	}

	/**
	 * Generates 30 character random username with leading type-letter
	 *
	 * @return string
     */
	public function generate_username(){
		return $this->get_customer_letter().generate_random_string(self::LENGTH_USERNAME-1);
	}

	/**
	 * @param $amount
	 * @return float
     */
	abstract protected function get_additional_commission($amount);

	/**
	 * @return string Letter according to customers type
     */
	abstract protected function get_customer_letter();

	/**
	 * @return int|string
	 */
	public function getId()
	{
		return $this->id;
	}
}

class Bronze_Customer extends Customer{
	public function get_additional_commission($amount){
		return 0;
	}

	protected function get_customer_letter(){
		return Customer_Type::TYPE_BRONZE;
	}
}

class Silver_Customer extends Customer{
	public function get_additional_commission($amount){
		return $amount * 0.05;
	}

	protected function get_customer_letter(){
		return Customer_Type::TYPE_SILVER;
	}
}

class Gold_Customer extends Customer{
	public function get_additional_commission($amount){
		return $amount * 0.1;
	}

	protected function get_customer_letter(){
		return Customer_Type::TYPE_GOLD;
	}
}

class SuperGold_Customer extends Customer{
	public function get_additional_commission($amount){
		if($amount < 1000)
			return $amount * 0.1;
		return $amount * 0.2;
	}

	protected function get_customer_letter(){
		return 'X';
	}
}

/**
 * Class Customer_Type
 * @package SoftwareEngineerTest
 */
class Customer_Type{
	const TYPE_BRONZE = 'B';
	const TYPE_SILVER = 'S';
	const TYPE_GOLD = 'G';
	const TYPE_SUPERGOLD = 'X';

	protected static $_types = array(
		self::TYPE_BRONZE => 'Bronze',
		self::TYPE_SILVER => 'Silver',
		self::TYPE_GOLD => 'Gold',
		self::TYPE_SUPERGOLD => 'SuperGold',
	);

	public static function getTypes(){
		return self::$_types;
	}
}

class Customer_Factory{

	/**
	 * @param $id
	 * @return Customer
	 * @throws InvalidArgument
     */
	public static function get_instance($id){
		if(is_string($id) and isset(Customer_Type::getTypes()[$id[0]])){
			$className = __NAMESPACE__.'\\'.Customer_Type::getTypes()[$id[0]].'_Customer';
			return new $className(substr($id, 1));
		}
		throw new InvalidArgument('Invalid id');
	}
}

class InvalidArgument extends \Exception{}

function generate_random_string($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

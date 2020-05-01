<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class AddUserFeedbackCatalogsTest extends TestCase
{
    public static $SakkuService;
    private $token;
    public function setUp(): void
   {
        parent::setUp();
        # set serverType to SandBox or Production
        BaseInfo::initServerType(BaseInfo::SANDBOX_SERVER);
        $testData =  require __DIR__ . '/testData.php';
        $this->token = $testData['token'];

        $baseInfo = new BaseInfo();
        $baseInfo->setToken($this->token);
		self::$SakkuService = new SakkuService($baseInfo);
    }

	public function testAddUserFeedbackCatalogsAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'subject' => 'First feedback',
			'description' => 'This is first feedback',
			'type' => 'IMPROVEMENT',
			## ================= Optional Parameters  =================
			'catalogApp' => 97,
			// 'id' => '',
			// 'dockerName' => '',
			'price' => 100,
			'minCpu' => 2,
			'minMem' => 2,
			'minDisk' => 2,
			// 'created' => '',
			'checked' => true,
			'Authorization'     => $this->token, 
		];
		try {
			$result = $SakkuService->addUserFeedbackCatalogs($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddUserFeedbackCatalogsRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'subject' => 'First feedback',
			'description' => 'This is first feedback',
			'type' => 'IMPROVEMENT', 
		];
		try {
			$result = $SakkuService->addUserFeedbackCatalogs($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddUserFeedbackCatalogsValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'subject' => 123,
			'description' => 123,
			'type' => 123,
			## =============== Optional Parameters  ===============
			'catalogApp' => '123',
			'id' => '123',
			'dockerName' => 123,
			'price' => '123',
			'minCpu' => '123',
			'minMem' => '123',
			'minDisk' => '123',
			'created' => 123,
			'checked' => 123,
		];
		try {
			self::$SakkuService->addUserFeedbackCatalogs($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('subject', $validation);
			$this->assertEquals('The property subject is required', $validation['subject'][0]);

			$this->assertArrayHasKey('description', $validation);
			$this->assertEquals('The property description is required', $validation['description'][0]);

			$this->assertArrayHasKey('type', $validation);
			$this->assertEquals('The property type is required', $validation['type'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->addUserFeedbackCatalogs($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('subject', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['subject'][1]);

			$this->assertArrayHasKey('description', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['description'][1]);

			$this->assertArrayHasKey('type', $validation);
			$this->assertEquals('Does not have a value in the enumeration ["IMPROVEMENT","NEW_FUTURE","PROBLEM","OTHER"]', $validation['type'][1]);

			$this->assertArrayHasKey('catalogApp', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['catalogApp'][0]);

			$this->assertArrayHasKey('id', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['id'][0]);

			$this->assertArrayHasKey('dockerName', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['dockerName'][0]);

			$this->assertArrayHasKey('price', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['price'][0]);

			$this->assertArrayHasKey('minCpu', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['minCpu'][0]);

			$this->assertArrayHasKey('minMem', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['minMem'][0]);

			$this->assertArrayHasKey('minDisk', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['minDisk'][0]);

			$this->assertArrayHasKey('created', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['created'][0]);

			$this->assertArrayHasKey('checked', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['checked'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class UpdateHealthCheckByIdTest extends TestCase
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

	public function testUpdateHealthCheckByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'hid' => '',
			'endpoint' => '',
			'initialDelay' => '',
			'responseCode' => '',
			'responseString' => '',
			'scheme' => '',
			'checkRate' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->updateHealthCheckById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateHealthCheckByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'hid' => '',
			'endpoint' => '',
			'initialDelay' => '',
			'responseCode' => '',
			'responseString' => '',
			'scheme' => '',
			'checkRate' => '',
        ];
		try {
			$result = $SakkuService->updateHealthCheckById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateHealthCheckByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'hid' => '123',
			'checkRate' => '123',
			'endpoint' => 123,
			'initialDelay' => '123',
			'responseCode' => '123',
			'responseString' => 123,
			'scheme' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->updateHealthCheckById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('hid', $validation);
			$this->assertEquals('The property hid is required', $validation['hid'][0]);

			$this->assertArrayHasKey('checkRate', $validation);
			$this->assertEquals('The property checkRate is required', $validation['checkRate'][0]);

			$this->assertArrayHasKey('endpoint', $validation);
			$this->assertEquals('The property endpoint is required', $validation['endpoint'][0]);

			$this->assertArrayHasKey('initialDelay', $validation);
			$this->assertEquals('The property initialDelay is required', $validation['initialDelay'][0]);

			$this->assertArrayHasKey('responseCode', $validation);
			$this->assertEquals('The property responseCode is required', $validation['responseCode'][0]);

			$this->assertArrayHasKey('responseString', $validation);
			$this->assertEquals('The property responseString is required', $validation['responseString'][0]);

			$this->assertArrayHasKey('scheme', $validation);
			$this->assertEquals('The property scheme is required', $validation['scheme'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->updateHealthCheckById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('hid', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['hid'][1]);

			$this->assertArrayHasKey('checkRate', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['checkRate'][1]);

			$this->assertArrayHasKey('endpoint', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['endpoint'][1]);

			$this->assertArrayHasKey('initialDelay', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['initialDelay'][1]);

			$this->assertArrayHasKey('responseCode', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['responseCode'][1]);

			$this->assertArrayHasKey('responseString', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['responseString'][1]);

			$this->assertArrayHasKey('scheme', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['scheme'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
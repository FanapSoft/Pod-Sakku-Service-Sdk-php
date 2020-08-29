<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class StopAppByIdTest extends TestCase
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

	public function testStopAppByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 1234,
			## ================= Optional Parameters  =================
			'Authorization' => $this->token,,
			'commit' => true,
			'force' => true,
			'tag' => 'latest',
		];
		try {
			$result = $SakkuService->stopAppById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testStopAppByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 1234,
        ];
		try {
			$result = $SakkuService->stopAppById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testStopAppByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'commit' => 123,
			'force' => 123,
			'tag' => 123,
		];
		try {
			self::$SakkuService->stopAppById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->stopAppById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('commit', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['commit'][0]);

			$this->assertArrayHasKey('force', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['force'][0]);

			$this->assertArrayHasKey('tag', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['tag'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
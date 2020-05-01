<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class RestartAppByIdTest extends TestCase
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

	public function testRestartAppByIdAllParameters()
	{
		$params = [
            ## =============== *Required Parameters  ==================
            'appId'             => 2664,
            ## =============== Optional Parameters  ===================
    		'Authorization'     => $this->token,
            'commitStart'       => true,
            'commitStop'        => true,
            'tagStart'          => '',
            'tagStop'           => '',
        ];
		try {
			$result = $SakkuService->restartAppById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testRestartAppByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 2664,
        ];
		try {
			$result = $SakkuService->restartAppById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testRestartAppByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'commitStart' => 123,
			'commitStop' => 123,
			'tagStart' => 123,
			'tagStop' => 123,
		];
		try {
			self::$SakkuService->restartAppById($paramsWithoutRequired);
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
			self::$SakkuService->restartAppById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('commitStart', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['commitStart'][0]);

			$this->assertArrayHasKey('commitStop', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['commitStop'][0]);

			$this->assertArrayHasKey('tagStart', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['tagStart'][0]);

			$this->assertArrayHasKey('tagStop', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['tagStop'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class AddBasicAuthUsersTest extends TestCase
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

	public function testAddBasicAuthUsersAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 2664,
			'basicAuthentication' => [
				[
					'username' => uniqid('testUser_'),
					'password' => uniqid(),
				]
			],
			## ================= Optional Parameters  =================
			'Authorization'     => $this->token,
		 ];
		try {
			$result = $SakkuService->addBasicAuthUsers($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddBasicAuthUsersRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 2664,
			'basicAuthentication' => [
				[
					'username' => uniqid('testUser_'),
					'password' => uniqid(),
				]
			],
        ];
		try {
			$result = $SakkuService->addBasicAuthUsers($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddBasicAuthUsersValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'basicAuthentication' => '123',
			## =============== Optional Parameters  ===============
		];
		try {
			self::$SakkuService->addBasicAuthUsers($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('basicAuthentication', $validation);
			$this->assertEquals('The property basicAuthentication is required', $validation['basicAuthentication'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->addBasicAuthUsers($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('basicAuthentication', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['basicAuthentication'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
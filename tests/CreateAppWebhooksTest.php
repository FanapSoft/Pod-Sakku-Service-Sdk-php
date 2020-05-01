<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreateAppWebhooksTest extends TestCase
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

	public function testCreateAppWebhooksAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'applicationId' => '',
			'url' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'secured' => '',
			'topics' => '',
		];
		try {
			$result = $SakkuService->createAppWebhooks($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppWebhooksRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'applicationId' => '',
			'url' => '',
        ];
		try {
			$result = $SakkuService->createAppWebhooks($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppWebhooksValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'applicationId' => '123',
			'url' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'secured' => 123,
			'topics' => 123,
		];
		try {
			self::$SakkuService->createAppWebhooks($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('applicationId', $validation);
			$this->assertEquals('The property applicationId is required', $validation['applicationId'][0]);

			$this->assertArrayHasKey('url', $validation);
			$this->assertEquals('The property url is required', $validation['url'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createAppWebhooks($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('applicationId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['applicationId'][1]);

			$this->assertArrayHasKey('secured', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['secured'][0]);

			$this->assertArrayHasKey('topics', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['topics'][0]);

			$this->assertArrayHasKey('url', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['url'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
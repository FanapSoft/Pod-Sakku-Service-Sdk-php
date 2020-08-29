<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class LogsExportTest extends TestCase
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

	public function testLogsExportAllParameters()
	{
		$params = [
			## ====================== *Required Parameters  =========================
            'appId'             => 2804,
            ## ====================== Optional Parameters  ==========================
            // 'fromDate'          => '2020-02-01',
            // 'toDate'            => '2020-04-31',
            'saveTo'            => 'C:\Documents\logs2804_1.txt',
			'Authorization' => $this->token,,
		];
		try {
			$result = $SakkuService->logsExport($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testLogsExportRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 1234,
        ];
		try {
			$result = $SakkuService->logsExport($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testLogsExportValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'token' => 123,
			'appId' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'fromDate' => '123',
			'toDate' => '123',
			'saveTo' => 123,
		];
		try {
			self::$SakkuService->logsExport($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('token', $validation);
			$this->assertEquals('The property token is required', $validation['token'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->logsExport($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('token', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['token'][1]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('fromDate', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['fromDate'][0]);

			$this->assertArrayHasKey('toDate', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['toDate'][0]);

			$this->assertArrayHasKey('saveTo', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['saveTo'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class DeployAppFromCatalogTest extends TestCase
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

	public function testDeployAppFromCatalogAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'settings' => [
				"name" => "newapp",
				"mem" => 1,
				"cpu" => 1,
				"disk" => 2,
				"metadata" => [
					[
						'name'=> 'memory_limit',
						'scope' => 'ENV',
						"value" => "latest"
					]
				]
			],
			'catalogAppId' => 97,
			## ================= Optional Parameters  =================
			'files' => [
				'C:\Users\ASUS\Documents\Elham\SourcesdocTableData.txt',
				'C:\Users\ASUS\Documents\Elham\test.txt',
			],
			'Authorization'     => $this->token, 
		];
		try {
			$result = $SakkuService->deployAppFromCatalog($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeployAppFromCatalogRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'settings' => [
				"name" => "newapp",
				"mem" => 1,
				"cpu" => 1,
				"disk" => 2,
				"metadata" => [
					[
						'name'=> 'memory_limit',
						'scope' => 'ENV',
						"value" => "latest"
					]
				]
			],
			'catalogAppId' => 97,
		];
		try {
			$result = $SakkuService->deployAppFromCatalog($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeployAppFromCatalogValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'catalogAppId' => '123',
			'settings' => '123',
			## =============== Optional Parameters  ===============
			'files' => '123',
		];
		try {
			self::$SakkuService->deployAppFromCatalog($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('catalogAppId', $validation);
			$this->assertEquals('The property catalogAppId is required', $validation['catalogAppId'][0]);

			$this->assertArrayHasKey('settings', $validation);
			$this->assertEquals('The property settings is required', $validation['settings'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->deployAppFromCatalog($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('catalogAppId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['catalogAppId'][1]);

			$this->assertArrayHasKey('settings', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['settings'][1]);

			$this->assertArrayHasKey('files', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['files'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
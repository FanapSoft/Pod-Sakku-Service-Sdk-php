<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreateCatalogAppBySakkuAppTest extends TestCase
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

	public function testCreateCatalogAppBySakkuAppAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'catalogId' => 11,
			'appId' => 2664,
			'catalogAppConfig' => [
				"avatar" => "string",
				"deployLimitCount" => 1,
				"description" => "create CatalogTest1",
				"name" => "CatalogTest1",
				"price" => 9,
				"catalogConfigs" => [
					[
					  "appName" => "catalogTest",
					  "dockerFileText" => "string",
					  // "metadata" => [
						//     [
						//       "advanced" => true,
						//       "defaultValue" => "metadataTest",
						//       "forced" => true,
						//       "inputType" => "VALUES",
						//       "name" => "metadataTest",
						//       "scope" => "APP",
						//       "values" => [
						//         "string"
						//       ]
						//     ]
						// ],
					  // ],
					  "minCpu" => 1,
					  "minDisk" => 1,
					  "minMem" => 1
					]
				  ],
			],
			## ================= Optional Parameters  =================
			'Authorization'     => $this->token, 
		];
		try {
			$result = $SakkuService->createCatalogAppBySakkuApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateCatalogAppBySakkuAppRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'catalogId' => 11,
			'appId' => 2664,
			'catalogAppConfig' => [
				"avatar" => "string",
				"deployLimitCount" => 1,
				"description" => "create CatalogTest1",
				"name" => "CatalogTest1",
				"price" => 9,
				"catalogConfigs" => [
					[
					  "appName" => "catalogTest",
					  "dockerFileText" => "string",
					  // "metadata" => [
						//     [
						//       "advanced" => true,
						//       "defaultValue" => "metadataTest",
						//       "forced" => true,
						//       "inputType" => "VALUES",
						//       "name" => "metadataTest",
						//       "scope" => "APP",
						//       "values" => [
						//         "string"
						//       ]
						//     ]
						// ],
					  // ],
					  "minCpu" => 1,
					  "minDisk" => 1,
					  "minMem" => 1
					]
				  ],
			],
		];
		try {
			$result = $SakkuService->createCatalogAppBySakkuApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateCatalogAppBySakkuAppValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'catalogId' => '123',
			'appId' => '123',
			'catalogAppConfig' => '123',
			## =============== Optional Parameters  ===============
		];
		try {
			self::$SakkuService->createCatalogAppBySakkuApp($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('catalogId', $validation);
			$this->assertEquals('The property catalogId is required', $validation['catalogId'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('catalogAppConfig', $validation);
			$this->assertEquals('The property catalogAppConfig is required', $validation['catalogAppConfig'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createCatalogAppBySakkuApp($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('catalogId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['catalogId'][1]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('catalogAppConfig', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['catalogAppConfig'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
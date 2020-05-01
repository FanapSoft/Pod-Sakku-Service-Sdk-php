<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreateCatalogAppTest extends TestCase
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

	public function testCreateCatalogAppAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'catalogId' => 11,
			'catalogAppConfig' => [
				"avatar" => "string",
				"catalogConfigs" => [
				  [
					"appName" => "catalogTest",
					'config'  => [
						"name" => "PHPTest3",
						"mem" => 0.1,
						"cpu" => 0.1,
						"disk" => 0.1,
						// "ports" => [
						//     [
						//         "port" => 80,
						//         "protocol" => "HTTP",
						//         "ssl" => False,
						//         "onlyInternal" => False,
						//         "basicAuthentication" => False,
						//         "forceRedirectHttps" => False
						//     ]
						// ],
						// "cmd" => '',
						// "entrypoint" => '',
						// "scalingMode" => 'OFF',
						// "args" => [],
						"modules" => [
							[
								"code" => 50,
								"appId" => 0,
								"metadata" => [
									"appPath" => "/usr/share/nginx/html",
									"ftp" => False
								]
							]
						],
						// "environments" => [],
						// "labels" => [],
						// "netAlias" => '',
						// "basicAuthentications" => [],
						// "portOptions" => null,
						"image" => [
							"name" => "nginx:latest",
							"registry" => "dockerhub",
							"accessToken" => "",
							"username" => ""
						],
						"deployType" => 'DOCKER_IMAGE',
						"minInstance" => 1,
						"maxInstance" => 1,
						// "network" => '',
						// "dependsOn" => []
					],
					"dockerFileText" => "string",
					// "metadata" => [
					//   [
					//     "advanced" => true,
					//     "defaultValue" => "metadataTest",
					//     "description" => "metadataTest",
					//     "displayName" => "metadataTest",
					//     "forced" => true,
					//     "inputType" => "VALUES",
					//     "name" => "metadataTest",
					//     "scope" => "APP",
					//     "values" => [
					//       "string"
					//     ]
					//   ]
					// ],
					"minCpu" => 1,
					"minDisk" => 1,
					"minMem" => 1
				  ]
				],
				"deployLimitCount" => 1,
				"description" => "create CatalogTest1",
				"name" => "CatalogTest1",
				"price" => 9
			],
			## ================= Optional Parameters  =================
			'Authorization'     => $this->token, 
		];
		try {
			$result = $SakkuService->createCatalogApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateCatalogAppRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'catalogId' => 11,
			'catalogAppConfig' => [
				"avatar" => "string",
				"catalogConfigs" => [
				  [
					"appName" => "catalogTest",
					'config'  => [
						"name" => "PHPTest3",
						"mem" => 0.1,
						"cpu" => 0.1,
						"disk" => 0.1,
						// "ports" => [
						//     [
						//         "port" => 80,
						//         "protocol" => "HTTP",
						//         "ssl" => False,
						//         "onlyInternal" => False,
						//         "basicAuthentication" => False,
						//         "forceRedirectHttps" => False
						//     ]
						// ],
						// "cmd" => '',
						// "entrypoint" => '',
						// "scalingMode" => 'OFF',
						// "args" => [],
						"modules" => [
							[
								"code" => 50,
								"appId" => 0,
								"metadata" => [
									"appPath" => "/usr/share/nginx/html",
									"ftp" => False
								]
							]
						],
						// "environments" => [],
						// "labels" => [],
						// "netAlias" => '',
						// "basicAuthentications" => [],
						// "portOptions" => null,
						"image" => [
							"name" => "nginx:latest",
							"registry" => "dockerhub",
							"accessToken" => "",
							"username" => ""
						],
						"deployType" => 'DOCKER_IMAGE',
						"minInstance" => 1,
						"maxInstance" => 1,
						// "network" => '',
						// "dependsOn" => []
					],
					"dockerFileText" => "string",
					// "metadata" => [
					//   [
					//     "advanced" => true,
					//     "defaultValue" => "metadataTest",
					//     "description" => "metadataTest",
					//     "displayName" => "metadataTest",
					//     "forced" => true,
					//     "inputType" => "VALUES",
					//     "name" => "metadataTest",
					//     "scope" => "APP",
					//     "values" => [
					//       "string"
					//     ]
					//   ]
					// ],
					"minCpu" => 1,
					"minDisk" => 1,
					"minMem" => 1
				  ]
				],
				"deployLimitCount" => 1,
				"description" => "create CatalogTest1",
				"name" => "CatalogTest1",
				"price" => 9
			],
			## ================= Optional Parameters  =================
			'Authorization'     => $this->token, 
		];
		try {
			$result = $SakkuService->createCatalogApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateCatalogAppValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'catalogId' => '123',
			'catalogAppConfig' => '123',
			## =============== Optional Parameters  ===============
		];
		try {
			self::$SakkuService->createCatalogApp($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('catalogId', $validation);
			$this->assertEquals('The property catalogId is required', $validation['catalogId'][0]);

			$this->assertArrayHasKey('catalogAppConfig', $validation);
			$this->assertEquals('The property catalogAppConfig is required', $validation['catalogAppConfig'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createCatalogApp($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('catalogId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['catalogId'][1]);

			$this->assertArrayHasKey('catalogAppConfig', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['catalogAppConfig'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
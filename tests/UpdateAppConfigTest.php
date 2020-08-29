<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class UpdateAppConfigTest extends TestCase
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

	public function testUpdateAppConfigAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 1234,
			'config'  => [
                "app" => [
                    "appFile" => [
                      "absolute" => true,
                      "absolutePath" => "string",
                      "canonicalPath" => "string",
                      "directory" => true,
                      "executable" => true,
                      "file" => true,
                      "freeSpace" => 0,
                      "hidden" => true,
                      "lastModified" => 0,
                      "name" => "string",
                      "parent" => "string",
                      "path" => "string",
                      "readable" => true,
                      "totalSpace" => 0,
                      "usableSpace" => 0,
                      "writable" => true
                    ],
                    "fileHash" => "string",
                    "imageName" => "string",
                    "type" => "JAR"
                  ],
                "args" => [
                    "string"
                    ],
                "basicAuthentications" => [
                    [
                        "password" => "string",
                        "username" => "string"
                    ]
                ],
                "cmd" => "string",
                "cpu" => 0,
                "dependsOn" => [
                    "string"
                ],
                "deployType" => "APP",
                "disk" => 0,
                "entrypoint" => "string",
                "environments" => [
                    "additionalProp1" => "string",
                    "additionalProp2" => "string",
                    "additionalProp3" => "string"
                ],
                "git" => [
                    "accessToken" => "string",
                    "buildArgs" => [
                      "string"
                    ],
                    "docker_file" => "string",
                    "image_name" => "string",
                    "url" => "string",
                    "urlBranch" => "string",
                    "username" => "string"
                ],
                "healthChecks" => [
                    [
                      "checkRate" => 0,
                      "endpoint" => "/ping",
                      "initialDelay" => 0,
                      "responseCode" => 0,
                      "responseString" => "string",
                      "scheme" => "http"
                    ]
                ],
                "image" => [
                    "accessToken" => "string",
                    "name" => "string",
                    "registry" => "string",
                    "username" => "string"
                ],
                "labels" => [
                    "additionalProp1" => "string",
                    "additionalProp2" => "string",
                    "additionalProp3" => "string"
                ],
                "links" => [
                    [
                      "alias" => "string",
                      "name" => "string"
                    ]
                ],
                "maxInstance" => 0,
                "mem" => 0,
                "minInstance" => 0,
                "modules" => [
                    [
                      "appId" => 0,
                      "code" => 0,
                      "metadata" => [
                        "additionalProp1" => "string",
                        "additionalProp2" => "string",
                        "additionalProp3" => "string"
                      ]
                    ]
                ],
                "name" => "string",
                "netAlias" => "string",
                "network" => "string",
                "pipeLineStatus" => "RUNNING",
                "portOptions" => [
                    [
                      "name" => "string",
                      "value" => "string"
                    ]
                ],
                "ports" => [
                    [
                      "basicAuthentication" => true,
                      "forceRedirectHttps" => true,
                      "host" => 0,
                      "onlyInternal" => true,
                      "port" => 0,
                      "protocol" => "http",
                      "ssl" => true
                    ]
                ],
                "scalingMode" => "OFF",
                "worker" => "string"
            ],
			## ================= Optional Parameters  =================
			'Authorization' => $this->token,,
		];
		try {
			$result = $SakkuService->updateAppConfig($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateAppConfigRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => 1234,
			'config'  => [
                "app" => [
                    "appFile" => [
                      "absolute" => true,
                      "absolutePath" => "string",
                      "canonicalPath" => "string",
                      "directory" => true,
                      "executable" => true,
                      "file" => true,
                      "freeSpace" => 0,
                      "hidden" => true,
                      "lastModified" => 0,
                      "name" => "string",
                      "parent" => "string",
                      "path" => "string",
                      "readable" => true,
                      "totalSpace" => 0,
                      "usableSpace" => 0,
                      "writable" => true
                    ],
                    "fileHash" => "string",
                    "imageName" => "string",
                    "type" => "JAR"
                  ],
                "args" => [
                    "string"
                    ],
                "basicAuthentications" => [
                    [
                        "password" => "string",
                        "username" => "string"
                    ]
                ],
                "cmd" => "string",
                "cpu" => 0,
                "dependsOn" => [
                    "string"
                ],
                "deployType" => "APP",
                "disk" => 0,
                "entrypoint" => "string",
                "environments" => [
                    "additionalProp1" => "string",
                    "additionalProp2" => "string",
                    "additionalProp3" => "string"
                ],
                "git" => [
                    "accessToken" => "string",
                    "buildArgs" => [
                      "string"
                    ],
                    "docker_file" => "string",
                    "image_name" => "string",
                    "url" => "string",
                    "urlBranch" => "string",
                    "username" => "string"
                ],
                "healthChecks" => [
                    [
                      "checkRate" => 0,
                      "endpoint" => "/ping",
                      "initialDelay" => 0,
                      "responseCode" => 0,
                      "responseString" => "string",
                      "scheme" => "http"
                    ]
                ],
                "image" => [
                    "accessToken" => "string",
                    "name" => "string",
                    "registry" => "string",
                    "username" => "string"
                ],
                "labels" => [
                    "additionalProp1" => "string",
                    "additionalProp2" => "string",
                    "additionalProp3" => "string"
                ],
                "links" => [
                    [
                      "alias" => "string",
                      "name" => "string"
                    ]
                ],
                "maxInstance" => 0,
                "mem" => 0,
                "minInstance" => 0,
                "modules" => [
                    [
                      "appId" => 0,
                      "code" => 0,
                      "metadata" => [
                        "additionalProp1" => "string",
                        "additionalProp2" => "string",
                        "additionalProp3" => "string"
                      ]
                    ]
                ],
                "name" => "string",
                "netAlias" => "string",
                "network" => "string",
                "pipeLineStatus" => "RUNNING",
                "portOptions" => [
                    [
                      "name" => "string",
                      "value" => "string"
                    ]
                ],
                "ports" => [
                    [
                      "basicAuthentication" => true,
                      "forceRedirectHttps" => true,
                      "host" => 0,
                      "onlyInternal" => true,
                      "port" => 0,
                      "protocol" => "http",
                      "ssl" => true
                    ]
                ],
                "scalingMode" => "OFF",
                "worker" => "string"
            ],
        ];
		try {
			$result = $SakkuService->updateAppConfig($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateAppConfigValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'config' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->updateAppConfig($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('config', $validation);
			$this->assertEquals('The property config is required', $validation['config'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->updateAppConfig($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('config', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['config'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreateAppByStateMachineTest extends TestCase
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

	public function testCreateAppByStateMachineAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'config'             => [
                "name" => "MachineMechanismPHP",
                    "mem" => 0.1,
                    "cpu" => 0.1,
                    "disk" => 0.1,
                    "ports" => [
                        [
                            "port" => 80,
                            "protocol" => "HTTP",
                            "ssl" => False,
                            "onlyInternal" => False,
                            "basicAuthentication" => False,
                            "forceRedirectHttps" => False
                        ]
                    ],
                    // "cmd" => '',
                    // "entrypoint" => '',
                    "scalingMode" => "OFF",
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
                    "deployType" => "DOCKER_IMAGE",
                    "minInstance" => 1,
                    "maxInstance" => 1,
                    // "network" => '',
                    // "dependsOn" => []
                ],
			## ================= Optional Parameters  =================
			'Authorization' => $this->token,
		];
		try {
			$result = $SakkuService->createAppByStateMachine($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppByStateMachineRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'config'             => [
                "name" => "MachineMechanismPHP",
                    "mem" => 0.1,
                    "cpu" => 0.1,
                    "disk" => 0.1,
                    "ports" => [
                        [
                            "port" => 80,
                            "protocol" => "HTTP",
                            "ssl" => False,
                            "onlyInternal" => False,
                            "basicAuthentication" => False,
                            "forceRedirectHttps" => False
                        ]
                    ],
                    // "cmd" => '',
                    // "entrypoint" => '',
                    "scalingMode" => "OFF",
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
                    "deployType" => "DOCKER_IMAGE",
                    "minInstance" => 1,
                    "maxInstance" => 1,
                    // "network" => '',
                    // "dependsOn" => []
			],
        ];
		try {
			$result = $SakkuService->createAppByStateMachine($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppByStateMachineValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'config' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->createAppByStateMachine($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('config', $validation);
			$this->assertEquals('The property config is required', $validation['config'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createAppByStateMachine($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('config', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['config'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
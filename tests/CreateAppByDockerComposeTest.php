<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreateAppByDockerComposeTest extends TestCase
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

	public function testCreateAppByDockerComposeAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'composeFile'     => 'docker-compose.yml',
            'globalConfig'     => '{"name":"PHPTestDockerCompose","mem":0.1,"cpu":0.1,"disk":0.1,"ports":[{"port":80,"protocol":"HTTP","ssl":False,"onlyInternal":False,"basicAuthentication":False,"forceRedirectHttps":False}],"cmd":"","entrypoint":null,"scalingMode":"OFF","args":[],"modules":[{"code":50,"appId":0,"metadata":{"appPath":"/usr/share/nginx/html","ftp":False}}],"environments":{},"labels":{},"netAlias":null,"basicAuthentications":[],"portOptions":null,"image":{"name":"nginx:latest","registry":"dockerhub","accessToken":"","username":""}',
			## ================= Optional Parameters  =================
			'Authorization' => $this->token,
		];
		try {
			$result = $SakkuService->createAppByDockerCompose($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppByDockerComposeRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'composeFile'     => 'docker-compose.yml',
            'globalConfig'     => '{"name":"PHPTestDockerCompose","mem":0.1,"cpu":0.1,"disk":0.1,"ports":[{"port":80,"protocol":"HTTP","ssl":False,"onlyInternal":False,"basicAuthentication":False,"forceRedirectHttps":False}],"cmd":"","entrypoint":null,"scalingMode":"OFF","args":[],"modules":[{"code":50,"appId":0,"metadata":{"appPath":"/usr/share/nginx/html","ftp":False}}],"environments":{},"labels":{},"netAlias":null,"basicAuthentications":[],"portOptions":null,"image":{"name":"nginx:latest","registry":"dockerhub","accessToken":"","username":""}',
        ];
		try {
			$result = $SakkuService->createAppByDockerCompose($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppByDockerComposeValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'composeFile' => 123,
			'globalConfig' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->createAppByDockerCompose($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('composeFile', $validation);
			$this->assertEquals('The property composeFile is required', $validation['composeFile'][0]);

			$this->assertArrayHasKey('globalConfig', $validation);
			$this->assertEquals('The property globalConfig is required', $validation['globalConfig'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createAppByDockerCompose($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('composeFile', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['composeFile'][1]);

			$this->assertArrayHasKey('globalConfig', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['globalConfig'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
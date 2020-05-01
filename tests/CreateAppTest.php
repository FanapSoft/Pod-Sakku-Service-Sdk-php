<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreateAppTest extends TestCase
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

	public function testCreateAppAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'deployType' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'args' => '',
			'basicAuthentications' => '',
			'cmd' => '',
			'cpu' => '',
			'dependsOn' => '',
			'disk' => '',
			'entrypoint' => '',
			'environments' => '',
			'git' => '',
			'healthChecks' => '',
			'image' => '',
			'labels' => '',
			'links' => '',
			'maxInstance' => '',
			'mem' => '',
			'minInstance' => '',
			'modules' => '',
			'name' => '',
			'netAlias' => '',
			'network' => '',
			'pipeLineStatus' => '',
			'ports' => '',
			'scalingMode' => '',
			'worker' => '',
		];
		try {
			$result = $SakkuService->createApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'deployType' => '',
        ];
		try {
			$result = $SakkuService->createApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'deployType' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'args' => '123',
			'basicAuthentications' => '123',
			'cmd' => 123,
			'cpu' => '123',
			'dependsOn' => '123',
			'disk' => '123',
			'entrypoint' => 123,
			'environments' => '123',
			'git' => '123',
			'healthChecks' => '123',
			'image' => '123',
			'labels' => '123',
			'links' => '123',
			'maxInstance' => '123',
			'mem' => '123',
			'minInstance' => '123',
			'modules' => '123',
			'name' => 123,
			'netAlias' => 123,
			'network' => 123,
			'pipeLineStatus' => 123,
			'ports' => '123',
			'scalingMode' => 123,
			'worker' => 123,
		];
		try {
			self::$SakkuService->createApp($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('deployType', $validation);
			$this->assertEquals('The property deployType is required', $validation['deployType'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createApp($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('args', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['args'][0]);

			$this->assertArrayHasKey('basicAuthentications', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['basicAuthentications'][0]);

			$this->assertArrayHasKey('cmd', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['cmd'][0]);

			$this->assertArrayHasKey('cpu', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['cpu'][0]);

			$this->assertArrayHasKey('dependsOn', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['dependsOn'][0]);

			$this->assertArrayHasKey('deployType', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['deployType'][1]);

			$this->assertArrayHasKey('disk', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['disk'][0]);

			$this->assertArrayHasKey('entrypoint', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['entrypoint'][0]);

			$this->assertArrayHasKey('environments', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['environments'][0]);

			$this->assertArrayHasKey('git', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['git'][0]);

			$this->assertArrayHasKey('healthChecks', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['healthChecks'][0]);

			$this->assertArrayHasKey('image', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['image'][0]);

			$this->assertArrayHasKey('labels', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['labels'][0]);

			$this->assertArrayHasKey('links', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['links'][0]);

			$this->assertArrayHasKey('maxInstance', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['maxInstance'][0]);

			$this->assertArrayHasKey('mem', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['mem'][0]);

			$this->assertArrayHasKey('minInstance', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['minInstance'][0]);

			$this->assertArrayHasKey('modules', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['modules'][0]);

			$this->assertArrayHasKey('name', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['name'][0]);

			$this->assertArrayHasKey('netAlias', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['netAlias'][0]);

			$this->assertArrayHasKey('network', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['network'][0]);

			$this->assertArrayHasKey('pipeLineStatus', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['pipeLineStatus'][0]);

			$this->assertArrayHasKey('ports', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['ports'][0]);

			$this->assertArrayHasKey('scalingMode', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['scalingMode'][0]);

			$this->assertArrayHasKey('worker', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['worker'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
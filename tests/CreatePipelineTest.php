<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class CreatePipelineTest extends TestCase
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

	public function testCreatePipelineAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'configs' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->createPipeline($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreatePipelineRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'configs' => '',
        ];
		try {
			$result = $SakkuService->createPipeline($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreatePipelineValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'configs' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->createPipeline($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('configs', $validation);
			$this->assertEquals('The property configs is required', $validation['configs'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->createPipeline($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('configs', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['configs'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class AddDomainRecordTest extends TestCase
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

	public function testAddDomainRecordAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'domain' => '',
			'recordConfig' => '',
			## ================= Optional Parameters  =================
		];
		try {
			$result = $SakkuService->addDomainRecord($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddDomainRecordRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'domain' => '',
			'recordConfig' => '',
        ];
		try {
			$result = $SakkuService->addDomainRecord($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddDomainRecordValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'domain' => 123,
			'recordConfig' => '123',
			## =============== Optional Parameters  ===============
		];
		try {
			self::$SakkuService->addDomainRecord($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('domain', $validation);
			$this->assertEquals('The property domain is required', $validation['domain'][0]);

			$this->assertArrayHasKey('recordConfig', $validation);
			$this->assertEquals('The property recordConfig is required', $validation['recordConfig'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->addDomainRecord($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('domain', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['domain'][1]);

			$this->assertArrayHasKey('recordConfig', $validation);
			$this->assertEquals('String value found, but an array is required', $validation['recordConfig'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
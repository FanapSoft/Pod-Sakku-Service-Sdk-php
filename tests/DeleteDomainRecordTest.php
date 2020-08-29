<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class DeleteDomainRecordTest extends TestCase
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

	public function testDeleteDomainRecordAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'domain' => 'mydomain.ir',
			'name' => 'r2',
			'type' => 'SOA',
			## ================= Optional Parameters  =================
		];
		try {
			$result = $SakkuService->deleteDomainRecord($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteDomainRecordRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'domain' => 'mydomain.ir',
			'name' => 'r2',
			'type' => 'SOA',
        ];
		try {
			$result = $SakkuService->deleteDomainRecord($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteDomainRecordValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'domain' => 123,
			'name' => 123,
			'type' => 123,
			## =============== Optional Parameters  ===============
		];
		try {
			self::$SakkuService->deleteDomainRecord($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('domain', $validation);
			$this->assertEquals('The property domain is required', $validation['domain'][0]);

			$this->assertArrayHasKey('name', $validation);
			$this->assertEquals('The property name is required', $validation['name'][0]);

			$this->assertArrayHasKey('type', $validation);
			$this->assertEquals('The property type is required', $validation['type'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->deleteDomainRecord($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('domain', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['domain'][1]);

			$this->assertArrayHasKey('name', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['name'][1]);

			$this->assertArrayHasKey('type', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['type'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
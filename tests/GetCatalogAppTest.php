<?php
use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class GetCatalogAppTest extends TestCase
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

	public function testGetCatalogAppAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'catalogId' => 11,
			'catalogAppId' => 97,
			## ================= Optional Parameters  =================
			'Authorization'     => $this->token, 
		];
		try {
			$result = $SakkuService->getCatalogApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetCatalogAppRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'catalogId' => 11,
			'catalogAppId' => 97, 
		];
		try {
			$result = $SakkuService->getCatalogApp($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetCatalogAppValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'catalogId' => '123',
			'catalogAppId' => '123',
			## =============== Optional Parameters  ===============
		];
		try {
			self::$SakkuService->getCatalogApp($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('catalogId', $validation);
			$this->assertEquals('The property catalogId is required', $validation['catalogId'][0]);

			$this->assertArrayHasKey('catalogAppId', $validation);
			$this->assertEquals('The property catalogAppId is required', $validation['catalogAppId'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->getCatalogApp($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('catalogId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['catalogId'][1]);

			$this->assertArrayHasKey('catalogAppId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['catalogAppId'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
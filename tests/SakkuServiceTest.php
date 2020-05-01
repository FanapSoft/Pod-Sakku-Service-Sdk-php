<?php

use PHPUnit\Framework\TestCase;
use Pod\Sakku\Service\SakkuService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class SakkuServiceTest extends TestCase
{
//    public static $Authorization;
    public static $sakkuService;
    private $token;
    public function setUp(): void
    {
        parent::setUp();
        # set serverType to SandBox or Production
        BaseInfo::initServerType(BaseInfo::SANDBOX_SERVER);
        $sakkuTestData =  require __DIR__ . '/sakkuTestData.php';
        $this->token = $sakkuTestData['Authorization'];
       
        $baseInfo = new BaseInfo();
        $baseInfo->setToken($this->token);

        self::$sakkuService = new SakkuService($baseInfo);
    }

    public function testGetUserAppListAllParameters()
    {
        $params =
        [
        ## =============== *Required Parameters  ===============
            'page'                 => 1,
        ## =============== Optional Parameters  ===============
            'Authorization'     => $this->token,
            'size'                 => 1
        ];

        try {
            $result = self::$sakkuService->getUserAppList($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetUserAppListRequiredParameters()
    {
        $params =
            [
            ## =============== *Required Parameters  ===============
            'page'                 => 1,
            ];
        try {
            $result = self::$sakkuService->getUserAppList($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetUserAppListValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
           ## =============== *Required Parameters  ===============
            'page'                 => '1',
           ## =============== Optional Parameters  ===============
            'Authorization'        => 12,
            'size'                 => '1'
        ];
        try {
            self::$sakkuService->getUserAppList($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('page', $validation);
            $this->assertEquals('The property page is required', $validation['page'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getUserAppList($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('page', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['page'][1]);

            $this->assertArrayHasKey('size', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['size'][0]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCreateAppAllParameters()
    {
        $params =
        [
        ## ========================= *Required Parameters  =========================
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
            
        ## ========================= Optional Parameters  ===========================
        'Authorization'     => $this->token,
    ];

        try {
            $result = self::$sakkuService->createApp($params);
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
        $params =
        [
        ## ========================= *Required Parameters  =========================
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
            $result = self::$sakkuService->createApp($params);
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
            'config'             => 1234,
        ];
        try {
            self::$sakkuService->createApp($paramsWithoutRequired);
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
            self::$sakkuService->createApp($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('config', $validation);
            $this->assertEquals('Integer value found, but an array is required', $validation['config'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDeleteAppByIdAllParameters()
    {
        $params =
        [
            ## ==================== *Required Parameters  ====================
            'appId'             => 2332,
            ## ==================== Optional Parameters  =====================
            'Authorization'     =>$this->Authorization,
            'force'             => false,                 
    ];

        try {
            $result = self::$sakkuService->deleteAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDeleteAppByIdRequiredParameters()
    {
        $params =
            [
            ## ==================== *Required Parameters  ====================
            'appId'             => 2332,
            ];
        try {
            $result = self::$sakkuService->deleteAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . 'code: '.$error['code'] . ';;' . $error['message']);
        }
    }

    public function testDeleteAppByIdValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'appId'             => '2332',
            'Authorization'     => 123,
            'force'             => 123,  
        ];
        try {
            self::$sakkuService->deleteAppById($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->deleteAppById($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

            $this->assertArrayHasKey('force', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['force'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCommitAppContainerAllParameters()
    {
        $params =
        [
            ## ======================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ========================= Optional Parameters  =========================
            'Authorization'     => $this->Authorization,
            'containerId'       => 9,
            'tag'               => 'unitTest',
    ];

        try {
            $result = self::$sakkuService->commitAppContainer($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCommitAppContainerRequiredParameters()
    {
        $params =
        [
            ## ======================== *Required Parameters  =========================
            'appId'             => 2664,
        ];
        try {
            $result = self::$sakkuService->commitAppContainer($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCommitAppContainerValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'appId'             => '2664',
            'Authorization'     => 123,
            'containerId'       => '9',
            'tag'               => 123,
        ];
        try {
            self::$sakkuService->commitAppContainer($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->commitAppContainer($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

            $this->assertArrayHasKey('containerId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['containerId'][0]);

            $this->assertArrayHasKey('tag', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['tag'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testUpdateAppConfigAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
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
            'appId'             => 2664,
            ## ========================= Optional Parameters  =========================
            'Authorization'     => $this->Authorization,

    ];

        try {
            $result = self::$sakkuService->updateAppConfig($params);
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
        $params =
        [
            ## ======================================== *Required Parameters  ==============================================
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
            'appId'             => 2664,
        ];
        try {
            $result = self::$sakkuService->updateAppConfig($params);
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
        $paramsWrongValue =
        [
            'config'  => 'test',
            'appId'    => '2664',
            'Authorization' => 123
        ];
        try {
            self::$sakkuService->updateAppConfig($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('config', $validation);
            $this->assertEquals('The property config is required', $validation['config'][0]);

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->updateAppConfig($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('config', $validation);
            $this->assertEquals('String value found, but an array is required', $validation['config'][1]);

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetRealTimeDeployAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->getRealTimeDeploy($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetRealTimeDeployRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getRealTimeDeploy($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetRealTimeDeployValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,
    ];
        try {
            self::$sakkuService->getRealTimeDeploy($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getRealTimeDeploy($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetFakeAppStateAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->getFakeAppState($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetFakeAppStateRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getFakeAppState($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetFakeAppStateValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,
    ];
        try {
            self::$sakkuService->getFakeAppState($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getFakeAppState($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testLogsExportAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
            'fromDate'          => 1569184200000,
            'toDate'            => 1571516999000,
        ];

        try {
            $result = self::$sakkuService->logsExport($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testLogsExportRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->logsExport($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testLogsExportValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,
            'fromDate'          => '1569184200000',
            'toDate'            => '1571516999000',
    ];
        try {
            self::$sakkuService->logsExport($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->logsExport($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('fromDate', $validation);
            $this->assertEquals('String value found, but a number is required', $validation['fromDate'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('toDate', $validation);
            $this->assertEquals('String value found, but a number is required', $validation['toDate'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testRebuildAppAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->rebuildApp($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testRebuildAppRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->rebuildApp($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testRebuildAppValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->rebuildApp($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->rebuildApp($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppSettingAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->getAppSetting($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppSettingRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getAppSetting($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppSettingValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->getAppSetting($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getAppSetting($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testRestartAppByIdAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->token,
            'commitStart'     => true,
            'commitStop'     => false,
            'tagStart'     => 'latest',
            'tagStop'     => 'empty',
        ];

        try {
            $result = self::$sakkuService->restartAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testRestartAppByIdRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->restartAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testRestartAppByIdValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,
            'commitStart'     => 12,
            'commitStop'     => 32,
            'tagStart'     => 32,
            'tagStop'     => 12,

    ];
        try {
            self::$sakkuService->restartAppById($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->restartAppById($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('commitStart', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['commitStart'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('commitStop', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['commitStop'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('tagStart', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['tagStart'][0]);
            $this->assertEquals(887, $result['code']);


            $this->assertArrayHasKey('tagStop', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['tagStop'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStopDeployingAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->stopDeploying($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStopDeployingRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->stopDeploying($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStopDeployingValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->stopDeploying($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->stopDeploying($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppVersionsAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->getAppVersions($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppVersionsRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getAppVersions($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppVersionsValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->getAppVersions($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getAppVersions($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCheckAppHealthAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->checkAppHealth($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCheckAppHealthRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->checkAppHealth($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCheckAppHealthValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->checkAppHealth($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->checkAppHealth($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCheckAppHealthByIdAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            'hid'               => 16,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->checkAppHealthById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCheckAppHealthByIdByIdRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            'hid'               => 16,

    ];
        try {
            $result = self::$sakkuService->checkAppHealthById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCheckAppHealthByIdByIdValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            'hid'               => '16',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->checkAppHealthById($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertArrayHasKey('hid', $validation);
            $this->assertEquals('The property hid is required', $validation['hid'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->checkAppHealthById($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('hid', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['hid'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetChatDataAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->getChatData($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetChatDataRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getChatData($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetChatDataValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->getChatData($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getChatData($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }
    
    public function testGetAppByIdAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->Authorization,
        ];

        try {
            $result = self::$sakkuService->getAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppByIdRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppByIdValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,

    ];
        try {
            self::$sakkuService->getAppById($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getAppById($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }
    
    public function testStartAppByIdAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->token,
            'committed'     => false,
            'force'     => false,
            'tag'     => 'latest',
        ];

        try {
            $result = self::$sakkuService->startAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStartAppByIdRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->startAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStartAppByIdValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,
            'committed'     => 123,
            'force'     => 123,
            'tag'     => 123,

    ];
        try {
            self::$sakkuService->startAppById($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->startAppById($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('committed', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['committed'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('force', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['force'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('tag', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['tag'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStopAppByIdAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->token,
            'commit'     => false,
            'tag'     => 'latest',
        ];

        try {
            $result = self::$sakkuService->stopAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStopAppByIdRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->stopAppById($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testStopAppByIdValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 1234,
            'commit'     => 123,
            'tag'     => 123,

    ];
        try {
            self::$sakkuService->stopAppById($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->stopAppById($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('commit', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['commit'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('tag', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['tag'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCreateAppWebhooksAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            'url'               => '192.168.6.22:8088',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->token,
            'secured'           => false,
            'topics'            => 'ALL',
        ];

        try {
            $result = self::$sakkuService->createAppWebhooks($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCreateAppWebhooksRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            'url'               => '192.168.6.22:8088',
    ];
        try {
            $result = self::$sakkuService->createAppWebhooks($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testCreateAppWebhooksValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            'url'               => 123
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 123,
            'secured'           => 123,
            'topics'            => 'test',

    ];
        try {
            self::$sakkuService->createAppWebhooks($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertArrayHasKey('url', $validation);
            $this->assertEquals('The property url is required', $validation['url'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->createAppWebhooks($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('url', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['url'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('secured', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['secured'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('topics', $validation);
            $this->assertEquals('Does not have a value in the enumeration ["ALL","MEMBER","DELETE","RUN_STATE","PUSH","PULL","GIT","DOCKER","ISSUE"]', $validation['topics'][0]);
            $this->assertEquals(887, $result['code']);

        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppActivityAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->token,
            'page'              => 1,
            'size'              => 1,
        ];

        try {
            $result = self::$sakkuService->getAppActivity($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppActivityRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getAppActivity($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppActivityValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 123,
            'page'              => '1',
            'size'              => '1',

    ];
        try {
            self::$sakkuService->getAppActivity($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getAppActivity($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);


            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('page', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['page'][0]);
            $this->assertEquals(887, $result['code']);

            $this->assertArrayHasKey('size', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['size'][0]);
            $this->assertEquals(887, $result['code']);


        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppCollaboratorsAllParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => $this->token,
            'all'              => false,
            'page'              => 1,
            'size'              => 1,
        ];

        try {
            $result = self::$sakkuService->getAppCollaborators($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppCollaboratorsRequiredParameters()
    {
        $params =
        [
            ## ====================== *Required Parameters  =========================
            'appId'             => 2664,
    ];
        try {
            $result = self::$sakkuService->getAppCollaborators($params);
            $this->assertFalse($result['error']);
            $this->assertEquals($result['code'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testGetAppCollaboratorsValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            ## ====================== *Required Parameters  =========================
            'appId'             => '2664',
            ## ====================== Optional Parameters  ==========================
            'Authorization'     => 123,
            'all'               => 2,
            'page'              => '1',
            'size'              => '1',
        ];
        try {
            self::$sakkuService->getAppCollaborators($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('The property appId is required', $validation['appId'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$sakkuService->getAppCollaborators($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();
            $this->assertArrayHasKey('appId', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

            $this->assertArrayHasKey('Authorization', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

            $this->assertArrayHasKey('page', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['page'][0]);

            $this->assertArrayHasKey('size', $validation);
            $this->assertEquals('String value found, but an integer is required', $validation['size'][0]);

            $this->assertArrayHasKey('all', $validation);
            $this->assertEquals('Integer value found, but a boolean or a string is required', $validation['all'][0]);
            $this->assertEquals(887, $result['code']);


        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testAddAppCollaboratorAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			## ================= Optional Parameters  =================
			'level' => '',
		];
		try {
			$result = $SakkuService->addAppCollaborator($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddAppCollaboratorRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
        ];
		try {
			$result = $SakkuService->addAppCollaborator($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddAppCollaboratorValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			## =============== Optional Parameters  ===============
			'level' => '123',
		];
		try {
			self::$SakkuService->addAppCollaborator($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->addAppCollaborator($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('level', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['level'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateAppCollaboratorAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			## ================= Optional Parameters  =================
			'level' => '',
		];
		try {
			$result = $SakkuService->updateAppCollaborator($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateAppCollaboratorRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
        ];
		try {
			$result = $SakkuService->updateAppCollaborator($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateAppCollaboratorValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			## =============== Optional Parameters  ===============
			'level' => '123',
		];
		try {
			self::$SakkuService->updateAppCollaborator($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->updateAppCollaborator($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('level', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['level'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAppCollaboratorAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'appId' => '',
			'cid' => '',
		];
		try {
			$result = $SakkuService->deleteAppCollaborator($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAppCollaboratorRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
        ];
		try {
			$result = $SakkuService->deleteAppCollaborator($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAppCollaboratorValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'appId' => '123',
			'cid' => '123',
		];
		try {
			self::$SakkuService->deleteAppCollaborator($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->deleteAppCollaborator($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][0]);

			$this->assertArrayHasKey('cid', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['cid'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testVerifyUserCommandPermissionAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'appId' => '',
			'cmd' => '',
		];
		try {
			$result = $SakkuService->verifyUserCommandPermission($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testVerifyUserCommandPermissionRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
        ];
		try {
			$result = $SakkuService->verifyUserCommandPermission($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testVerifyUserCommandPermissionValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'appId' => '123',
			'cmd' => 123,
		];
		try {
			self::$SakkuService->verifyUserCommandPermission($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->verifyUserCommandPermission($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][0]);

			$this->assertArrayHasKey('cmd', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['cmd'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetAppHealthCheckAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'appId' => '',
		];
		try {
			$result = $SakkuService->getAppHealthCheck($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetAppHealthCheckRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
        ];
		try {
			$result = $SakkuService->getAppHealthCheck($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetAppHealthCheckValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'appId' => '123',
		];
		try {
			self::$SakkuService->getAppHealthCheck($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->getAppHealthCheck($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddAppHealthCheckAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'checkRate' => '',
			'endpoint' => '',
			'initialDelay' => '',
			'responseCode' => '',
			'responseString' => '',
			'scheme' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->addAppHealthCheck($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddAppHealthCheckRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'checkRate' => '',
			'endpoint' => '',
			'initialDelay' => '',
			'responseCode' => '',
			'responseString' => '',
			'scheme' => '',
        ];
		try {
			$result = $SakkuService->addAppHealthCheck($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testAddAppHealthCheckValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'checkRate' => '123',
			'endpoint' => 123,
			'initialDelay' => '123',
			'responseCode' => '123',
			'responseString' => 123,
			'scheme' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->addAppHealthCheck($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('checkRate', $validation);
			$this->assertEquals('The property checkRate is required', $validation['checkRate'][0]);

			$this->assertArrayHasKey('endpoint', $validation);
			$this->assertEquals('The property endpoint is required', $validation['endpoint'][0]);

			$this->assertArrayHasKey('initialDelay', $validation);
			$this->assertEquals('The property initialDelay is required', $validation['initialDelay'][0]);

			$this->assertArrayHasKey('responseCode', $validation);
			$this->assertEquals('The property responseCode is required', $validation['responseCode'][0]);

			$this->assertArrayHasKey('responseString', $validation);
			$this->assertEquals('The property responseString is required', $validation['responseString'][0]);

			$this->assertArrayHasKey('scheme', $validation);
			$this->assertEquals('The property scheme is required', $validation['scheme'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->addAppHealthCheck($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('checkRate', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['checkRate'][1]);

			$this->assertArrayHasKey('endpoint', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['endpoint'][1]);

			$this->assertArrayHasKey('initialDelay', $validation);
			$this->assertEquals('String value found, but a number is required', $validation['initialDelay'][1]);

			$this->assertArrayHasKey('responseCode', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['responseCode'][1]);

			$this->assertArrayHasKey('responseString', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['responseString'][1]);

			$this->assertArrayHasKey('scheme', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['scheme'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAllAppHealthChecksAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'path' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->deleteAllAppHealthChecks($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAllAppHealthChecksRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'path' => '',
        ];
		try {
			$result = $SakkuService->deleteAllAppHealthChecks($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAllAppHealthChecksValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'path' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->deleteAllAppHealthChecks($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('path', $validation);
			$this->assertEquals('The property path is required', $validation['path'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->deleteAllAppHealthChecks($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('path', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['path'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateHealthCheckByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'hid' => '',
			'endpoint' => '',
			'initialDelay' => '',
			'responseCode' => '',
			'responseString' => '',
			'scheme' => '',
			'checkRate' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->updateHealthCheckById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateHealthCheckByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'hid' => '',
			'endpoint' => '',
			'initialDelay' => '',
			'responseCode' => '',
			'responseString' => '',
			'scheme' => '',
			'checkRate' => '',
        ];
		try {
			$result = $SakkuService->updateHealthCheckById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateHealthCheckByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'hid' => '123',
			'checkRate' => '123',
			'endpoint' => 123,
			'initialDelay' => '123',
			'responseCode' => '123',
			'responseString' => 123,
			'scheme' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->updateHealthCheckById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('hid', $validation);
			$this->assertEquals('The property hid is required', $validation['hid'][0]);

			$this->assertArrayHasKey('checkRate', $validation);
			$this->assertEquals('The property checkRate is required', $validation['checkRate'][0]);

			$this->assertArrayHasKey('endpoint', $validation);
			$this->assertEquals('The property endpoint is required', $validation['endpoint'][0]);

			$this->assertArrayHasKey('initialDelay', $validation);
			$this->assertEquals('The property initialDelay is required', $validation['initialDelay'][0]);

			$this->assertArrayHasKey('responseCode', $validation);
			$this->assertEquals('The property responseCode is required', $validation['responseCode'][0]);

			$this->assertArrayHasKey('responseString', $validation);
			$this->assertEquals('The property responseString is required', $validation['responseString'][0]);

			$this->assertArrayHasKey('scheme', $validation);
			$this->assertEquals('The property scheme is required', $validation['scheme'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->updateHealthCheckById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('hid', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['hid'][1]);

			$this->assertArrayHasKey('checkRate', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['checkRate'][1]);

			$this->assertArrayHasKey('endpoint', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['endpoint'][1]);

			$this->assertArrayHasKey('initialDelay', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['initialDelay'][1]);

			$this->assertArrayHasKey('responseCode', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['responseCode'][1]);

			$this->assertArrayHasKey('responseString', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['responseString'][1]);

			$this->assertArrayHasKey('scheme', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['scheme'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteHealthCheckByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'hid' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->deleteHealthCheckById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteHealthCheckByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'hid' => '',
        ];
		try {
			$result = $SakkuService->deleteHealthCheckById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteHealthCheckByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'hid' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->deleteHealthCheckById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('hid', $validation);
			$this->assertEquals('The property hid is required', $validation['hid'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->deleteHealthCheckById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('hid', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['hid'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetRealTimeAppLogsByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'time' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->getRealTimeAppLogsById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetRealTimeAppLogsByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'time' => '',
        ];
		try {
			$result = $SakkuService->getRealTimeAppLogsById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetRealTimeAppLogsByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'time' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->getRealTimeAppLogsById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('time', $validation);
			$this->assertEquals('The property time is required', $validation['time'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->getRealTimeAppLogsById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('time', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['time'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testTransferAppByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'addAsCollaborator' => '',
			'customerEmail' => '',
			'transferGit' => '',
			'transferImageRepo' => '',
		];
		try {
			$result = $SakkuService->transferAppById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testTransferAppByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
        ];
		try {
			$result = $SakkuService->transferAppById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testTransferAppByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'addAsCollaborator' => 123,
			'customerEmail' => 123,
			'transferGit' => 123,
			'transferImageRepo' => 123,
		];
		try {
			self::$SakkuService->transferAppById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->transferAppById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('addAsCollaborator', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['addAsCollaborator'][0]);

			$this->assertArrayHasKey('customerEmail', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['customerEmail'][0]);

			$this->assertArrayHasKey('transferGit', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['transferGit'][0]);

			$this->assertArrayHasKey('transferImageRepo', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['transferImageRepo'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetAppWebHooksAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->getAppWebHooks($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetAppWebHooksRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
        ];
		try {
			$result = $SakkuService->getAppWebHooks($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetAppWebHooksValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->getAppWebHooks($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->getAppWebHooks($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateWebHookByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'wid' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'applicationId' => '',
			'secured' => '',
			'topics' => '',
			'url' => '',
		];
		try {
			$result = $SakkuService->updateWebHookById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateWebHookByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'wid' => '',
        ];
		try {
			$result = $SakkuService->updateWebHookById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testUpdateWebHookByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'wid' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'applicationId' => '123',
			'secured' => 123,
			'topics' => 123,
			'url' => 123,
		];
		try {
			self::$SakkuService->updateWebHookById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('wid', $validation);
			$this->assertEquals('The property wid is required', $validation['wid'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->updateWebHookById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('wid', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['wid'][1]);

			$this->assertArrayHasKey('applicationId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['applicationId'][0]);

			$this->assertArrayHasKey('secured', $validation);
			$this->assertEquals('Integer value found, but a boolean is required', $validation['secured'][0]);

			$this->assertArrayHasKey('topics', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['topics'][0]);

			$this->assertArrayHasKey('url', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['url'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAppWebHookByIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'wid' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->deleteAppWebHookById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAppWebHookByIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'appId' => '',
			'wid' => '',
        ];
		try {
			$result = $SakkuService->deleteAppWebHookById($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testDeleteAppWebHookByIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'appId' => '123',
			'wid' => '123',
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->deleteAppWebHookById($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('The property appId is required', $validation['appId'][0]);

			$this->assertArrayHasKey('wid', $validation);
			$this->assertEquals('The property wid is required', $validation['wid'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->deleteAppWebHookById($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('appId', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['appId'][1]);

			$this->assertArrayHasKey('wid', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['wid'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetApplicationByNameAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'name' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->getApplicationByName($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetApplicationByNameRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'name' => '',
        ];
		try {
			$result = $SakkuService->getApplicationByName($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetApplicationByNameValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'name' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->getApplicationByName($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('name', $validation);
			$this->assertEquals('The property name is required', $validation['name'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->getApplicationByName($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('name', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['name'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testCreateAppByDockerComposeAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'composeFile' => '',
			'globalConfig' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
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
			'composeFile' => '',
			'globalConfig' => '',
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

	public function testCreateAppByStateMachineAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'config' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
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
			'config' => '',
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

	public function testGetUserAppsStatusListAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			## ================= Optional Parameters  =================
			'Authorization' => '',
			'id' => '',
		];
		try {
			$result = $SakkuService->getUserAppsStatusList($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetUserAppsStatusListRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
        ];
		try {
			$result = $SakkuService->getUserAppsStatusList($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testGetUserAppsStatusListValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
			'id' => '123',
		];
		try {
			self::$SakkuService->getUserAppsStatusList($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->getUserAppsStatusList($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('id', $validation);
			$this->assertEquals('String value found, but an integer is required', $validation['id'][0]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testStopAppDeployWithQueueIdAllParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'deployQueueId' => '',
			## ================= Optional Parameters  =================
			'Authorization' => '',
		];
		try {
			$result = $SakkuService->stopAppDeployWithQueueId($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testStopAppDeployWithQueueIdRequiredParameters()
	{
		$params = [
			## ================= *Required Parameters  =================
			'deployQueueId' => '',
        ];
		try {
			$result = $SakkuService->stopAppDeployWithQueueId($params);
			$this->assertFalse($result['error']);
			$this->assertEquals($result['code'], 200);
		} catch (ValidationException $e) {
			$this->fail('ValidationException: ' . $e->getErrorsAsString());
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

	public function testStopAppDeployWithQueueIdValidationError()
	{
		$paramsWithoutRequired = [];
		$paramsWrongValue = [
			## =============== *Required Parameters  ===============
			'deployQueueId' => 123,
			## =============== Optional Parameters  ===============
			'Authorization' => 123,
		];
		try {
			self::$SakkuService->stopAppDeployWithQueueId($paramsWithoutRequired);
		} catch (ValidationException $e) {
			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();

			$this->assertArrayHasKey('deployQueueId', $validation);
			$this->assertEquals('The property deployQueueId is required', $validation['deployQueueId'][0]);


			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
		try {
			self::$SakkuService->stopAppDeployWithQueueId($paramsWrongValue);
		} catch (ValidationException $e) {

			$validation = $e->getErrorsAsArray();
			$this->assertNotEmpty($validation);

			$result = $e->getResult();
			$this->assertArrayHasKey('Authorization', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['Authorization'][0]);

			$this->assertArrayHasKey('deployQueueId', $validation);
			$this->assertEquals('Integer value found, but a string is required', $validation['deployQueueId'][1]);

			$this->assertEquals(887, $result['code']);
		} catch (PodException $e) {
			$error = $e->getResult();
			$this->fail('PodException: ' . $error['message']);
		}
	}

}
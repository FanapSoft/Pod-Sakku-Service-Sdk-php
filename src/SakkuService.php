<?php

namespace Pod\Sakku\Service;

use Pod\Base\Service\BaseService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\PodException;

class SakkuService extends BaseService
{
    private $header;
    private static $sakkuApi;
    private static $jsonSchema;
    private static $serviceProductId;

    public function __construct($baseInfo)
    {
        BaseInfo::initServerType(BaseInfo::PRODUCTION_SERVER);
        parent::__construct();
        $this->header = [
            'Authorization'   => $baseInfo->getToken()
        ];
        self::$jsonSchema = json_decode(file_get_contents(__DIR__ . '/../config/validationSchema.json'), true);
        self::$sakkuApi = require __DIR__ . '/../config/apiConfig.php';
    }
## =================== Application Methods ========================
    public function getUserAppList($params) {
        $apiName = 'getUserAppList';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);    
    }

    public function createApp($params) {
        $apiName = 'createApp';
        $paramKey = 'json';
        $authorization = '';
        if(isset($params['Authorization'])) {
            $authorization = $params['Authorization'];
        }
        $params = $params['config'];

        if(!empty($authorization)) {
            $params['Authorization'] = $authorization;
        }
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);    
    }

    public function deleteAppById($params) {
        $apiName = 'deleteAppById';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function commitAppContainer($params) {
        $apiName = 'commitAppContainer';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function updateAppConfig($params) {
        $apiName = 'updateAppConfig';
        $paramKey = 'json';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getRealTimeDeploy($params) {
        $apiName = 'getRealTimeDeploy';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);        
    }

    public function getFakeAppState($params) {
        $apiName = 'getFakeAppState';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);       
    }

    public function logsExport($params) {
        $apiName = 'logsExport';
        $paramKey = 'query';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }
        $params['token'] = $header['Authorization'];

        $option = [
            'headers' => $header,
            $paramKey => $params
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri if is set
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);
        
        // convert string dates to timestamp
        if (isset($option[$paramKey]['fromDate']) && is_string($option[$paramKey]['fromDate'])) {
            $option[$paramKey]['fromDate'] = strtotime($option[$paramKey]['fromDate']);
        }
        if (isset($option[$paramKey]['toDate']) && is_string($option[$paramKey]['toDate'])) {
            $option[$paramKey]['toDate'] = strtotime($option[$paramKey]['toDate']);
        }

        $saveTo = isset($option[$paramKey]['saveTo']) ? $option[$paramKey]['saveTo'] : '';
        unset($option[$paramKey]['saveTo']);
        return  SakkuApiRequestHandler::logRequest($baseUri, $method, $subUri, $option, $saveTo);
     
    }

    public function rebuildApp($params) {
        $apiName = 'rebuildApp';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);
    }

    public function restartAppById($params) {
        $apiName = 'restartAppById';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);           
    }

    public function getAppSetting($params) {
        $apiName = 'getAppSetting';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function startAppById($params) {
        $apiName = 'startAppById';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function stopAppById($params) {
        $apiName = 'stopAppById';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function stopAppDeploy($params) {
        $apiName = 'stopAppDeploy';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getAppVersions($params) {
        $apiName = 'getAppVersions';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function createAppWebhooks($params) {
        $apiName = 'createAppWebhooks';
        $paramKey = 'json';
        if ( isset($params['appId']) ) {
            $params['applicationId'] = $params['appId'];
        }

        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getAppById($params) {
        $apiName = 'getAppById';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getAppActivity($params) {
        $apiName = 'getAppActivity';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getChatData($params) {
        $apiName = 'getChatData';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function checkAppHealth($params) {
        $apiName = 'checkAppHealth';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function checkAppHealthById($params) {
        $apiName = 'checkAppHealthById';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, true, true);    
    }

    public function getAppCollaborators($params) {
        $apiName = 'getAppCollaborators';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function addAppCollaborator($params) {
        $apiName = 'addAppCollaborator';
        $paramKey = 'json';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        array_walk_recursive($params, 'self::prepareData');
        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $queryParams = [];
        if (isset($params['level'])) {
            $queryParams['level'] = $params['level'];
            unset($params['level']);
        }
        $option = [
            'headers' => $header,
            $paramKey => $params,
            'query'   => $queryParams
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];

        // replace {appId} with real appId in subUri if is set
        if (isset($option[$paramKey]['appId'])) {
            $appId = $option[$paramKey]['appId'];
            $subUri = str_replace('{appId}', $appId, $subUri);
            unset($option[$paramKey]['appId']);
        }

        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);   
    }

    public function updateAppCollaborator($params) {
        $apiName = 'updateAppCollaborator';
        $paramKey = 'json';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $queryParams = [];
        if (isset($params['level'])) {
            $queryParams['level'] = $params['level'];
            unset($params['level']);
        }
        $option = [
            'headers' => $header,
            $paramKey => $params,
            'query'   => $queryParams
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);
        // replace {cid} with real collaborator id in subUri
        $collaboratorId = $option[$paramKey]['cid'];
        $subUri = str_replace('{cid}', $collaboratorId, $subUri);
        unset($option[$paramKey]['cid']);

        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);   
    }

    public function deleteAppCollaborator($params) {
        $apiName = 'deleteAppCollaborator';
        $paramKey = 'query';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);
        // replace {cid} with real collaborator id in subUri
        $collaboratorId = $option[$paramKey]['cid'];
        $subUri = str_replace('{cid}', $collaboratorId, $subUri);
        unset($option[$paramKey]['cid']);

        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);   
    }

    public function verifyUserCommandPermission($params) {
        $apiName = 'verifyUserCommandPermission';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getAppHealthCheck($params) {
        $apiName = 'getAppHealthCheck';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);     
    }

    public function addAppHealthCheck($params) {
        $apiName = 'addAppHealthCheck';
        $paramKey = 'json';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function deleteAllAppHealthChecks($params) {
        $apiName = 'deleteAllAppHealthChecks';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function updateHealthCheckById($params) {
        $apiName = 'updateHealthCheckById';
        $paramKey = 'json';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri if is set
        if (isset($option[$paramKey]['appId'])) {
            $appId = $option[$paramKey]['appId'];
            $subUri = str_replace('{appId}', $appId, $subUri);
            unset($option[$paramKey]['appId']);
        }

        // replace {hid} with real health check Id in subUri if is set
        if (isset($option[$paramKey]['hid'])) {
            $healthCheckId = $option[$paramKey]['hid'];
            $subUri = str_replace('{hid}', $healthCheckId, $subUri);
            unset($option[$paramKey]['hid']);
        }

        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);   
    }

    public function deleteHealthCheckById($params) {
        $apiName = 'deleteHealthCheckById';
        $paramKey = 'query';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri if is set
        if (isset($option[$paramKey]['appId'])) {
            $appId = $option[$paramKey]['appId'];
            $subUri = str_replace('{appId}', $appId, $subUri);
            unset($option[$paramKey]['appId']);
        }

        // replace {hid} with real health check Id in subUri if is set
        if (isset($option[$paramKey]['hid'])) {
            $healthCheckId = $option[$paramKey]['hid'];
            $subUri = str_replace('{hid}', $healthCheckId, $subUri);
            unset($option[$paramKey]['hid']);
        }

        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);     
    }

    public function getRealTimeAppLogsById($params) {
        $apiName = 'getRealTimeAppLogsById';
        $paramKey = 'query';
        // convert string dates to timestamp
        if (isset($params['time']) && is_string($params['time'])) {
            $params['time'] = strtotime($params['time']);
        }
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function transferAppById($params) {
        $apiName = 'transferAppById';
        $paramKey = 'json';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function getAppWebHooks($params) {
        $apiName = 'getAppWebHooks';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);    
    }

    public function updateWebHookById($params) {
        $apiName = 'updateWebHookById';
        $paramKey = 'json';
        $header = $this->header;
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);

        // replace {wid} with real webhook id in subUri
        $collaboratorId = $option[$paramKey]['wid'];
        $subUri = str_replace('{wid}', $collaboratorId, $subUri);
        unset($option[$paramKey]['wid']);

        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
             $option);        
    }

    public function deleteAppWebHookById($params) {
        $apiName = 'deleteAppWebHookById';
        $paramKey = 'query';
        $header = $this->header;
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);

        // replace {wid} with real webhook id in subUri
        $collaboratorId = $option[$paramKey]['wid'];
        $subUri = str_replace('{wid}', $collaboratorId, $subUri);
        unset($option[$paramKey]['wid']);

        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
             $option);      
    }

    public function getApplicationByName($params) {
        $apiName = 'getApplicationByName';
        $paramKey = 'query';
        $header = $this->header;
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appName} with real appName in subUri
        $appName = $option[$paramKey]['name'];
        $subUri = str_replace('{appName}', $appName, $subUri);
        unset($option[$paramKey]['name']);

        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
             $option);  
    }

    public function createAppByDockerCompose($params) {
        $apiName = 'createAppByDockerCompose';
        $paramKey = 'multipart';
        $header = $this->header;
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        $option[$paramKey] = [
            [
                'name'     => 'composeFile',
                'contents' => fopen($option[$paramKey]['composeFile'], 'r')
            ],
            [
                'name'     => 'globalConfig',
                'contents' => $option[$paramKey]['globalConfig'],
            ],
        ];
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
             $option);  
    }

    // public function getGroupByName($params) {
    //     $apiName = 'getGroupByName';
    //     $paramKey = 'query';
    //     return $this->prepareDataAndSendRequest($params, $apiName, $paramKey);        
    // }

    public function createPipeline($params) {
        $apiName = 'createPipeline';
        $paramKey = 'json';
        $header = $this->header;
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        $option[$paramKey] = $option[$paramKey]['configs'];
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            self::$sakkuApi[$apiName]['subUri'],
             $option);    
    }

    public function createAppByStateMachine($params) {
        $apiName = 'createAppByStateMachine';
        $paramKey = 'json';
        $header = $this->header;
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        $option[$paramKey] = $option[$paramKey]['config'];
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            self::$sakkuApi[$apiName]['subUri'],
             $option);  
    }

    public function getUserAppsStatusList($params) {
        $apiName = 'getUserAppsStatusList';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);    
    }

    public function stopAppDeployWithQueueId($params) {
        $apiName = 'stopAppDeployWithQueueId';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);    
    }
## =================== Catalogs Methods ===========================

    public function createCatalogApp($params) {
		$apiName = 'createCatalogApp';
		$paramKey = 'json';
        $header = $this->header;
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {catalogId} with real catalogId in subUri
            $catalogId = $option[$paramKey]['catalogId'];
            $subUri = str_replace('{catalogId}', $catalogId, $subUri);
            unset($option[$paramKey]['catalogId']);

        $option[$paramKey] = $option[$paramKey]['catalogAppConfig'];
        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);   
	}

	public function createCatalogAppBySakkuApp($params) {
		$apiName = 'createCatalogAppBySakkuApp';
        $paramKey = 'json';
        $queryParams = [];
        $header = $this->header;
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }
        // set Authorization in header
        if (isset($params['appId'])) {
            $queryParams['appId'] = $params['appId'];
            unset($params['appId']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
            'query' => $queryParams,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {catalogId} with real catalogId in subUri 
        $catalogId = $option[$paramKey]['catalogId'];
        $subUri = str_replace('{catalogId}', $catalogId, $subUri);
        unset($option[$paramKey]['catalogId']);

        $option[$paramKey] = $option[$paramKey]['catalogAppConfig'];
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        ); 
    }

	public function updateCatalog($params) {
		$apiName = 'updateCatalog';
		$paramKey = 'json';
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        // replace {catalogAppId} with real catalogAppId in subUri
        $catalogAppId = $option[$paramKey]['catalogAppId'];
        $subUri = str_replace('{catalogAppId}', $catalogAppId, $subUri);
        unset($option[$paramKey]['catalogAppId']);

        $option[$paramKey] = $option[$paramKey]['catalogAppConfig'];
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        ); 
	}

	public function getAllCatalogs($params = []) {
		$apiName = 'getAllCatalogs';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function getCatalogApp($params) {
		$apiName = 'getCatalogApp';
        $paramKey = 'query';
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);
        
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        // replace {catalogId} with real catalogId in subUri
        $catalogId = $option[$paramKey]['catalogId'];
        $subUri = str_replace('{catalogId}', $catalogId, $subUri);
        unset($option[$paramKey]['catalogId']);

        // replace {catalogAppId} with real catalogAppId in subUri
        $catalogAppId = $option[$paramKey]['catalogAppId'];
        $subUri = str_replace('{catalogAppId}', $catalogAppId, $subUri);
        unset($option[$paramKey]['catalogAppId']);

        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        ); 
	}

	public function getAllCatalogAppById($params) {
        $apiName = 'getAllCatalogAppById';
        $paramKey = 'query';
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        // replace {catalogId} with real catalogId in subUri
        $catalogId = $option[$paramKey]['catalogId'];
        $subUri = str_replace('{catalogId}', $catalogId, $subUri);
        unset($option[$paramKey]['catalogId']);

        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option); 
	}

	public function getUserFeedbackCatalog($params = []) {
		$apiName = 'getUserFeedbackCatalog';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function addUserFeedbackCatalogs($params) {
		$apiName = 'addUserFeedbackCatalogs';
		$paramKey = 'json';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function getAllMetaData($params) {
		$apiName = 'getAllMetaData';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function validateMetaData($params) {
		$apiName = 'validateMetaData';
		$paramKey = 'json';
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);
        $option[$paramKey] = $option[$paramKey]['metadata'];
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        ); 
	}

	public function deployAppFromCatalog($params) {
		$apiName = 'deployAppFromCatalog';
        return deployAppFromCatalogBase($params, $apiName);
	}

	public function deployAppFromCatalogTest($params) {
		$apiName = 'deployAppFromCatalogTest';
        return deployAppFromCatalogBase($params, $apiName);
	}

	public function addDomain($params) {
		$apiName = 'addDomain';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, true);
	}

	public function getAllUserDomains($params = []) {
		$apiName = 'getAllUserDomains';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function getAppDomains($params) {
		$apiName = 'getAppDomains';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, true);
	}

	public function removeDomain($params) {
		$apiName = 'removeDomain';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, true);
	}

	public function addBasicAuthUsers($params) {
		$apiName = 'addBasicAuthUsers';
		$paramKey = 'json';
		$subUri = self::$sakkuApi[$apiName]['subUri'];
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        // replace {appId} with real appId in subUri 
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);

        # prepare json data
        $option[$paramKey] = $option[$paramKey]['basicAuthentication'];

        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        ); 
	}

	public function getBasicAuthUsers($params) {
		$apiName = 'getBasicAuthUsers';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, true);
	}

	public function deleteBasicAuthUsers($params) {
		$apiName = 'deleteBasicAuthUsers';
        $paramKey = 'query';
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        $subUri = self::$sakkuApi[$apiName]['subUri'];
        // replace {appId} with real appId in subUri 
        $appId = $option[$paramKey]['appId'];
        $subUri = str_replace('{appId}', $appId, $subUri);
        unset($option[$paramKey]['appId']);

        // replace {basicAuthId} with real basicAuthId in subUri 
        $basicAuthId = $option[$paramKey]['basicAuthId'];
        $subUri = str_replace('{basicAuthId}', $basicAuthId, $subUri);
        unset($option[$paramKey]['basicAuthId']); 

		return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        );
	}

	public function getAvailablePortOptions($params = []) {
		$apiName = 'getAvailablePortOptions';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function getDomainRecords($params) {
		$apiName = 'getDomainRecords';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function addDomainRecord($params) {
		$apiName = 'addDomainRecord';
        $paramKey = 'json';
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $queryParams = [];
        $header = $this->header;
        // $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        // set domain in query params
        if (isset($params['domain'])) {
            $queryParams['domain'] = $params['domain'];
            unset($params['domain']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
            'query' => $queryParams,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        self::validateOption($option, self::$jsonSchema[$apiName], 'query');

        // prepare json data befor send
        $option[$paramKey] = $option[$paramKey]['recordConfig'];
        
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        );
	}

	public function updateDomainRecord($params) {
		$apiName = 'updateDomainRecord';
		$paramKey = 'json';
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $queryParams = [];
        $header = $this->header;
        // $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        // set domain in query params
        if (isset($params['domain'])) {
            $queryParams['domain'] = $params['domain'];
            unset($params['domain']);
        }

        // set name in query params
        if (isset($params['name'])) {
            $queryParams['name'] = $params['name'];
            unset($params['name']);
        }

        // set type in query params
        if (isset($params['type'])) {
            $queryParams['type'] = $params['type'];
            unset($params['type']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
            'query' => $queryParams,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        self::validateOption($option, self::$jsonSchema[$apiName], 'query');

        // prepare json data befor send
        $option[$paramKey] = $option[$paramKey]['recordConfig'];
        
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        );
	}

	public function deleteDomainRecord($params) {
		$apiName = 'deleteDomainRecord';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function getNetworks($params) {
		$apiName = 'getNetworks';
		$paramKey = 'query';
		return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function createNetwork($params) {
		$apiName = 'createNetwork';
        $paramKey = 'query';
        return $this->prepareDataAndSendRequest($params, $apiName, $paramKey, false);
	}

	public function addAppToNetwork($params) {
		$apiName = 'addAppToNetwork';
        $paramKey = 'query';
        $paramKey = 'query';
		list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        $subUri = self::$sakkuApi[$apiName]['subUri'];
        // replace {name} with real name in subUri 
        $name = $option[$paramKey]['name'];
        $subUri = str_replace('{name}', $name, $subUri);
        unset($option[$paramKey]['name']);

		return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        );
	}

	public function removeAppFromNetwork($params) {
		$apiName = 'removeAppFromNetwork';
		$paramKey = 'query';
		list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        $subUri = self::$sakkuApi[$apiName]['subUri'];
        // replace {name} with real name in subUri 
        $name = $option[$paramKey]['name'];
        $subUri = str_replace('{name}', $name, $subUri);
        unset($option[$paramKey]['name']);

		return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        );
	}

	public function deleteNetworkByUser($params) {
		$apiName = 'deleteNetworkByUser';
		$paramKey = 'query';
		list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);

        $subUri = self::$sakkuApi[$apiName]['subUri'];
        // replace {name} with real name in subUri 
        $name = $option[$paramKey]['name'];
        $subUri = str_replace('{name}', $name, $subUri);
        unset($option[$paramKey]['name']);

		return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        );
	}


## ----------- Utility private functions -------------
    private function prepareDataAndSendRequest($params, $apiName, $paramKey, $hasAppId = true){
        $method = self::$sakkuApi[$apiName]['method'];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        $baseUri = self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']];
        $header = $this->header;
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // replace {appId} with real appId in subUri if is set
        // if (isset($option[$paramKey]['appId'])) {
        if ($hasAppId) {
            $appId = $option[$paramKey]['appId'];
            $subUri = str_replace('{appId}', $appId, $subUri);
            unset($option[$paramKey]['appId']);
        }
        return  SakkuApiRequestHandler::Request($baseUri, $method, $subUri, $option);
    }

    private function deployAppFromCatalogBase($params, $apiName){
        $paramKey = 'multipart';
        $multipartParams = [];
        $subUri = self::$sakkuApi[$apiName]['subUri'];
        list($option, $header) = $this->prepareDataBeforeSend($params, $apiName, $paramKey);
        $option[$paramKey] = [
            [
                'name'     => "settings",
                'contents' => json_encode($params['settings'])
            ]
        ];
        if(!empty($params['files'])){
            $i = 0;
            // self::validateOption($option, self::$jsonSchema[$apiName], 'multipart');
            foreach($params['files'] as $filePath){
                $option['multipart'][] =
                [
                    'name'     => "files[$i]",
                    'contents' => fopen($filePath, 'r')
                ];
                $i++;
            }
        }

        // replace {catalogAppId} with real catalogAppId in subUri
        $catalogAppId = $params['catalogAppId'];
        $subUri = str_replace('{catalogAppId}', $catalogAppId, $subUri);
		
        return  SakkuApiRequestHandler::Request(
            self::$config[self::$serverType][self::$sakkuApi[$apiName]['baseUri']],
            self::$sakkuApi[$apiName]['method'],
            $subUri,
            $option
        ); 
    }

    private function prepareDataBeforeSend($params, $apiName, $paramKey){
        $header = $this->header;
        // $subUri = self::$sakkuApi[$apiName]['subUri'];
        array_walk_recursive($params, 'self::prepareData');

        // set Authorization in header
        if (isset($params['Authorization'])) {
            $header['Authorization'] = $params['Authorization'];
            unset($params['Authorization']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];
        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        return [$option, $header];
    }

}
<?php
return  [
  // #1 Get list of user applications
  'getUserAppList' => [
        'baseUri' => 'SAKKU-API-ADDRESS',
        'subUri' => 'app',
        'method' => 'GET'
  ],

  // #2 Create new application on sakku
  'createApp' => [
        'baseUri' => 'SAKKU-API-ADDRESS',
        'subUri' => 'app',
        'method' => 'POST'
  ],

  // #3 Delete application by id
  'deleteAppById' => [
        'baseUri' => 'SAKKU-API-ADDRESS',
        'subUri' => 'app/{appId}',
        'method' => 'DELETE'
  ],

  // #4 Commit application container
  'commitAppContainer' => [
        'baseUri' => 'SAKKU-API-ADDRESS',
        'subUri' => 'app/{appId}/commit',
        'method' => 'GET'
  ],

  // #5 Update application configuration. 0/null values will keep previous app values
  'updateAppConfig' => [
        'baseUri' => 'SAKKU-API-ADDRESS',
        'subUri' => 'app/{appId}/config',
        'method' => 'PUT'
  ],

  // #6 Get real time deploy state of application by id
  'getRealTimeDeploy' => [
        'baseUri' => 'SAKKU-API-ADDRESS',
        'subUri' => 'app/{appId}/deploy/state',
        'method' => 'GET'
  ],

  // #7 
  'getFakeAppState' => [
      'baseUri' => 'SAKKU-API-ADDRESS',
      'subUri' => 'app/{appId}/deploy/state/fake',
      'method' => 'GET'
  ],

  // #8 Logs export with from/to date
  'logsExport' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/logs/export',
    'method' => 'GET'
  ],

  // #9 Rebuild application source
  'rebuildApp' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/rebuild',
    'method' => 'GET'
  ],

  // #10 Restart application by id
  'restartAppById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/restart',
    'method' => 'GET'
  ],

  // #11 Get application settings
  'getAppSetting' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/setting',
    'method' => 'GET'
  ],

  // #12 Start application by id
  'startAppById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/start',
    'method' => 'GET'
  ],

  // #13 Stop application by id
  'stopAppById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/stop',
    'method' => 'GET'
  ],

  // #14 Stop deploy application process
  'stopAppDeploy' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/stopDeploying',
    'method' => 'GET'
  ],

  // #15 Get application committed versions
  'getAppVersions' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/versions',
    'method' => 'GET'
  ],

  // #16 Create new webhook for application by id
  'createAppWebhooks' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/webhooks',
    'method' => 'POST'
  ],

  // #17 Get application by id
  'getAppById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}',
    'method' => 'GET'
  ],

  // #18 Get activities on an application by id
  'getAppActivity' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/activity',
    'method' => 'GET'
  ],

  // #19 Return chat data for each collaborative application
  'getChatData' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/chat',
    'method' => 'GET'
  ],

  // #20 Recheck app healthChecks
  'checkAppHealth' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/check',
    'method' => 'GET'
  ],

  // #21 Recheck app healthChecks by id
  'checkAppHealthById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/check/{hid}',
    'method' => 'GET'
  ],

  // #22 Get collaborators of an application by id
  'getAppCollaborators' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/collaborators',
    'method' => 'GET'
  ],

  // #23 Add a collaborator to an application by id
  'addAppCollaborator' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/collaborators',
    'method' => 'POST'
  ],

  // #24 Update a collaborator from an application by id
  'updateAppCollaborator' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/collaborators/{cid}',
    'method' => 'POST'
  ],

  // #25 Delete a collaborator from an application by id
  'deleteAppCollaborator' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/collaborators/{cid}',
    'method' => 'DELETE'
  ],

  // #26 Verify that a user can execute command on an application
  'verifyUserCommandPermission' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/exec/verify',
    'method' => 'GET'
  ],

  // #27 Get app healthCheck states
  'getAppHealthCheck' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/healthCheck',
    'method' => 'GET'
  ],
    
  // #28 Add a healthCheck to app
  'addAppHealthCheck' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/healthCheck',
    'method' => 'POST'
  ],
    
  // #29 Delete all healthChecks with path=[path]. returns list of deletedHealthChecks
  'deleteAllAppHealthChecks' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/healthCheck',
    'method' => 'DELETE'
  ],
  
  // #30 Update healthCheck by id
  'updateHealthCheckById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/healthCheck/{hid}',
    'method' => 'PUT'
  ],
    
  // #31 Delete healthCheck by id
  'deleteHealthCheckById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/healthCheck/{hid}',
    'method' => 'DELETE'
  ],
    
  // #32 Get real time logs of application by id
  'getRealTimeAppLogsById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/logs',
    'method' => 'GET'
  ],
    
  // #33 Transfer application by id
  'transferAppById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/transfer',
    'method' => 'POST'
  ],
    
  // #34 get list of webhooks for applications
  'getAppWebHooks' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/webhooks',
    'method' => 'GET'
  ],
    
  // #35 Update a webhook from application by i
  'updateWebHookById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/webhooks/{wid}',
    'method' => 'POST'
  ],
    
  // #36 delete a webhook from an application by id
  'deleteAppWebHookById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/{appId}/webhooks/{wid}',
    'method' => 'DELETE'
  ],
    
  // #38 Get application by name
  'getApplicationByName' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/byName/{appName}',
    'method' => 'GET'
  ],
    
  // #39 create new applications with docker compose file
  'createAppByDockerCompose' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/group',
    'method' => 'POST'
  ],
      
  // // #40 get group with name
  // 'getGroupByName' => [
  //   'baseUri' => 'SAKKU-API-ADDRESS',
  //   'subUri' => 'app/group/{groupName}',
  //   'method' => 'GET'
  // ],
    
  // #41 create new pipeline on sakku
  'createPipeline' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/pipeline',
    'method' => 'POST'
  ],
    
  // #42 create new application on sakku with new state machine mechanism
  'createAppByStateMachine' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/sm',
    'method' => 'POST'
  ],
    
  // #43 Get list of user application[s] status
  'getUserAppsStatusList' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/status',
    'method' => 'GET'
  ],
    
  // #44 stop deploy application process
  'stopAppDeployWithQueueId' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/stopDeploying',
    'method' => 'GET'
  ],
  
  // #45
  'getAllCatalogs' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog',
    'method' => 'GET'
  ],

  // #46
  'createCatalogApp' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/{catalogId}/create',
    'method' => 'POST'
  ],
  
  // #47
  'createCatalogAppBySakkuApp' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/{catalogId}/create/fromApplication',
    'method' => 'POST'
  ],
  
  // #48
  'updateCatalog' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/{catalogAppId}/update',
    'method' => 'PUT'
  ],
  
  // #49
  'getCatalogApp' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/{catalogId}/{catalogAppId}',
    'method' => 'GET'
  ],
  
  // #50
  'getAllCatalogAppById' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/{catalogId}',
    'method' => 'GET'
  ],
  
  // #51
  'getUserFeedbackCatalog' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/feedback',
    'method' => 'GET'
  ],
  
  // #52
  'addUserFeedbackCatalogs' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/feedback',
    'method' => 'POST'
  ],
  
  // #53
  'getAllMetaData' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/metadata',
    'method' => 'GET'
  ],
  
  // #54
  'validateMetaData' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/metadata/validate',
    'method' => 'POST'
  ],
  
  // #55
  'deployAppFromCatalog' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/deploy/{catalogAppId}',
    'subUriTest' => 'catalog/deploy/{catalogAppId}/test',
    'method' => 'POST'
  ],

  // #55Test
  'deployAppFromCatalogTest' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'catalog/deploy/{catalogAppId}/test',
    'method' => 'POST'
  ],
  
  // #56
  'addDomain' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/app/{appId}/addDomain',
    'method' => 'POST'
  ],

  // #57
  'getAllUserDomains' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain',
    'method' => 'GET'
    ],
  
  // #58
  'getAppDomains' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/app/{appId}',
    'method' => 'GET'
  ],
  
  // #59
  'removeDomain' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/app/{appId}',
    'method' => 'DELETE'
  ],
  
  // #60
  'addBasicAuthUsers' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/app/{appId}/basicAuthentication',
    'method' => 'POST'
  ],
  
  // #61
  'getBasicAuthUsers' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/app/{appId}/basicAuthentication',
    'method' => 'GET'
  ],
  
  // #62
  'deleteBasicAuthUsers' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/app/{appId}/basicAuthentication/{basicAuthId}',
    'method' => 'DELETE'
  ],
  
  // #63 get records of user domains
  'getDomainRecords' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/record',
    'method' => 'GET'
  ],
  
  // #64 add record to domain
  'addDomainRecord' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/record',
    'method' => 'POST'
  ],
  
  // #65 update record of domain
  'updateDomainRecord' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/record',
    'method' => 'PUT'
  ],
  
  // #66
  'deleteDomainRecord' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/record',
    'method' => 'DELETE'
  ],
  
  // #67
  'getNetworks' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'app/network',
    'method' => 'GET'
    ],

  // #68
  'createNetwork' => [
  'baseUri' => 'SAKKU-API-ADDRESS',
  'subUri' => 'app/network/create',
  'method' => 'POST'
  ],
  
  // #69
  'addAppToNetwork' => [
  'baseUri' => 'SAKKU-API-ADDRESS',
  'subUri' => 'app/network/{name}/addApp',
  'method' => 'POST'
  ],
  
  // #70
  'removeAppFromNetwork' => [
  'baseUri' => 'SAKKU-API-ADDRESS',
  'subUri' => 'app/network/{name}/removeApp',
  'method' => 'POST'
  ],
  
  // #71
  'deleteNetworkByUser' => [
  'baseUri' => 'SAKKU-API-ADDRESS',
  'subUri' => 'app/network/{name}',
  'method' => 'DELETE'
  ], 
  
   // #72
   'getAvailablePortOptions' => [
    'baseUri' => 'SAKKU-API-ADDRESS',
    'subUri' => 'domain/options',
    'method' => 'GET'
    ], 
    
];

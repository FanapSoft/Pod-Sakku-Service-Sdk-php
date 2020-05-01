<?php
namespace Pod\Sakku\Service;
use Pod\Base\Service\ApiRequestHandler;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Pod\Base\Service\Exception\PodException;
use Pod\Base\Service\Exception\RequestException;

Class SakkuApiRequestHandler extends ApiRequestHandler {
    /**
     * @param string $baseUri
     * @param string $method
     * @param string $relativeUri
     * @param array $option
     * @param string $saveTo
     *
     * @return mixed
     *
     * @throws ClientException
     * @throws GuzzleException
     * @throws PodException
     */
    public static function logRequest($baseUri, $method, $relativeUri, $option, $saveTo = '') {
        $clientConfig = [
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'  => 30.0,
        ];
        if (!empty($saveTo)){
            $clientConfig['sink'] = $saveTo;
        }
        $client = new Client($clientConfig);

        try {
            $response = $client->request($method, $relativeUri, $option);
            if (empty($saveTo)){
                return $response->getBody()->getContents();
            }
        }
        catch (ClientException $e) {
            // echo Psr7\str($e->getRequest());
            $message = $e->getMessage();
            $code = $e->getCode();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $code = $response->getStatusCode();
                $responseBody = json_decode($response->getBody()->getContents(), true);
                $message = (isset($responseBody['message']) && !empty($responseBody['message'])) ? $responseBody['message'] : $message;
                throw new RequestException($message, $code, null, $responseBody);
            }

            $code = !isset($code)? RequestException::SERVER_CONNECTION_ERROR : $code;
            $message  = empty($message)? 'Connection Interrupt! please try again later.' : $message;
            throw new RequestException($message, $code);
        } catch (GuzzleException $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $code = $response->getStatusCode();
                $responseBody = json_decode($response->getBody()->getContents(), true);
                $message = (isset($responseBody['message']) && !empty($responseBody['message'])) ? $responseBody['message'] : $message;
                throw new RequestException($message, $code, null, $responseBody);
            }
            else {
                throw new PodException($message, $code);
            }
        }
    }

    /**
     * @param string $baseUri
     * @param string $method
     * @param string $relativeUri
     * @param array $option
     * @param bool $optionHasArray
     * @param bool $restFull
     *
     * @return mixed
     *
     * @throws ClientException
     * @throws GuzzleException
     * @throws PodException
     */
    public static function Request($baseUri, $method, $relativeUri, $option, $restFull = false, $optionHasArray = false) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'  => 30.0,
        ]);

        try {
            $response = $client->request($method, $relativeUri, $option);
        }
        catch (ClientException $e) {
            // echo Psr7\str($e->getRequest());
            $message = $e->getMessage();
            $code = $e->getCode();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $code = $response->getStatusCode();
                $responseBody = json_decode($response->getBody()->getContents(), true);
                $message = (isset($responseBody['message']) && !empty($responseBody['message'])) ? $responseBody['message'] : $message;
                throw new RequestException($message, $code, null, $responseBody);
            }

            $code = !isset($code)? RequestException::SERVER_CONNECTION_ERROR : $code;
            $message  = empty($message)? 'Connection Interrupt! please try again later.' : $message;
            throw new RequestException($message, $code);
        } catch (GuzzleException $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $code = $response->getStatusCode();
                $responseBody = json_decode($response->getBody()->getContents(), true);
                $message = (isset($responseBody['message']) && !empty($responseBody['message'])) ? $responseBody['message'] : $message;
                throw new RequestException($message, $code, null, $responseBody);
            }
            else {
                throw new PodException($message, $code);
            }
        }

        $result = json_decode($response->getBody()->getContents(), true);
        if ((isset($result['error']) && $result['error']) || ($result['code'] >= 300 || $result['code'] < 200)) {
            $message = isset($result['message']) ? $result['message'] :"Some unhandled error has occurred!";
            $errorCode = isset($result['code']) ? $result['code'] : PodException::SERVER_UNHANDLED_ERROR_CODE;
            throw new PodException($message, $errorCode,null , $result);
        }
        return $result;
    }
}
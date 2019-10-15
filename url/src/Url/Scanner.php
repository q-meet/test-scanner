<?php
namespace Url;

class Scanner
{
    /**
     * @var
     */
    protected $urls;

    /**
     * @var
     */
    protected $httpClient;

    /**
     * Scanner constructor.
     * @param array $urls
     */
    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     *
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                array_pusj($invalidUrls, [
                    'url' => $url,
                    'status' => $statusCode
                ]);
            }
        }
    }

    /**  
     * @param $url
     * @return mixed
     */
    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->options($url);

        return $httpResponse->getStatusCode();
    }
}
<?php

namespace App\Services\Proxy;

use App\Http\Requests\Proxy\ExportRequest;
use App\Models\Proxy;

/**
 * class ProxyService
 */
class ProxyService
{

    /**
     * @param array $proxies
     * @return mixed
     */
    private function formatData(&$proxies, string $format): mixed
    {
        //(возможные варианты: ip:port@login:password; ip:port; ip; ip@login:password)
        switch ($format) {
            case  ExportRequest::IP_PORT_LOGIN_PASS_FORMAT :
            default:
                $collection = $proxies->map(function ($item) {
                    return $item->ip . ':' . $item->port . '@' . $item->login . ':' . $item->password;
                });
                break;
            case  ExportRequest::IP_PORT_FORMAT :
                $collection = $proxies->map(function ($item) {
                    return $item->ip . ':' . $item->port;
                });
                break;
            case  ExportRequest::IP_LOGIN_PASS_FORMAT :
                $collection = $proxies->map(function ($item) {
                    return $item->ip . '@' . $item->login . ':' . $item->password;
                });
                break;
            case  ExportRequest::IP_FORMAT :
                $collection = $proxies->map(function ($item) {
                    return $item->ip;
                });
                break;
        }

        return $collection->toArray();
    }

    /**
     * @param string $format
     * @return array
     */
    public function getExportData(string $format): array
    {
        $proxies = Proxy::query()
            ->with('provider')
            ->actived()
            ->get();

        return $this->formatData($proxies, $format);
    }
}

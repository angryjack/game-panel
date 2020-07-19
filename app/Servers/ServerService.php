<?php

namespace App\Services;

use App\Models\Server;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use xPaw\SourceQuery\Exception\InvalidArgumentException;
use xPaw\SourceQuery\Exception\InvalidPacketException;
use xPaw\SourceQuery\Exception\TimeoutException;
use xPaw\SourceQuery\SourceQuery;

class ServerService
{
    /**
     * @var SourceQuery
     */
    private $sourceQuery;

    public function __construct(SourceQuery $sourceQuery)
    {
        $this->sourceQuery = $sourceQuery;
    }

    /**
     * Возвращает список серверов.
     *
     * @return mixed
     */
    public function get()
    {
        return Server
            ::select(['id', 'hostname', 'address'])
            ->get();
    }

    /**
     * Возвращает сервер с привилегиями.
     *
     * @param $id
     * @return Server
     */
    public function getByIdWithPrivileges($id): Server
    {
        return Server
            ::where('id', $id)
            ->with(['privileges' => function ($query) {
                $query->where('status', 1);
            }])
            ->first();
    }

    /**
     * Возвращает все сервера и все привилегии.
     *
     * @return Server[]|Builder[]|Collection
     */
    public function getAllWithPrivileges()
    {
        return Server
            ::with('privileges.rates')
            ->get()
            ->keyBy('id');
    }

    /**
     * Возвращает список серверов с полной информацией о них.
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws InvalidPacketException
     * @throws TimeoutException
     */
    public function getAllWithInformation()
    {
        $servers = $this->get();

        foreach ($servers as $index => $server) {
            $this->getWithInformation($server);
        }

        return $servers;
    }

    /**
     * Возвращает сервер с информацией об игроках и сервере.
     *
     * @param Server $server
     * @return Server
     * @throws InvalidArgumentException
     * @throws InvalidPacketException
     * @throws TimeoutException
     */
    public function getWithInformation(Server $server): Server
    {
        $queryResult = $this->getSourceQueryInformation($server);
        $server->players = $queryResult['players'];
        $server->info = $queryResult['info'];

        return $server;
    }

    /**
     * Выполняет запрос информации о сервере.
     *
     * @param Server $server
     * @return array
     * @throws InvalidArgumentException
     * @throws InvalidPacketException
     * @throws TimeoutException
     */
    public function getSourceQueryInformation(Server $server): array
    {
        $info = $players = [];
        try {
            $this->sourceQuery->Connect(
                $this->getServerIp($server),
                $this->getPort($server),
                1,
                $this->sourceQuery::GOLDSOURCE
            );
            $players = $this->sourceQuery->GetPlayers() ?? [];
            $info = $this->sourceQuery->GetInfo() ?? [];
        } catch (\Exception $e) {
            // игнорируем ошибки
        } finally {
            $this->sourceQuery->Disconnect();
        }

        return compact('info', 'players');
    }

    /**
     * Возвращает IP адрес сервера.
     *
     * @param Server $server
     * @return string
     */
    private function getServerIp(Server $server): string
    {
        $ip = '';
        if (strpos($server->address, ':')) {
            $ip = explode(':', $server->address)[0];
        }
        return $ip;
    }
    /**
     * Возвращает порт сервера.
     *
     * @param Server $server
     * @return string
     */
    private function getPort(Server $server): string
    {
        $port = '';
        if (strpos($server->address, ':')) {
            $port = explode(':', $server->address)[1];
        }
        return $port;
    }
}

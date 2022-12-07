<?php

namespace App\Http\Controllers;

use App\Http\Requests\Proxy\ExportRequest;
use App\Http\Requests\Proxy\IndexRequest;
use App\Http\Requests\Proxy\StoreRequest;
use App\Http\Resources\ProxyResource;
use App\Models\Proxy;
use App\Services\Proxy\ProxyService;
use League\Csv\Writer as CsvWriter;

/**
 * Class ProxyController
 */
class ProxyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        $proxies = Proxy::query()
            ->with('provider')
            ->actived()
            ->paginate($request->get('per_page', 20));

        return ProxyResource::collection($proxies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\API\ProxyRequest $request
     * @return ProxyResource
     */
    public function store(StoreRequest $request)
    {
        return new ProxyResource(Proxy::create($request->validated()));
    }

    /**
     * @param Proxy $proxy
     * @return ProxyResource
     */
    public function show(Proxy $proxy)
    {
        return ProxyResource::make($proxy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @param Proxy $proxy
     * @return ProxyResource
     */
    public function update(StoreRequest $request, Proxy $proxy)
    {
        $proxy->update($request->validated());

        return ProxyResource::make($proxy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Proxy $proxy
     * @return void
     */
    public function destroy(Proxy $proxy)
    {
        $proxy->delete();
    }

    /**
     * @param ExportRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \League\Csv\CannotInsertRecord
     */
    public function export(ExportRequest $request)
    {
        $csv = CsvWriter::createFromFileObject(new \SplTempFileObject);

        foreach ((new ProxyService())->getExportData($request->get('format')) as $item) {
            $csv->insertOne([$item]);
        }

        return response((string)$csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Disposition' => 'attachment; filename="proxies.csv"',
        ]);
    }
}

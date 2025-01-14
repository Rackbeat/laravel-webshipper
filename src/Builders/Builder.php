<?php

namespace Webshipper\Builders;

use Webshipper\Utils\Model;
use Webshipper\Utils\Request;

class Builder
{
    protected $entity;
    /** @var Model */
    protected $model;
    protected $type;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $filters
     * @return mixed
     * @throws \Webshipper\Exceptions\WebshipperClientException
     * @throws \Webshipper\Exceptions\WebshipperRequestException
     */
    public function get($filters = [])
    {
        $urlFilters = $this->parseFilters($filters);

        return $this->request->handleWithExceptions(function () use ($urlFilters) {
            $response = $this->request->client->get("{$this->entity}{$urlFilters}");
            $responseData = json_decode((string)$response->getBody());
            $items = collect([]);

            foreach ($responseData->data as $item) {
                /** @var Model $model */
                $model = new $this->model($item);
                $items->push($model);
            }

            return $items;
        });
    }

    protected function parseFilters($filters = [])
    {
        $urlFilters = '';

        if (count($filters) > 0) {
            $filters = array_unique($filters, SORT_REGULAR);

            $i = 1;
            $urlFilters .= '?';
            foreach ($filters as $filter) {
                $urlFilters .= 'filter[' . $filter[0] . '][value]=' . urlencode($filter[2]);
                $urlFilters .= '&filter[' . $filter[0] . '][operator]=' . urlencode($filter[1]);

                if (count($filters) > $i) {
                    $urlFilters .= '&';
                }

                $i++;
            }
        }

        return $urlFilters;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Webshipper\Exceptions\WebshipperClientException
     * @throws \Webshipper\Exceptions\WebshipperRequestException
     */
    public function find($id)
    {
        return $this->request->handleWithExceptions(function () use ($id) {
            $response = $this->request->client->get("{$this->entity}/{$id}");
            $responseData = json_decode((string)$response->getBody());

            return new $this->model($responseData->data);
        });
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Webshipper\Exceptions\WebshipperClientException
     * @throws \Webshipper\Exceptions\WebshipperRequestException
     */
    public function create($data)
    {
        return $this->request->handleWithExceptions(function () use ($data) {
            $request = [
                'data' => [
                    'type' => $this->type,
                ],
            ];

            if(array_key_exists('relationships', $data)) {
                $request['data']['relationships'] = $data['relationships'];
            }

            if(array_key_exists('attributes', $data)) {
                $request['data']['attributes'] = $data['attributes'];
            }

            $response = $this->request->client->post("{$this->entity}", [
                'json' => $request,
                'headers' => [
                    'Content-Type' => 'application/vnd.api+json; charset=utf8',
                ],
            ]);

            $responseData = json_decode((string)$response->getBody());

            return new $this->model($responseData->data);
        });
    }

    public function delete($id)
    {
        return $this->request->handleWithExceptions(function () use ($id) {
            return $this->request->client->delete("{$this->entity}/{$id}");
        });
    }

    public function update($id, $data = [])
    {
        return $this->request->handleWithExceptions(function () use ($id, $data) {
            $request = [
                'data' => [
                    'id' => $id,
                    'type' => $this->type,
                ],
            ];

            if(in_array('relationships', $data)) {
                $request['data']['relationships'] = $data['relationships'];
            }

            if(in_array('attributes', $data)) {
                $request['data']['attributes'] = $data['attributes'];
            }

            $response = $this->request->client->patch("{$this->entity}/{$id}", [
                'json' => $request,
                'headers' => [
                    'Content-Type' => 'application/vnd.api+json; charset=utf8',
                ],
            ]);

            $responseData = json_decode((string)$response->getBody());

            return new $this->model($responseData->data);
        });
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity($new_entity)
    {
        $this->entity = $new_entity;

        return $this->entity;
    }
}

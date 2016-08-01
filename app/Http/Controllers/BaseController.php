<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Contracts\Validation\Validator;
use DB;
use App\Transformers\NoDataSerializer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Illuminate\Pagination\Paginator;
use Auth;
use Input;
use Clockwork;

class BaseController extends Controller
{
    use Helpers;

    public $limit;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->limit = ($request->get('limit') ? $request->get('limit') : config('mm.page_limit'));
    }

    public function throwStoreResourceFailedException($message='Failed to store your requested resource.', Validator $validator=null)
    {
        if ($validator instanceof Validator) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException($message, $validator->error());
        } else {
            throw new \Dingo\Api\Exception\StoreResourceFailedException($message);
        }
    }

    public function throwResourceException($message='Failed to process your requested resource.')
    {
        throw new \Dingo\Api\Exception\ResourceException($message);
    }

    protected function socialValidateOrFail($data, $validationRules, $options=[])
    {
        $validator = app('validator')->make($data, $validationRules);

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
    }

    protected function validateOrFail($data, $validationRules, $options=[])
    {
        if ($this->auth->user()) {
            $data['user_id'] = $this->auth->user()->id; // Get User id from User Resolver
        }

        $validator = app('validator')->make($data, $validationRules, $options);

        if ($validator->fails()) {
            $message = (isset($options['message']) ? $options['message']:'Could not process your request, following are the errors.');
            throw new ValidationHttpException($validator->errors()->all());
        }
    }

    protected function getAuthenticatedUserId()
    {
        if (null !== $this->auth->user() && isset($this->auth->user()->id)) {
            return $this->auth->user()->id;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('Unable to get authenticated user info.', 'Unable to get authenticated user info.');
        }
    }

    public function debugQueries()
    {
        if (app()->environment('local')) {
            DB::listen(function($sql, $bindings) {
                var_dump($sql);
                var_dump($bindings);
            });
        }
    }


    public function respondWithCollectionJson($collection, TransformerAbstract $transformer, $include = null)
    {
      //  Clockwork::startEvent('respond_with_collection_json', 'Respond With CollectionJSON');

        $response = [
            'collection' => [
                'version' => '1.0',
                'href' => $this->request->url(),
            ]
        ];

        if ($this->collectionRouteName) {
            $response['collection']['links'] = [
                [
                    'rel' => 'queries',
                    'href' => route(
                            $this->collectionRouteName,
                            $this->collectionRouteReplacements
                        ) . '?queries'
                ],
                [
                    'rel' => 'template',
                    'href' => route(
                            $this->collectionRouteName,
                            $this->collectionRouteReplacements
                        ) . '?template'
                ]
            ];
        }

        if ($collection instanceof Paginator || $collection instanceof LengthAwarePaginator) {
            if ($collection->previousPageUrl() !== null) {
                $response['collection']['links'][] = ['rel' => 'prev', 'href' => $collection->previousPageUrl()];
            }

            if ($collection->nextPageUrl() !== null) {
                $response['collection']['links'][] = ['rel' => 'next', 'href' => $collection->nextPageUrl()];
            }
            if ($collection->count() !== null) {
                $response['collection']['pagination']['count_of_items_on_page'] = $collection->count();
                $response['collection']['pagination']['has_more_pages'] = $collection->hasMorePages();
                $response['collection']['pagination']['per_page'] = $collection->perPage();
            }
            if ($collection instanceof LengthAwarePaginator) {
                $response['collection']['total_items'] = $collection->total();
            }
        }

        $fractal = new Manager();
        $fractal->setSerializer(new NoDataSerializer);

        // \Log::debug("I am Inside Api Controller includes = "+$include);
        if ($include) {

            $fractal->parseIncludes($include);
        }

        Clockwork::startEvent('parse_collection', 'Parse Collection');

        $response['collection']['items'] = [];
        foreach ($collection as $entity) {
            $item = [];

            $href = $this->getCollectionJsonItemHref($entity);
            if (!is_null($href)) {
                $item['href'] = $href;
            }

            $resource = new Item($entity, $transformer);
            $item['data'] = $fractal->createData($resource)->toArray();

            $item['links'] = $this->getCollectionJsonItemLinks($entity);

            $response['collection']['items'][] = $item;
        }

      //  Clockwork::endEvent('parse_collection');

        return $this->respond($response);
    }

}



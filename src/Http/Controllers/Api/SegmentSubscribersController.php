<?php

declare(strict_types=1);

namespace Sendportal\Base\Http\Controllers\Api;

use Sendportal\Base\Http\Controllers\Controller;
use Sendportal\Base\Http\Requests\Api\SegmentSubscriberDestroyRequest;
use Sendportal\Base\Http\Requests\Api\SegmentSubscriberStoreRequest;
use Sendportal\Base\Http\Requests\Api\SegmentSubscriberUpdateRequest;
use Sendportal\Base\Http\Resources\Subscriber as SubscriberResource;
use Sendportal\Base\Repositories\SegmentTenantRepository;
use Sendportal\Base\Services\Segments\ApiSegmentSubscriberService;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SegmentSubscribersController extends Controller
{
    /** @var SegmentTenantRepository */
    private $segments;

    /** @var ApiSegmentSubscriberService */
    private $apiService;

    public function __construct(
        SegmentTenantRepository $segments,
        ApiSegmentSubscriberService $apiService
    ) {
        $this->segments = $segments;
        $this->apiService = $apiService;
    }

    /**
     * @throws Exception
     */
    public function index(int $teamId, int $segmentId): AnonymousResourceCollection
    {
        $segment = $this->segments->find($teamId, $segmentId, ['subscribers']);

        return SubscriberResource::collection($segment->subscribers);
    }

    /**
     * @throws Exception
     */
    public function store(SegmentSubscriberStoreRequest $request, int $teamId, int $segmentId): AnonymousResourceCollection
    {
        $input = $request->validated();

        $subscribers = $this->apiService->store($teamId, $segmentId, collect($input['subscribers']));

        return SubscriberResource::collection($subscribers);
    }

    /**
     * @throws Exception
     */
    public function update(SegmentSubscriberUpdateRequest $request, int $teamId, int $segmentId): AnonymousResourceCollection
    {
        $input = $request->validated();

        $subscribers = $this->apiService->update($teamId, $segmentId, collect($input['subscribers']));

        return SubscriberResource::collection($subscribers);
    }

    /**
     * @throws Exception
     */
    public function destroy(SegmentSubscriberDestroyRequest $request, int $teamId, int $segmentId): AnonymousResourceCollection
    {
        $input = $request->validated();

        $subscribers = $this->apiService->destroy($teamId, $segmentId, collect($input['subscribers']));

        return SubscriberResource::collection($subscribers);
    }
}

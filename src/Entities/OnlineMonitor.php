<?php

namespace Holger\Entities;

use Holger\Values\Byte;

class OnlineMonitor extends \ArrayObject implements \JsonSerializable
{

    /**
     * Return the maximum available downstream in Bytes
     *
     * @return Byte
     */
    public function maxDownstream()
    {
        return Byte::fromBytes((int)$this['Newmax_ds']);
    }

    /**
     * Get the maximum used downstream in the last 100 seconds
     *
     * @return Byte
     */
    public function maxUsedDownstream()
    {
        return Byte::fromBytes(max(...$this->downstream()));
    }

    /**
     * Get the maximum available upstream in Bytes
     *
     * @return Byte
     */
    public function maxUpstream()
    {
        return Byte::fromBytes((int)$this['Newmax_us']);
    }

    /**
     * Get the maximum used upstream in the last 100 seconds
     *
     * @return Byte
     */
    public function maxUsedUpstream()
    {
        return Byte::fromBytes(max(...$this->upstream()));
    }

    /**
     * The used downstream for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function downstream()
    {
        return $this->valueList($this['Newds_current_bps']);
    }

    /**
     * The used IPTV downstream for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function downstreamIpTv()
    {
        return $this->valueList($this['Newmc_current_bps']);
    }

    /**
     * The used upstream for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function upstream()
    {
        return $this->valueList($this['Newus_current_bps']);
    }

    /**
     * The realtime-application upstream traffic for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function realtimeUpstream()
    {
        return $this->valueList($this['Newprio_realtime_bps']);
    }

    /**
     * The upstream traffic of high priority applications for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function highPriorityUpstream()
    {
        return $this->valueList($this['Newprio_high_bps']);
    }

    /**
     * The used upstream traffic of normal applications for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function defaultUpstream()
    {
        return $this->valueList($this['Newprio_default_bps']);
    }

    /**
     * The used upstream by background tasks for the last 100 seconds in 5 second intervals
     *
     * @return Byte[]
     */
    public function backgroundTaskUpstream()
    {
        return $this->valueList($this['Newprio_low_bps']);
    }

    /**
     * Number of sync groups, i.e. connection types
     *
     * @return int
     */
    public function numberOfSyncGroups()
    {
        return (int)$this['NewTotalNumberSyncGroups'];
    }

    public function jsonSerialize()
    {
        return [
            'max' => [
                'down' => $this->maxDownstream(),
                'up' => $this->maxUpstream(),
            ],
            'downstream' => [
                'total' => $this->downstream(),
                'iptv' => $this->downstreamIpTv(),
            ],
            'upstream' => [
                'total' => $this->upstream(),
                'realtime' => $this->realtimeUpstream(),
                'high-priority' => $this->highPriorityUpstream(),
                'default' => $this->defaultUpstream(),
                'background-tasks' => $this->backgroundTaskUpstream(),
            ],
        ];
    }

    /**
     * Convert a comma separated list string to a byte array
     *
     * @param $listString
     *
     * @return Byte[]
     */
    protected function valueList($listString)
    {
        return array_map(function ($value) {
            return Byte::fromBytes((int)$value);
        }, explode(',', $listString));
    }
}

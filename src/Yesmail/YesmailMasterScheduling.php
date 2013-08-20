<?php
namespace Yesmail;
/**
 * YesmailMasterScheduling
 *
 * A helper class for the scheduling Master element
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailMasterScheduling implements \JsonSerializable {
    public static $MasterSchedulingDeliveryFrequency = array('ONCE', 'HOURLY', 'DAILY', 'CONTINUOUSLY', 'MONTHLY', 'WEEKLY');

    // Required
    public $maxRecipients;
    public $priority;
    public $deliveryStartDateTime;

    // Optional
    public $compileStartDateTime;
    public $compileBeforeDeliveryStart;
    public $allowMultipleDeliveries;
    public $deliverImmediately;
    public $deliveryFrequency;
    public $obeyDeliveryLimits;

    /**
     * Construct a new YesmailMasterScheduling object
     *
     * @param int $maxRecipients The maximum number of recipients that the mailing can be delivered to, must be
     *                           greater than 0.
     * @param int $priority Sets the priority of deliverability for a message master relative to other masters scheduled
     *                      at the same time. Must be between 1 and 100. Default is 1.
     * @param string $deliveryStartDateTime The actual UTC date and time that the mailing starts. For example, if a
     *                                      master is scheduled to start at 3am, but actually starts at 4:15 am, then
     *                                      the deliveryStartDateTime will reflect 4:15 am. deliveryStartDateTime
     *                                      becomes optional if deliverImmediately (see below) is set to true.
     * @param string $compileStartDateTime The date and time on which to start the precompile, based on UTC. This is
     *                                     required if compileBeforeDelivery is set to true and cannot be later than
     *                                     the deliveryStartDateTime
     * @param bool $compileBeforeDeliveryStart true = do a precompile before the mailing starts.
     *                                         false (default) = do not do a precompile.
     * @param bool $allowMultipleDeliveries true = allow for multiple deliveries.(setting this option will disable seedlist deliveries)
     *                                      false (default) = do not allow for multiple deliveries.
     * @param bool $deliverImmediately true (default) = deliver the mailing now
     *                                 false = deliver the mailing when it is scheduled.
     * @param string $deliveryFrequency
     * @param bool $obeyDeliveryLimits true (default) = Obey the company delivery limits.
     *                                 false=Ignore the company delivery limits.
     * @access public
     */
    public function __construct($maxRecipients, $priority, $deliveryStartDateTime, $compileStartDateTime = NULL,
                                    $compileBeforeDeliveryStart = false, $allowMultipleDeliveries = false,
                                    $deliverImmediately = true, $deliveryFrequency = 'ONCE', $obeyDeliveryLimits = true) {

        if (is_int($maxRecipients) === true && $maxRecipients > 0) {
            $this->maxRecipients = $maxRecipients;
        } else {
            $this->maxRecipients = NULL;
        }

        if (is_int($priority) === true && $priority > 0 && $priority <= 100) {
            $this->priority = $priority;
        } else {
            $this->priority = NULL;
        }

        if (is_string($deliveryStartDateTime) === true && strlen($deliveryStartDateTime) > 0) {
            $UTC = new \DateTimeZone("UTC");
            $date = new \DateTime($deliveryStartDateTime, $UTC);

            if ($date !== false) {
                $this->deliveryStartDateTime = $date;
            } else {
                $this->deliveryStartDateTime = NULL;
            }
        } else {
            $this->deliveryStartDateTime = NULL;
        }

        if (is_string($compileStartDateTime) === true && strlen($compileStartDateTime) > 0) {
            $UTC = new \DateTimeZone("UTC");
            $date = new \DateTime($compileStartDateTime, $UTC);
            if ($date !== false) {
                $this->compileStartDateTime = $date;
            } else {
                $this->compileStartDateTime = NULL;
            }
        } else {
            $this->compileStartDateTime = NULL;
        }

        if (is_bool($compileBeforeDeliveryStart) === true) {
            $this->compileBeforeDeliveryStart = $compileBeforeDeliveryStart;
        } else {
            $this->compileBeforeDeliveryStart = NULL;
        }

        if (is_bool($allowMultipleDeliveries) === true) {
            $this->allowMultipleDeliveries = $allowMultipleDeliveries;
        } else {
            $this->allowMultipleDeliveries = NULL;
        }

        if (is_bool($deliverImmediately) === true) {
            $this->deliverImmediately = $deliverImmediately;
        } else {
            $this->deliverImmediately = NULL;
        }

        if (is_string($deliveryFrequency) === true) {
            $valid = false;
            if(in_array($deliveryFrequency, self::$MasterSchedulingDeliveryFrequency) === true) {
                switch ($deliveryFrequency) {
                    case 'ONCE':
                        $valid = true;
                        break;
                    case 'HOURLY':
//                        $valid = ($deliveryFrequency > 0 && $deliveryFrequency <=23 ? true : false );
                        break;
                    case 'DAILY':
//                        $valid = ($deliveryFrequency > 0 && $deliveryFrequency <=23 ? true : false );
                        break;
                    case 'CONTINUOUSLY':
                        break;
                    case 'MONTHLY':
                        break;
                    case 'WEEKLY':
                        break;
                }
            }

            if ($valid === true) {
                $this->deliveryFrequency = $deliveryFrequency;
            } else {
                $this->deliveryFrequency = NULL;
            }
        }

        if (is_bool($obeyDeliveryLimits) === true) {
            $this->obeyDeliveryLimits = $obeyDeliveryLimits;
        } else {
            $this->obeyDeliveryLimits = NULL;
        }

        return;
    }

    /**
     * Validates a scheduling
     *
     * @return bool True if the scheduling is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false;

        if (is_null($this->maxRecipients) === false && is_null($this->priority) === false &&
            is_null($this->compileBeforeDeliveryStart) === false && is_null($this->allowMultipleDeliveries) === false &&
            is_null($this->deliverImmediately) === false && is_null($this->obeyDeliveryLimits) === false
        ) {
            if ($this->deliverImmediately === true || is_null($this->deliveryStartDateTime) === false) {
                if ($this->compileBeforeDeliveryStart === false ||
                    (is_null($this->compileStartDateTime) === false && is_null($this->deliveryStartDateTime) === false &&
                        $this->compileStartDateTime <= $this->deliveryStartDateTime)
                ) {
                    // TODO: deliveryFrequency
                    $ret = true;
                }
            }
        }

        return $ret;
    }

    /**
     * Return a json_encode able version of the object
     *
     * @return object A version of the object that is ready for json_encode
     * @access public
     */
    public function jsonSerialize() {
        $ret = new \stdClass();

        $ret->maxRecipients = $this->maxRecipients;
        $ret->priority = $this->priority;

        if (is_null($this->deliveryStartDateTime) === false) {
            $ret->deliveryStartDateTime = $this->deliveryStartDateTime->format("Y-m-d\TH:i:s");
        }

        if (is_null($this->compileStartDateTime) === false) {
            $ret->compileStartDateTime = $this->compileStartDateTime->format("Y-m-d\TH:i:s");
        }

        $ret->compileBeforeDeliveryStart = $this->compileBeforeDeliveryStart;
        $ret->allowMultipleDeliveries = $this->allowMultipleDeliveries;
        $ret->deliverImmediately = $this->deliverImmediately;
        $ret->deliveryFrequency = $this->deliveryFrequency;
        $ret->obeyDeliveryLimits = $this->obeyDeliveryLimits;

        return $ret;
    }
}

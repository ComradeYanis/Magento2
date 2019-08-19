<?php

namespace Elogic\Vendors\Api\Data;

/**
 * Interface VendorInterface
 * @package Elogic\Vendors\Api\Data
 * @api
 */
interface VendorInterface
{
    // region CONSTANTS
    /**#@+
     * Constants
     * @var string
     */
    const ENTITY_ID     = 'entity_id';
    const NAME          = 'name';
    const DESCRIPTION   = 'description';
    const DATE          = 'date';
    const LOGO          = 'logo';
    //endregion

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * @return string
     */
    public function getDate();

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date);

    /**
     * @return string
     */
    public function getLogo();

    /**
     * @param string $logo
     * @return $this
     */
    public function setLogo(string $logo);
}

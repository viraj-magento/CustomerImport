<?php
/**
 * Copyright © All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Viraj\CustomerImport\Model\Customer;

use Viraj\CustomerImport\Api\ImportInterface;
use Magento\Framework\ObjectManagerInterface;

class CustomProfileFactory
{
    /**
     * Object manager
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * Create class instance with specified parameters
     * @throws \Exception
     */
    public function create(string $type): ImportInterface
    {

        if ($type === "csv") {
            $class = CsvImporter::class;
        } elseif ($type === "json") {
            $class = JsonImporter::class;
        } else {
            throw new \Exception("Unsupported Profile type");
        }
        return $this->objectManager->create($class);
    }
}
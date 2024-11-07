<?php
/**
 * Copyright © All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Viraj\CustomerImport\Api;

use Symfony\Component\Console\Input\InputInterface;

interface ImportInterface
{
    public const FILE_NAME = "profile";
    public const PATH = "filepath";

    /**
     * @param InputInterface $input
     * @return array
     */
    public function getImportData(InputInterface $input): array;

    /**
     * @param string $data
     * @return array
     */
    public function readData(string $data): array;

    /**
     * @param mixed $data
     * @return array
     */
    public function formatData($data): array;

    


}
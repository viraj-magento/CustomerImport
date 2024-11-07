<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Viraj\CustomerImport\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Console\Cli;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Viraj\CustomerImport\Api\ImportInterface;
use Viraj\CustomerImport\Model\Customer\CustomProfileFactory;
// use Viraj\CustomerImport\Model\Customer\CsvImportFactory;
// use Viraj\CustomerImport\Model\Customer\JsonImportFactory;
use Viraj\CustomerImport\Model\Customer;

class CustomerImport extends Command
{

    /**
     * @var State
     */
    private $state;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ImportInterface
     */
    protected $importer;

    /**
     * @var Customer
     */
    private $customer;

    
    /**
     * CustomerImport constructor.
     *
     * @param State $state
     * @param StoreManagerInterface $storeManager
     * @param CustomProfileFactory $profileFactory
     * @param Customer $customer
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        State $state,
        CustomProfileFactory $profileFactory,
        Customer $customer
    ) {
        parent::__construct();
        $this->customer = $customer;
        $this->state = $state;
        $this->storeManager = $storeManager;
        $this->profileFactory = $profileFactory;
    }

    /**
     * @inheritdoc
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $fileType = $input->getArgument(ImportInterface::FILE_NAME);
        $filePath = $input->getArgument(ImportInterface::PATH);
        $output->writeln(sprintf("file type: %s", $fileType));
        $output->writeln(sprintf("file Path: %s", $filePath));

        try {
            $this->state->setAreaCode(Area::AREA_GLOBAL);
            if ($importData = $this->getImporterInstance($fileType)->getImportData($input)) {
                $storeId = (int)$this->storeManager->getStore()->getId();
                $websiteId = (int)$this->storeManager->getStore($storeId)->getWebsiteId();
                
                foreach ($importData as $data) {
                    $this->customer->createCustomer($data, $websiteId, $storeId);
                }

                $output->writeln(sprintf("%s Customers are imported", count($importData)));
                return Cli::RETURN_SUCCESS;
            }

            return Cli::RETURN_FAILURE;
   
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
            return Cli::RETURN_FAILURE;
        }
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName("customer:import");
        $this->setDescription("Import customer with csv or json via CLI");
        $this->setDefinition([
            new InputArgument(ImportInterface::FILE_NAME, InputArgument::REQUIRED, "file name ex: sample-csv"),
            new InputArgument(ImportInterface::PATH, InputArgument::REQUIRED, "path ex: var/import/sample.csv")
        ]);
        parent::configure();
    }

    /**
     * Get class instance according to profile type.
     *
     * @param string $fileType
     * @return ImportInterface
     */
    protected function getImporterInstance($fileType): ImportInterface
    {
        if (!($this->importer instanceof ImportInterface)) {
            $this->importer = $this->profileFactory->create($fileType);
        }
        return $this->importer;
    }
}


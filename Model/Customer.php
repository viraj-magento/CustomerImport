<?php
/**
 * Copyright © All rights reserved.
 * See COPYING.txt for license details.
 */ 
namespace Viraj\CustomerImport\Model;
 
use Magento\Framework\Exception;
use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Viraj\CustomerImport\Model\Import\CustomerImport;
 
class Customer
{
    private $file;
    private $storeManagerInterface;
    private $customerImport;
    private $output;
    
    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        CustomerImport $customerImport  
    ) {
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->customerImport = $customerImport;
    }

    /**
     * @param array $data
     * @param int $websiteId
     * @param int $storeId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function createCustomer(array $data, int $websiteId, int $storeId): void
    {
        try {
            // Customer data array from csv
            $customerData = [
                'email'         => $data['emailaddress'],
                '_website'      => 'base',
                '_store'        => 'default',
                'confirmation'  => null,
                'dob'           => null,
                'firstname'     => $data['fname'],
                'gender'        => null,
                //'group_id'      => 1,
                'lastname'      => $data['lname'],
                'middlename'    => null,
                'prefix'        => null,
                'store_id'      => $storeId,
                'website_id'    => $websiteId,
                'password'      => null,
                'disable_auto_group_change' => 0,
            ];
            
            // save the customer data
            $this->customerImport->importCustomerData($customerData);
        } catch (Exception $e) {
            $this->output->writeln(
                '<error>'. $e->getMessage() .'</error>',
                OutputInterface::OUTPUT_NORMAL
            );
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: abi
 * Date: 23.07.2019
 * Time: 12:40
 */

namespace askommune\VoucherDelivery;


class vouchers
{
    public $voucher_file;
    public $vouchers;
    /**
     * @var \logger
     */
    public $logger;

    /**
     * @param string $log_subdir Identifier for the delivery method, used as sub folder for the log files
     * @param string $voucher_file Voucher file
     * @throws \Exception
     */
    function __construct($log_subdir = 'voucher_delivery', $voucher_file=Null)
    {
        if(empty($voucher_file))
            $voucher_file = __DIR__.'/../vouchers.csv';

        if(!file_exists($voucher_file))
            throw new \Exception('Voucher file not found:'.$voucher_file);
        else
            $this->voucher_file = realpath($voucher_file);
        $this->logger = new \logger($log_subdir);
        $this->load_vouchers();
    }

    /**
     * Load vouchers from file
     */
    function load_vouchers()
    {
        $this->vouchers=explode("\n",trim(file_get_contents($this->voucher_file)));
    }

    /**
     * Write vouchers to file
     */
    function write_vouchers()
    {
        file_put_contents($this->voucher_file, implode("\n",$this->vouchers));
    }

    /**
     * Count vouchers
     * @return int Voucher count
     */
    function voucher_count()
    {
        return count($this->vouchers);
    }

    /**
     * Get a voucher code and remove it from the file
     * @return string Voucher code
     */
    private function extract_voucher()
    {
        $voucher=array_pop($this->vouchers); //Get a code
        $this->write_vouchers();
        return trim($voucher); //Return the voucher code
    }

    /**
     * Get a voucher code
     * @param string $identifier Identifier for the user retrieving the voucher
     * @return string Voucher code
     */
    function get_voucher($identifier)
    {
        $voucher = $this->extract_voucher();
        $this->logger->writelog(array($identifier, $voucher));
        return $voucher;
    }
}
<?php


use PHPUnit\Framework\TestCase;

class GetVoucherTest extends TestCase
{
    public $voucher_file;
    function setUp(): void
    {
        $this->voucher_file = sprintf('%s/../vouchers.csv', __DIR__);
        if(!file_exists($this->voucher_file))
            copy(sprintf('%s/sample_data/test.csv', __DIR__), $this->voucher_file);
        else
            throw new Exception('voucher file exists');
    }

    function testGetVoucher()
    {
        $voucher = get_voucher('test_user', 'test_method');
        $this->assertEquals('voucher2', $voucher);
        //Second voucher
        $voucher = get_voucher('test_user', 'test_method');
        $this->assertEquals('voucher1', $voucher);
        //No vouchers left
        $voucher = get_voucher('test_user', 'test_method');
        $this->assertEquals('', $voucher);
    }

    function testMissingVoucherFile()
    {
        $this->expectException('Exception');
        unlink($this->voucher_file);
        get_voucher('test_user', 'test_method');
    }

    function tearDown(): void
    {
        if(file_exists($this->voucher_file))
            unlink($this->voucher_file);
    }
}
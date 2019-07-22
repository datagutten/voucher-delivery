<?php


use PHPUnit\Framework\TestCase;

class GetVoucherTest extends TestCase
{
    function setUp(): void
    {
        if(!file_exists(sprintf('%s/../vouchers.csv', __DIR__)))
            copy(sprintf('%s/sample_data/test.csv', __DIR__), sprintf('%s/../vouchers.csv', __DIR__));
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

    function tearDown(): void
    {
        unlink(sprintf('%s/../vouchers.csv', __DIR__));
    }
}
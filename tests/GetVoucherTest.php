<?php


use PHPUnit\Framework\TestCase;
use \askommune\VoucherDelivery\vouchers;

class GetVoucherTest extends TestCase
{
    public $voucher_file;
    /**
     * @var vouchers
     */
    public $vouchers;
    function setUp(): void
    {
        $voucher_file = sprintf('%s/sample_data/vouchers.csv', __DIR__);
        copy(sprintf('%s/sample_data/test.csv', __DIR__), $voucher_file);
        $this->vouchers = new vouchers('voucher-test', $voucher_file);
    }

    function testGetVoucher()
    {
        $voucher = $this->vouchers->get_voucher('test_user');
        $this->assertEquals('voucher2', $voucher);
        //Second voucher
        $voucher = $this->vouchers->get_voucher('test_user');
        $this->assertEquals('voucher1', $voucher);
        //No vouchers left
        $voucher = $this->vouchers->get_voucher('test_user');
        $this->assertEquals('', $voucher);
    }

    function testGetVoucherFunction()
    {
        require __DIR__.'/../function.php';
        $voucher = get_voucher('test-user', 'voucher-test', $this->vouchers->voucher_file);
        $this->assertEquals('voucher2', $voucher);
    }

    function testMissingVoucherFile()
    {
        $this->expectException(Exception::class);
        $this->vouchers = new vouchers('voucher-test', '/dev/null/invalid');
        $this->vouchers->get_voucher('test_user');
    }

    function testVoucherSMS()
    {
        copy(sprintf('%s/sample_data/test.csv', __DIR__), sprintf('%s/../vouchers.csv', __DIR__));
        ob_start();
        $_POST['sender'] = 'test';
        require __DIR__.'/../web/sms.php';
        $this->assertEquals('Din kode for Ås kommunes gjestenett er voucher2', ob_get_clean());
        unlink(sprintf('%s/../vouchers.csv', __DIR__));
    }

    function tearDown(): void
    {
        if(file_exists($this->vouchers->voucher_file))
            unlink($this->vouchers->voucher_file);
    }
}
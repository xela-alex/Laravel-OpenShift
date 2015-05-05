<?php

class NgoTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->ngo = Ngo::find(1);
    }

    public function testName()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->name, 'NGO-1');
    }

    public function testNameIsAString()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('string', $ngo->name);
    }

    public function testBanned()
    {
        $ngo = $this->ngo;
        $this->assertEquals((boolean)$ngo->banned, false);
    }

    public function testBannedIsABoolean()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('boolean', (boolean)$ngo->banned);
    }

    public function testDescription()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->description, 'descripcion');
    }

    public function testDescriptionIsAString()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('string', $ngo->description);
    }

    public function testPhone()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->phone, '646464646');
    }

    public function testPhoneIsAString()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('string', $ngo->phone);
    }

    public function testPhoneComplainsWithURLPattern()
    {
        $ngo = $this->ngo;
        $this->assertRegExp('{\d+}', $ngo->phone);
    }

    public function testLogo()
    {
        $ngo = $this->ngo;
        $this->assertNull($ngo->logo);
    }

    public function testActive()
    {
        $ngo = $this->ngo;
        $this->assertEquals((boolean)$ngo->active, true);
    }

    public function testActiveIsABoolean()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('boolean', (boolean)$ngo->active);
    }

    //creditCard
    public function testNumbersAString()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('string', $ngo->numebr);
    }

    public function testNumberComplainsWithURLPattern()
    {
        $ngo = $this->ngo;
        $this->assertRegExp('{/^([4]{1})([0-9]{12,15})$}', $ngo->number);
    }

    public function testHolderName()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->holderName, 'NGO 1');
    }

    public function testHolderNameIsAString()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('string', $ngo->phone);
    }

    public function testBrandName()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->brandName, 'Visa');
    }

    public function testBrandNameIsAString()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('string', $ngo->phone);
    }
    public function testExpirationMonth()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->ExpirationMonth, '10');
    }

    public function testExpirationMonthIsAInteger()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('integer', $ngo->ExpirationMonth);
    }
    public function testExpirationYear()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->ExpirationYear, '2015');
    }

    public function testExpirationYearIsAInteger()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('integer', $ngo->ExpirationYear);
    }
    public function testCVV()
    {
        $ngo = $this->ngo;
        $this->assertEquals($ngo->ExpirationYear, '2015');
    }

    public function testCVVIsAInteger()
    {
        $ngo = $this->ngo;
        $this->assertInternalType('integer', $ngo->cvv);
    }

}

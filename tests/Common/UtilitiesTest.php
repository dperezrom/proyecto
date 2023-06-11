<?php

namespace Tests\Common;

use App\Common\Utilities;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class UtilitiesTest extends TestCase
{
    public function testValidateDate()
    {
        assertTrue(Utilities::validateDate('1987-10-05', 'Y-m-d'));
        assertTrue(Utilities::validateDate('2000-10-30', 'Y-m-d'));
        assertTrue(Utilities::validateDate('2050-05-05', 'Y-m-d'));
        assertTrue(Utilities::validateDate('2023-11-25', 'Y-m-d'));
        assertTrue(Utilities::validateDate('5000-10-05','Y-m-d'));
        assertTrue(Utilities::validateDate('2023/11/25', 'Y/m/d'));
        assertTrue(Utilities::validateDate('5000/10/05','Y/m/d'));

        assertFalse(Utilities::validateDate('1987-30-05','Y-m-d'));
        assertFalse(Utilities::validateDate('1500-30-0','Y-m-d'));
        assertFalse(Utilities::validateDate('1920-0-05','Y-m-d'));
        assertFalse(Utilities::validateDate('1987-hola-05','Y-m-d'));
        assertFalse(Utilities::validateDate('1999999-05-05','Y-m-d'));
        assertFalse(Utilities::validateDate('50-30-0','Y-m-d'));
        assertFalse(Utilities::validateDate('5000-10-05','Y/m/d'));
        assertFalse(Utilities::validateDate('50/30/0','Y/m/d'));
        assertFalse(Utilities::validateDate('1/02/02','Y/m/d'));
    }

    public function testValidateDNI()
    {
        assertTrue(Utilities::validateDNINIE('48904121A'));
        assertTrue(Utilities::validateDNINIE('13115127K'));
        assertTrue(Utilities::validateDNINIE('83555478C'));
        assertTrue(Utilities::validateDNINIE('35306536H'));
        assertTrue(Utilities::validateDNINIE('77989786Y'));

        assertFalse(Utilities::validateDNINIE('48904121B'));
        assertFalse(Utilities::validateDNINIE('xxx'));
        assertFalse(Utilities::validateDNINIE('12345678'));
        assertFalse(Utilities::validateDNINIE('123456789ZZ'));
        assertFalse(Utilities::validateDNINIE('Z34324'));

    }

    public function testValidateNIE()
    {
        assertTrue(Utilities::validateDNINIE('Y2022641N'));
        assertTrue(Utilities::validateDNINIE('X3681259V'));
        assertTrue(Utilities::validateDNINIE('Z0042959T'));
        assertTrue(Utilities::validateDNINIE('X7512153P'));
        assertTrue(Utilities::validateDNINIE('X5054810P'));

        assertFalse(Utilities::validateDNINIE('Z2022641N'));
        assertFalse(Utilities::validateDNINIE('00001AB'));
        assertFalse(Utilities::validateDNINIE('12345678'));
        assertFalse(Utilities::validateDNINIE('123456789ZZ'));
        assertFalse(Utilities::validateDNINIE('Y5054810P'));
    }

    public function testValidateLegalAge()
    {
        assertTrue(Utilities::validateLegalAge('1987-10-05', 'Y-m-d'));
        assertTrue(Utilities::validateLegalAge('2000-10-30', 'Y-m-d'));
        assertTrue(Utilities::validateLegalAge('2005-06-10', 'Y-m-d'));

        assertFalse(Utilities::validateLegalAge('9999-05-05', 'Y-m-d'));
        assertFalse(Utilities::validateLegalAge('9999-06-11', 'Y-m-d'));
        assertFalse(Utilities::validateLegalAge('lolll', 'Y-m-d'));
        assertFalse(Utilities::validateLegalAge('30-OK-20', 'Y-m-d'));
    }
}

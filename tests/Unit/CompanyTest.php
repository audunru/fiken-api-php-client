<?php

namespace audunru\FikenClient\Tests\Unit;

use audunru\FikenClient\Models\Company;
use audunru\FikenClient\Tests\TestCase;

class CompanyTest extends TestCase
{
    public function testItCreatesACompany()
    {
        $company = new Company();

        $this->assertInstanceOf(
            Company::class,
            $company
        );
    }
}
